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

       
        $dayOfWeek = \Carbon\Carbon::parse($request->reservation_date)->dayOfWeek; 
        if ($dayOfWeek == 0) {
            toast('Reservasi tidak tersedia di hari Minggu','error');
            return redirect()->back()->withInput();
        }

        $time = \Carbon\Carbon::createFromFormat('H:i', $request->reservation_time);
        $start = \Carbon\Carbon::createFromTime(8, 0);   
        $end   = \Carbon\Carbon::createFromTime(21, 30); 

        if ($time->lt($start) || $time->gt($end)) {
            toast('Reservasi hanya tersedia antara 08:00 - 21:30','error');
            return redirect()->back()->withInput();
        }

        $reservation = new Reservation();
        $reservation ->user_id          = Auth::id();
        $reservation ->reservation_date = $request->reservation_date;
        $reservation ->reservation_time = $request->reservation_time;
        $reservation ->guest_count      = $request->guest_count;
        $reservation ->status           = 'pending';
        $reservation ->payment_status   = 'unpaid';

        $reservation ->save();
        toast('Reservasi berhasil dibuat', 'success');
        return redirect()->route('reservation.settings.index');

    }

    public function reservationSettingsIndex()
    {
       if (!Auth::check()) {
        toast('Please login first','warning');
        return redirect('/login');
        }

        $reservations = Reservation::where('user_id', Auth::id())->latest()->get();

        return view('reservationSettingsIndex', compact('reservations'));
    }

    public function edit(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservationSettingsEdit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!Auth::check())
        {
            toast('Please Login first','warning');
            return redirect('/login');
        }

        $request->validate([
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required|date_format:H:i',
        'guest_count' => 'required|integer|min:1',
        ]);
       
        $dayOfWeek = \Carbon\Carbon::parse($request->reservation_date)->dayOfWeek; 
        if ($dayOfWeek == 0) {
            toast('Reservasi tidak tersedia di hari Minggu','error');
            return redirect()->back()->withInput();
        }

        $time = \Carbon\Carbon::createFromFormat('H:i', $request->reservation_time);
        $start = \Carbon\Carbon::createFromTime(8, 0);   
        $end   = \Carbon\Carbon::createFromTime(21, 30); 

        if ($time->lt($start) || $time->gt($end)) {
            toast('Reservasi hanya tersedia antara 08:00 - 21:30','error');
            return redirect()->back()->withInput();
        }

        $reservation = Reservation::findOrFail($id);
        $reservation ->user_id          = Auth::id();
        $reservation ->reservation_date = $request->reservation_date;
        $reservation ->reservation_time = $request->reservation_time;
        $reservation ->guest_count      = $request->guest_count;
        $reservation ->status           = 'pending';
        $reservation ->payment_status   = 'unpaid';

        $reservation ->save();
        toast('Reservasi berhasil diperbarui', 'success');
        return redirect()->route('reservation.settings.index');

    }

    //kayaknya g usah dl
    // public function destroy(string $id)
    // {
    //     $reservation = Reservation::findOrFail($id);
    //     $reservation->delete();
    //     toast('Reservasi berhasil dihapus', 'success');
    //     return redirect()->route('reservation.settings.index');
    // }

}
