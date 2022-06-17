<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;

class CaseSummeryController extends Controller
{

    public function pendingCase()
    {
        if (auth('sanctum')->check()) {
            $LoggedinUser_id = auth('sanctum')->user()->id;
            $pending_cases = Complain::where('user_id', $LoggedinUser_id)->where('case_status', '0')->orderBy('id', 'DESC')->get();
            return response()->json([
                'status' => 200,
                'expenses' => $pending_cases,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please Logged in first',
            ]);
        }
    }

    public function previousCase()
    {
        if (auth('sanctum')->check()) {
            $LoggedinUser_id = auth('sanctum')->user()->id;
            $pending_cases = Complain::where('user_id', $LoggedinUser_id)->where('case_status', '1')->orderBy('id', 'DESC')->get();
            return response()->json([
                'status' => 200,
                'expenses' => $pending_cases,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please Logged in first',
            ]);
        }
    }
}
