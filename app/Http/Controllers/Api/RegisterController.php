<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'contact_no' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success =  $user->createToken('MyApp');
        $token = $success->accessToken->token;
        return response()->json(['success' => $token], 200); 
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (auth()->attempt(['username' => $request['username'], 'password' => $request['password']])) {
            $user = Auth::user();
            // dd($user);
            $accessToken = $user->createToken('MyApp');
            $token = $accessToken->accessToken->token;
            // dd($token);
            return response()->json([ 'success' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
