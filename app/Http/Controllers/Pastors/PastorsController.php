<?php

namespace App\Http\Controllers\Pastors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pastor;

class PastorsController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'fullname'           => 'required|string|max:255',
        'title'              => 'required|in:head,sub',
        'dob'                => 'required|date',
        'martial_status'     => 'required|string|in:single,married,divorced,widowed',
        'spouse'             => 'nullable|string|max:255',
        'children'           => 'required|integer|min:0',
        'telephone'          => 'required|string|max:15',
        'from_date'          => 'required|date',
        'to_date'            => 'required|date|after_or_equal:from_date',
        'emergency_contact'  => 'required|string|max:255',
        'photo'              => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload and store the photo
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('pastor_photos', 'public');
        $validated['photo'] = $photoPath;
    }

    // Get logged-in user
    $user = auth()->user();
    $validated['username'] = $user->username; // or $user->name, $user->email depending on what you track

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

}
