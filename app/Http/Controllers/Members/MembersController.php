<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    public function AddMember(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'occupation' => 'nullable|string|max:255',
            'next_of_kin' => 'nullable|string|max:255',
        ]);

          $validated['created_by'] = Auth::user()->name;
        $member = Members::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Member added successfully',
            'data' => $member
        ], 201);
    }

       public function index()
    {
        $pastors = Members::all();



        return response()->json([
            'status' => 'success',
            'data' => $pastors,
        ]);
    }
}
