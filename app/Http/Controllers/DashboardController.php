<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use App\Support\Constant;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): Factory|View
    {
        $user = Auth::user();

        if ($user->role === Constant::ROLE_ADMIN) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function adminDashboard(): Factory|View
    {
        $todayBookings = Booking::with('room', 'user')->whereDate('start_time',
            today())->orderBy('start_time')->limit(10)->get();

        return view('dashboard.index', [
            'role'          => Constant::ROLE_ADMIN,
            'stats'         => [
                'rooms'      => Room::count(),
                'facilities' => Facility::count(),
                'today'      => Booking::whereDate('start_time', today())->count(),
                'pending'    => Booking::where('status', 'pending')->count(),
            ],
            'todayBookings' => $todayBookings,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function userDashboard(): Factory|View
    {
        $user = auth()->user();

        $todayBookings = Booking::with('room')->where('user_id', $user->id)->whereDate('start_time',
            today())->orderBy('start_time')->get();
        $upcomingBookings = Booking::with('room')->where('user_id', $user->id)->where('start_time', '>',
            now())->orderBy('start_time')->limit(5)->get();

        return view('dashboard.index', [
            'role'             => Constant::ROLE_USER,
            'todayBookings'    => $todayBookings,
            'upcomingBookings' => $upcomingBookings,
        ]);
    }
}
