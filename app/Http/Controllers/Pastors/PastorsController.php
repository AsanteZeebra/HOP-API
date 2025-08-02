<?php

namespace App\Http\Controllers\Pastors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pastor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PastorsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'title' => 'required|in:Rev.,Evangelist,Pastor,Apostle',
            'dob' => 'required|date',
            'marital_status' => 'required|string|in:single,married,divorced,widowed',
            'spouse' => 'nullable|string|max:255',
            'children' => 'required|integer|min:0',
            'telephone' => 'required|string|max:15',
             'branch' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'next_of_kin' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Upload and store the photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('images', 'public');
            $validated['photo'] = $photoPath;
        }

        // Get logged-in user
        $validated['created_by'] = Auth::user()->name;
        // Generate unique pastor_code
        $lastPastor = Pastor::orderBy('id', 'desc')->first();
        $nextId = $lastPastor ? $lastPastor->id + 1 : 1;
        $year = date('Y');
        $pastorID = 'HPM' . $year . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $validated['pastor_code'] = $pastorID;

        // Save to Pastor model
        $pastor = Pastor::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Pastor created successfully',
            'data' => $pastor,
        ], 201);
    }



    public function index()
    {
        $pastors = Pastor::all();



        return response()->json([
            'status' => 'success',
            'data' => $pastors,
        ]);
    }

    public function destroy($pastor_code)
    {
        $pastor = Pastor::where('pastor_code', $pastor_code)->first();

        if (!$pastor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pastor record not found.',
            ], 404);
        }

        $pastor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pastor deleted successfully.',
        ]);
    }

    public function show($pastor_code)
    {
        $pastor = Pastor::where('pastor_code', $pastor_code)->first();

        if (!$pastor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pastor not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pastor,
        ]);
    }

    public function update(Request $request, $pastor_code)
    {
        $validated = $request->validate([
            'fullname' => 'sometimes|required|string|max:255',
            'title' => 'sometimes|required|in:Rev.,Evangelist,Pastor,Apostle',
            'dob' => 'sometimes|required|date',
            'marital_status' => 'sometimes|required|string|in:single,married,divorced,widowed',
            'spouse' => 'nullable|string|max:255',
            'children' => 'sometimes|required|integer|min:0',
            'telephone' => 'sometimes|required|string|max:15',
            'from_date' => 'sometimes|required|date',
            'to_date' => 'sometimes|required|date|after_or_equal:from_date',
            'next_of_kin' => 'sometimes|required|string|max:255',
            'emergency_contact' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $pastor = Pastor::where('pastor_code', $pastor_code)->first();

        if (!$pastor) {
            return response()->json(['status' => 'error', 'message' => 'Pastor not found'], 404);
        }



        $pastor->fill($validated);
        $pastor->updated_by = Auth::user()->name ?? 'system'; // fallback if null
        $pastor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pastor updated successfully',
            'data' => $pastor
        ]);
    }

    public function upload(Request $request, $pastor_code)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $pastor = Pastor::where('pastor_code', $pastor_code)->first();

    if (!$pastor) {
        return response()->json([
            'status' => 'error',
            'message' => 'Pastor not found',
        ], 404);
    }

   if ($pastor->photo && \Storage::disk('public')->exists($pastor->photo)) {
        \Storage::disk('public')->delete($pastor->photo);
    }

    // Store new photo
    $photoPath = $request->file('photo')->store('images', 'public');

    // Update database
    $pastor->photo = $photoPath;
     $pastor->updated_by = Auth::user()->name ?? 'system'; // fallback if null
    $pastor->save();





    return response()->json([
        'status' => 'success',
        'message' => 'Photo updated successfully',
        'data' => $pastor
    ]);
}


}
