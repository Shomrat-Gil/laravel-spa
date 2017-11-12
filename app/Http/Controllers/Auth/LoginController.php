<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use App\User;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Authenticate User
     *
     * @param Request $request
     * @return array
     */
    // public function authenticate(Request $request)
     public function authenticate( \App\Http\Requests\LoginRequest $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message'=>'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['message'=>'could_not_create_token'], 500);
        }

        // all good so return the token
        $user = JWTAuth::toUser($token);
        $role = $user->getRole();
        return compact('token','role','user');
        //return response()->json(compact('token'));
    }
    /*
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if(! $token = JWTAuth::attempt($credentials))
            {
                return $this->response->errorUnauthorized('Unable to sign in with those credentials.');
            }
        } catch (JWTException $ex) {
            return $this->response->error('Something went wrong!', 500);
        }

        $user = JWTAuth::toUser($token);
        $role = $user->getRole();
        return compact('token','role','user');
    }
    */

    /**
     * Get user
     *
     * @param  void
     * @return User
     */
    public static function getUser() {      
        $error = null;
        try {
            $user = JWTAuth::parseToken()->toUser();   
            if(!$user) {
                $error = 'User not found';
                //return $self->response->errorNotFound('User not found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex) {
            $error = 'Token is invalid';
        } catch ( \Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            $error = 'Token has expired';  
        } catch ( \Tymon\JWTAuth\Exceptions\TokenBlackListedException $ex) {
            $error = 'Token is blacklisted'; 
        }

        if($error){
            return response()->json(['error' => $error], 401);
        } else{
            return compact('user');
        }
    }

    /**
     * Authenticate Any User Type
     *
     * @param Request $request
     * @return response
     */
     /*
    public function authenticateAny(Request $request)
    {
        $auth = $this->authenticate($request);
       // $user = $this->transformItem($auth['user'], new UserTransformer);

        return $this->response->array(
                array_merge( array_except($auth,['user']), compact('user') )
        )->setStatusCode(200);
    }
    */

    /**
     * Get user
     *
     * @param  void
     * @return User
     */
    public function show(Request $request)
    {
        $data = $request->only('role');
        $user = $this->getUser();
        $role = $user->getRole();
        $user = $this->transformItem($user, new UserTransformer);

        if (!is_null($data['role']) && $data['role'] != $role ) {  
            return response()->json(['error' => "Invalid Credentials"], 401);
        }
        return compact('role','user');
    }
}
