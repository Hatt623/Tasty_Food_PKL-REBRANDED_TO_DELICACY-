<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Model\User;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservation = Reservation::with('user')->latest()->get();
        $title = 'Delete Data';
        $text = 'Apakah Anda yakin?';
        confirmDelete($title,$text);

        return view('backend.reservation.index', compact('reservation'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // gk dipake dl
        $reservation = Reservation::with('user')->findOrFail($id);
        return view('backend.reservation.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservation = Reservation::with('user')->findOrFail($id);
        return view('backend.reservation.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $reservation->status = $request->status;
        $reservation->save();

        toast('Reservasi berhasil di update.', 'success');
        return redirect()->route('backend.reservation.edit', $reservation->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        toast('Reservasi berhasil dihapus.', 'success');
        return redirect()->route('backend.reservation.index');
    }
}
