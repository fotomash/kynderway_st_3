<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingRequestNotification;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function store(Request $request, BookingService $service)
    {
        $data = $request->validate([
            'parent_id'   => 'required|integer',
            'nanny_id'    => 'required|integer',
            'agency_id'   => 'nullable|integer',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date',
            'hours'       => 'required|integer',
            'hourly_rate' => 'required|numeric',
        ]);
        $data['status'] = Booking::STATUS_REQUESTED;

        $booking = $service->createBooking($data);

        if (class_exists(BookingRequestNotification::class)) {
            Notification::send($booking->nanny, new BookingRequestNotification($booking));
        }

        return response()->json($booking, 201);
    }

    public function complete(Booking $booking, BookingService $service)
    {
        $booking = $service->completeBooking($booking);

        return response()->json($booking);
    }
}
