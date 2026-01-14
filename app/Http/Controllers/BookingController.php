<?php

/*
 * made by pheonix (2026)
 */

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'    => 'required|integer',
            'user_id'    => 'required|integer',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $room = Room::find($data['room_id']);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }

        $start = Carbon::parse($data['start_time']);
        $end   = Carbon::parse($data['end_time']);

        $hasConflict = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($start, $end) {
                $query
                    ->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_time', '<=', $start)
                          ->where('end_time', '>=', $end);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return response()->json([
                'message' => 'Room is already booked for this time period'
            ], 409);
        }

        $booking = Booking::create([
            'room_id'    => $room->id,
            'user_id'    => $data['user_id'],
            'start_time' => $start,
            'end_time'   => $end,
        ]);

        return response()->json([
            'message' => 'Room successfully booked',
            'booking' => $booking
        ], 201);
    }
}
