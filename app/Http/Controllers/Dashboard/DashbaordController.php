<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Members;
use App\Models\Branches;

class DashbaordController extends Controller
{
 public function index()
    {
        // Count all members
        $memberCount = Members::count();

        // Count all branches
        $branchCount = Branches::count();

        // You can pass these counts to a view or return as JSON
        return response()->json([
              'status' => 'success',
            'members' => $memberCount,
            'branches' => $branchCount,
        ]);
    }
}
