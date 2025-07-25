<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BranchController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'branch_name' => 'required|unique:branches',
        'region' => 'required',
        'type' => 'required', // Ensure type is either head or sub
        'district' => 'required',
        'town' => 'required',
        'area_head' => 'required',
        'telephone' => 'required',
        'email' => 'required|email|unique:branches',
        'address' => 'required',
        'status' => 'required|in:active,inactive',
    ]);

    // Convert region & district objects to string values
$validated['region'] = is_array($validated['region']) ? $validated['region']['value'] : $validated['region'];
$validated['district'] = is_array($validated['district']) ? $validated['district']['value'] : $validated['district'];

 $validated['created_by'] = Auth::user()->username;
    // Auto-generate branch_id
    $lastBranch = Branches::orderBy('id', 'desc')->first();
    $nextId = $lastBranch ? $lastBranch->id + 1 : 1;
    $year = date('Y');
    $branchId = 'HOP'.$year. str_pad($nextId, 3, '0', STR_PAD_LEFT);

    // Add branch_id to the validated array
    $validated['branch_id'] = $branchId;

    // Log what is being saved
    \Log::info('Saving Branch:', $validated);

    // Save to DB
    $branch = Branches::create($validated);

    return response()->json([
        'status' => 'success',
        'message' => 'Branch created successfully',
        'data' => $branch,
    ], 201);
}

    public function index()
    {
        $branches = Branches::all();
        return response()->json([
            'status' => 'success',
            'data' => $branches,
        ]);
    }

    public function destroy($branch_id)
{
    $branch = Branches::where('branch_id', $branch_id)->first();

    if (!$branch) {
        return response()->json([
            'status' => 'error',
            'message' => 'Branch not found.',
        ], 404);
    }

    $branch->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Branch deleted successfully.',
    ]);
}

    public function show($branch_id)
    {
        $branch = Branches::where('branch_id', $branch_id)->first();

        if (!$branch) {
            return response()->json([
                'status' => 'error',
                'message' => 'Branch not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $branch,
        ]);
    }

      public function update(Request $request, $branch_id)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'type' => 'required|string|in:Main Branch,Area',
            'town' => 'required|string|max:255',
            'area_head' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'status' => 'required|in:active,suspended,closed',
        ]);

        $branch = Branches::find($branch_id);

        if (!$branch) {
            return response()->json(['status' => 'error', 'message' => 'Branch not found'], 404);
        }

        $branch->branch_name = $validated['branch_name'];
        $branch->region = $validated['region'];
        $branch->district = $validated['district'];
        $branch->type = $validated['type'];
        $branch->town = $validated['town'];
        $branch->area_head = $validated['area_head'];
        $branch->telephone = $validated['telephone'];
        $branch->email = $validated['email'];
        $branch->address = $validated['address'];
        $branch->status = $validated['status'];
        $branch->save();

        return response()->json(['status' => 'success', 'message' => 'Branch updated successfully']);
    }
}

