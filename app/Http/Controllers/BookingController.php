<?php

/*
 * made by pheonix (2026)
 */

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, BookingService $bookingService)
    {
        $data = $request->validate([
            'room_id'       => 'required|integer',
            'user_id'       => 'required|integer',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after_or_equal:start_time',
        ]);

        $booking = $bookingService->bookRoom(
            $data['room_id'], 
            $data['user_id'], 
            $data['start_time'], 
            $data['end_time']
        );

        if (!$booking) {
            return response()->json([
                'message' => 'Room is already booked for this time period'
            ], 409);
        }

        return response()->json([
            'message'   => 'Room successfully booked', 
            'booking'   => $booking
        ], 201);
    }
}
