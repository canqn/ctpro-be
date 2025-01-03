<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceLogRequest;
use App\Http\Resources\V1\DeviceLogResource;
use App\Models\DeviceLog;
use Illuminate\Http\Request;

class DeviceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceLogRequest $request)
    {
        $deviceLog = DeviceLog::create($request->validated());
        return new DeviceLogResource($deviceLog);
    }

    public function show($user_subscription_id)
    {
        $deviceLogs = DeviceLog::where('user_subscription_id', $user_subscription_id)->get();

        if ($deviceLogs->isEmpty()) {
            return response()->json(['error' => 'No logs found for this subscription'], 404);
        }

        return DeviceLogResource::collection($deviceLogs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
