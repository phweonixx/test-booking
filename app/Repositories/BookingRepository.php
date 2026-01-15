<?php

/*
 * made by pheonix (2026)
 */

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Support\Carbon;

class BookingRepository
{
    public function hasConflict(int $roomId, Carbon $start, Carbon $end): bool
    {
        return Booking::where('room_id', $roomId)
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            })
            ->exists();
    }

    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
    }
}
