<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use Auth;

class ReservationCSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('reservation');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check())
        {
            toast('Please Login first','warning');
            return redirect('/login');
        }

        $checkReservation = Reservation::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->first();

        if ($checkReservation) {
            toast('Anda masih memiliki reservasi aktif. Cancel/selesaikan/ubah reservasi anda.','warning');
            return redirect()->route('reservation.index');
        }


        $request->validate([
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required|date_format:H:i',
        'guest_count' => 'required|integer|min:1',
        ]);

        $reservation = new Reservation();
        $reservation ->user_id          = Auth::id();
        $reservation ->reservation_date = $request->reservation_date;
        $reservation ->reservation_time = $request->reservation_time;
        $reservation ->guest_count      = $request->guest_count;
        $reservation ->status           = 'pending';
        $reservation ->payment_status   = 'unpaid';

        $reservation ->save();
        toast('Reservasi berhasil dibuat', 'success');
        return redirect()->route('reservation.index');

    }
}
