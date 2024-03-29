<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function profileinfo()
    {
        // $user_id = Auth::id();
        $user_id = auth('sanctum')->user()->id;
        $userinfo = User::where('id', $user_id)->get();
        return response()->json([
            'status' => 200,
            'userinfo' => $userinfo,
        ]);
    }

    public function editprofile($id)
    {
        $user_id = auth('sanctum')->user()->id;
        $user = User::find($id)->where('id', $user_id)->first();
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'There is no User with this id',
            ]);
        }
    }

    public function updateprofile(Request $request, $id)
    {
        if (auth('sanctum')->check()) {
            $currentUser = User::find($id);
            if ($currentUser) {
                $currentUser->name = $request->input('name');
                $currentUser->phone = $request->input('phone');
                $currentUser->nid = $request->input('nid');
                $currentUser->email = $request->input('email');
                $currentUser->gender = $request->input('gender');
                $currentUser->birth_date = $request->input('birth_date');
                $currentUser->father_name = $request->input('father_name');
                $currentUser->mother_name = $request->input('mother_name');
                $currentUser->present_address = $request->input('present_address');
                $currentUser->permanent_address = $request->input('permanent_address');
                $currentUser->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'User Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Please Logged in first',
                ]);
            }
        }
    }
}
