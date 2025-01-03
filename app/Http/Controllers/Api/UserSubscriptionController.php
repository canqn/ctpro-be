<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserSubscriptionRequest;
use App\Http\Resources\V1\UserSubscriptionResource;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
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
    public function store(StoreUserSubscriptionRequest $request)
    {
        $userSubscription = UserSubscription::create($request->validated());
        return new UserSubscriptionResource($userSubscription);
    }

    public function show($id)
    {
        $userSubscription = UserSubscription::with('subscription')->find($id);
        if (!$userSubscription) {
            return response()->json(['error' => 'User Subscription not found'], 404);
        }
        return new UserSubscriptionResource($userSubscription);
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
