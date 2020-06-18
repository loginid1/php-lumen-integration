<?php

namespace App\Http\Controllers;

use \Firebase\JWT\JWT;
use \Illuminate\Http\Request;
use \League\OAuth2\Client\Provider\GenericProvider;
use \League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class AuthController extends Controller
{
    const CODE  = 'code';
    const STATE = 'state';
    const ERROR = 'error';

    /**
     *
     */
    private $provider;

    /**
     *
     */
    public function __construct() {
        $URI = env('LOGINID_URI');
        $URI = substr($URI, -1) === '/' ? $URI : "$URI/";

        $this->provider = new GenericProvider([
            'clientId'                  => env('LOGINID_APPID'),
            'clientSecret'              => env('LOGINID_APPSECRET'),
            'redirectUri'               => env('LOGINID_REDIRECT_URI'),
            'urlAuthorize'              => $URI . 'hydra/oauth2/auth',
            'urlAccessToken'            => $URI . 'hydra/oauth2/token',
            'urlResourceOwnerDetails'   => $URI . 'hydra/userinfo',
            'scopes'                    => env('LOGINID_SCOPES')
        ]);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        // Fetch the authorization URL from the provider; this returns the
        // urlAuthorize option and generates and applies any necessary parameters
        // (e.g. state).
        $authorizationUrl = $this->provider->getAuthorizationUrl();

        // Get the state generated for you and store it to the session.
        $request->session()->put(self::STATE, $this->provider->getState());

        // Redirect the user to the authorization URL.
        return redirect()->to($authorizationUrl);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Laravel\Lumen\Application
     */
    public function callback(Request $request) {
        $requestState = $request->input(self::STATE);
        $sessionState = $request->session()->get(self::STATE);

        // Check given state against previously stored one to mitigate CSRF attack
        if (empty($requestState) || ($requestState !== $sessionState)) {

            $request->session()->forget(self::STATE);
            return response()->json([self::ERROR => 'Invalid State']);
        } else {
            return $this->getAccessToken($request, 'authorization_code', [
                'code' => $request->input(self::CODE)
            ]);
        }
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request) {
        $accessToken = $request->session()->get('accessToken');

        if (empty($accessToken)) {
            return response()->json([self::ERROR => 'No token information to be refreshed']);
        }

        // Check for expired access token
        if ($accessToken->hasExpired()) {
            return $this->getAccessToken($request, 'refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken()
            ]);
        }

        // No need to refresh
        return response()->json($accessToken);
    }

    /**
     * @param Request $request
     * @param string $type
     * @param array $options
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Laravel\Lumen\Application
     */
    protected function getAccessToken(Request $request, string $type, array $options) {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $this->provider->getAccessToken($type, $options);

            $request->session()->put('accessToken', $accessToken);

            $token = explode('.', $accessToken->getValues()['id_token']);
            list($header64, $body64, $crypto64) = $token;
            $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($body64));

            return view('main', ['name' => $payload->sub]);
        } catch (IdentityProviderException $exception) {
            // Failed to get the access token or user details.
            return response()->json([self::ERROR => $exception->getMessage()]);
        }
    }
}
