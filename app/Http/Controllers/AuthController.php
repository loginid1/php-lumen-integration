<?php

namespace App\Http\Controllers;

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
        $this->provider = new GenericProvider([
            'clientId'                  => env('LOGINID_APPID'),
            'clientSecret'              => env('LOGINID_APPSECRET'),
            'redirectUri'               => env('LOGINID_REDIRECT_URI'),
            'urlAuthorize'              => env('LOGINID_URL') . 'hydra/oauth2/auth',
            'urlAccessToken'            => env('LOGINID_URL') . 'hydra/oauth2/token',
            'urlResourceOwnerDetails'   => '',
            'scopes'                    => env('LOGINID_SCOPES')
        ]);
    }

    /**
     * 
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
     * 
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
     * 
     */
    public function refresh(Request $request) {
        $accessToken = $request->session()->get('accessToken');

        // Check for expired access token
        if ($accessToken->hasExpired() === false) {
            return $this->getAccessToken($request, 'refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken()
            ]);
        }

        // No need to refresh
        return response()->json($accessToken);
    }

    /**
     * 
     */
    protected function getAccessToken(Request $request, string $type, array $options) {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $this->provider->getAccessToken($type, $options);
            
            $request->session()->put('accessToken', $accessToken);

            return response()->json($accessToken);
        } catch (IdentityProviderException $exception) {    
            // Failed to get the access token or user details.
            return response()->json([self::ERROR => $exception->getMessage()]);
        }
    }
}
