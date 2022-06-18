<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;

class ComplainControllerAdmin extends Controller
{

    public function allComplainList()
    {
        $complains = Complain::orderBy('id', 'DESC')->get();
        if ($complains) {
            return response()->json([
                'status' => 200,
                'complains' => $complains,
            ]);
        } else {
            return response()->json([
                'status' => 421,
                'message' => 'there is no records',
            ]);
        }
    }

    public function allPendingComplain()
    {
        $pendingCases = Complain::where('case_status', '0')->orderBy('id', 'DESC')->get();
        if (count($pendingCases)) {
            return response()->json([
                'status' => 200,
                'pendingCases' => $pendingCases,
            ]);
        } else {
            return response()->json([
                'status' => 421,
                'message' => 'there is no Pending Cases',
            ]);
        }
    }

    public function allCompleatedComplain()
    {
        $CompleatedCases = Complain::where('case_status', '1')->orderBy('id', 'DESC')->get();
        if (count($CompleatedCases)) {
            return response()->json([
                'status' => 200,
                'CompleatedCases' => $CompleatedCases,
            ]);
        } else {
            return response()->json([
                'status' => 421,
                'message' => 'there is no Completed Cases',
            ]);
        }
    }

    public function searchComplain($query)
    {
        // $searchResult = Complain::where('name', 'LIKE', '%'.$query.'%')->get();
        $searchResult = Complain::where('phone', 'LIKE', $query)
            ->orWhere('nid', 'LIKE', $query)->orWhere('case_no', 'LIKE', $query)
            ->orderBy('id', 'DESC')->get();
        if (count($searchResult)) {
            return response()->json([
                'status' => 200,
                'searchResult' => $searchResult,
            ]);
        } else {
            return response()->json([
                'status' => 421,
                'message' => 'No Record found',
            ]);
        }
    }
}
