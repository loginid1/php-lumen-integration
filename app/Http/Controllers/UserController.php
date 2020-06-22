<?php

namespace App\Http\Controllers;

use App\User;
use \Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Laravel\Lumen\Application
     */
    public function update(Request $request, $id) {
        try{
            //Find the user object from model
            $user = User::find($id);

            //Set user object attributes
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
    
            // Save/update user.
            $user->save();
    
            return view('profile', 
            [   
                'user' => $user,
                'message' => 'Your data is updated successfully!'
            ]);
        }
        catch(ModelNotFoundException $exception){
            // Failed to update user data.
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

}