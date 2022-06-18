<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ComplainController extends Controller
{
    public function createcomplain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'nid' => 'required',
            'organization_name' => 'required',
            'product_name' => 'required',
            'product_photo' => 'required',
            'invoice_photo' => 'required',
            'department' => 'required',
            'subDepartment' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'district_id' => 'required',
            'division_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            //check the user is loggedin or not
            if (auth('sanctum')->check()) {
                $LoggedinUser_id = auth('sanctum')->user()->id;

                date_default_timezone_set('Asia/Dhaka');
                $date = Carbon::createFromFormat('F j, Y g:i:a', date('F j, Y g:i:a'));
                $currentDate = $date->format('F j, Y g:i:a');
                $generate_case_no = 'vokta_complain' . rand(1111, 9999);

                $complain = new Complain();
                $complain->name = $request->input('name');
                $complain->user_id = $LoggedinUser_id;
                $complain->phone = $request->input('phone');
                $complain->nid = $request->input('nid');
                $complain->email = $request->input('email');
                $complain->product_name = $request->input('product_name');
                $complain->organization_name = $request->input('organization_name');
                if ($request->hasFile('product_photo')) {
                    $file = $request->file('product_photo');
                    $extension = $file->getClientOriginalExtension();
                    $ProductPhotofileName = time() . '.' . $extension;
                    $file->move('uploads/product/', $ProductPhotofileName);
                    $complain->product_photo = $ProductPhotofileName;
                }
                if ($request->hasFile('invoice_photo')) {
                    $file = $request->file('invoice_photo');
                    $extension = $file->getClientOriginalExtension();
                    $InvoicePhotofileName = time() . '.' . $extension;
                    $file->move('uploads/invoice/', $InvoicePhotofileName);
                    $complain->invoice_photo = $InvoicePhotofileName;
                }
                $complain->department = $request->input('department');
                $complain->subDepartment = $request->input('subDepartment');
                $complain->subject = $request->input('subject');
                $complain->description = $request->input('description');
                $complain->case_no = $generate_case_no;
                $complain->apply_date = $currentDate;
                $complain->case_status = $request->input('case_status');
                $complain->district_id = $request->input('district_id');
                $complain->division_id = $request->input('division_id');
                $complain->case_status = '0';
                $complain->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'complain submitted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Please Logged in first',
                ]);
            }
        }
    }

    public function searchComplain($query)
    {
        if (auth('sanctum')->check()) {
            $LoggedinUser_id = auth('sanctum')->user()->id;
            $searchResult = Complain::where('user_id', $LoggedinUser_id)->where('phone', 'LIKE', $query)
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
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please Logged in first',
            ]);
        }
    }
}
