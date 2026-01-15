<?php

/*
 * made by pheonix (2026)
 */

namespace App\Services;

use App\Repositories\BookingRepository;
use Illuminate\Support\Carbon;
use App\Models\Booking;

class BookingService
{
    protected BookingRepository $bookingRepository;

    public function __construct(
        BookingRepository $bookingRepository
    ) {
        $this->bookingRepository = $bookingRepository;
    }

    public function bookRoom(int $roomId, int $userId, string $startTime, string $endTime): Booking|false
    {
        $start  = Carbon::parse($startTime);
        $end    = Carbon::parse($endTime);

        if ($this->bookingRepository->hasConflict($roomId, $start, $end)) {
            return false;
        }

        return $this->bookingRepository->createBooking([
            'room_id'       => $roomId,
            'user_id'       => $userId,
            'start_time'    => $start,
            'end_time'      => $end,
        ]);
    }
}
