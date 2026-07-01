<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelXmlRequest;
use Illuminate\Support\Carbon;

class CleningController extends Controller
{
    public function deleteOldHotelXmlRequests()
    {
        $types = [
            'search',
            'getRooms',
            'getRoomsWithBlocking',
            'cancelBooking',
            'getbookingdetails',
            'saveBooking',
            'cancelbookingNo',
            'cancelbookingYes',
            'prebooking'
        ];

        $threeWeeksAgo = Carbon::now()->subWeeks(3);

        $deletedCount = HotelXmlRequest::whereIn('request_type', $types)
            ->where('created_at', '<', $threeWeeksAgo)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully deleted old XML request logs.',
            'deleted_count' => $deletedCount,
            'before_date' => $threeWeeksAgo->toDateTimeString()
        ]);
    }
}
