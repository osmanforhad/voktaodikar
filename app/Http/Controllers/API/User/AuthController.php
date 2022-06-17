<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //__User Register method__//
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'phone' => 'required|min:11|max:11|unique:users,phone',
            'password' => 'required|min:8',
            'nid' => 'required|min:10|max:13',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'nid' => $request->input('nid'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $token = $user->createToken($user->phone . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'name' => $user->name,
                'phone' => $user->phone,
                'token' => $token,
                'message' => 'Registerd Successfully!!',
            ]);
        }
    }

    //__User Login method__//
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::where('phone', $request->phone)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            } else {

                $token = $user->createToken($user->phone . '_Token', [''])->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'phone' => $user->phone,
                    'token' => $token,
                    'message' => 'Logged In Successfully!!',
                ]);
            }
        }
    }

    //__User Logout method__//
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged Out Successfully!!',
        ]);
    }

}
