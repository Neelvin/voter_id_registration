<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\VoterProfile;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        
        $currentDate = Carbon::now()->toDateString();

        $total_voters_count = VoterProfile::count();
        $total_users_count = User::whereDate('created_at', $currentDate)->count();

        return view('dashboard', ['total_voters_count' => $total_voters_count, 'total_users_count' => $total_users_count]);
    }
}
