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
            'getRooms',
            'getRoomsWithBlocking',
            'cancelBooking',
            'getbookingdetails',
            'saveBooking',
            'cancelbookingNo',
            'cancelbookingYes'
        ];

        $threeWeeksAgo = Carbon::now()->subWeeks(3);

        $deletedCount = HotelXmlRequest::whereIn('request_type', $types)
            ->where('created_at', '<', $threeWeeksAgo)
            ->delete();

        $sevenDaysAgo = Carbon::now()->subDays(7);

        $deletedCountSearch = HotelXmlRequest::whereIn('request_type', ['search'])
            ->where('created_at', '<', $sevenDaysAgo)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully deleted old XML request logs.',
            'deleted_count' => $deletedCount,
            'deleted_count_search' => $deletedCountSearch,
            'before_date' => $threeWeeksAgo->toDateTimeString()
        ]);
    }
}
