<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiReservationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $reservations = Reservation::where('user_id', $userId)->latest()->get();
        $res = [
            'success' => true,
            'data' => $reservations,
            'message' => 'Data list Reservasi',
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $checkReservation = Reservation::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->first();
        if ($checkReservation) {
        return response()->json([
                'success' => false,
                'message' => 'Anda masih memiliki reservasi aktif. Cancel/selesaikan/ubah reservasi anda.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guest_count'      => 'required|integer|min:1',
            'status'           => 'required|in:pending,confirmed,cancelled,completed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $dayOfWeek = Carbon::parse($request->reservation_date)->dayOfWeek;
        if ($dayOfWeek == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak tersedia di hari Minggu'
            ], 400);
        }

        $time  = Carbon::createFromFormat('H:i', $request->reservation_time);
        $start = Carbon::createFromTime(8, 0);
        $end   = Carbon::createFromTime(21, 30);
        if ($time->lt($start) || $time->gt($end)) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi hanya tersedia antara 08:00 - 21:30'
            ], 400);
        }

        $reservationDateTime = Carbon::parse(
        $request->reservation_date . ' ' . $request->reservation_time,'Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');
        if ($reservationDateTime->isToday() && $reservationDateTime->lt($now)) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak boleh di waktu yang sudah lewat hari ini'
            ], 400);
        }

        $reservation = new Reservation();
        $reservation ->user_id          = $request->user()->id;
        $reservation ->reserve_code     = 'RSV-' . strtoupper(Str::random(8));
        $reservation ->reservation_date = $request->reservation_date;
        $reservation ->reservation_time = $request->reservation_time;
        $reservation ->guest_count      = $request->guest_count;
        $reservation ->status           = 'pending';
        $reservation ->payment_status   = 'unpaid';

        $reservation ->save();
        $reservation = Reservation::with(['user'])->find($reservation->id);
       
        // Response
        $res = [
            'success' => true,
            'data' => $reservation,
            'message' => 'Store reservation'
        ];
        return response()->json($res, 201);
    }

    public function show(Request $request, $id)
    {
        $userId = $request->user()->id;
        $reservation = Reservation::where('user_id', $userId)->latest()->get();
        if (! $reservation) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 400);
       }

       return response()->json([
        'success'=> true,
        'data' => $reservation,
        'message' => 'Lihat data reservasi'
       ], 200);
    }

    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $reservation = Reservation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guest_count'      => 'required|integer|min:1',
            'status'           => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $dayOfWeek = Carbon::parse($request->reservation_date)->dayOfWeek;
        if ($dayOfWeek == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak tersedia di hari Minggu'
            ], 400);
        }

        $time  = Carbon::createFromFormat('H:i', $request->reservation_time);
        $start = Carbon::createFromTime(8, 0);
        $end   = Carbon::createFromTime(21, 30);

        if ($time->lt($start) || $time->gt($end)) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi hanya tersedia antara 08:00 - 21:30'
            ], 400);
        }

        $reservationDateTime = Carbon::parse(
            $request->reservation_date . ' ' . $request->reservation_time,
            'Asia/Jakarta'
        );
        $now = Carbon::now('Asia/Jakarta');

        if ($reservationDateTime->isToday() && $reservationDateTime->lt($now)) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak boleh di waktu yang sudah lewat hari ini'
            ], 400);
        }

        $reservation->reservation_date = $request->reservation_date;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->guest_count      = $request->guest_count;
        $reservation->status           = $request->status;
        $reservation->save();

        $reservation = Reservation::with(['user'])->find($reservation->id);

        return response()->json([
            'success' => true,
            'data'    => $reservation,
            'message' => 'Reservasi berhasil diperbarui'
        ], 200);
    }
}
