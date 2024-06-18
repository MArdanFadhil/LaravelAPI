<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username=' => 'required',
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['username'] = $user->$username;

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Register',
            'data' => $success
        ]);
    }
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessage([
                'email' => ['The provided credentials are correct'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;
    }


    public function me(Request $request)
{
    return response()->json($request->user());
}

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
        ]);

    }
}
