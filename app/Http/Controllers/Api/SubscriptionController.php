<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\V1\SubscriptionResource;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    // Lấy danh sách tất cả gói bản quyền
    public function index()
    {
        $subscriptions = Subscription::all(); // Lấy tất cả gói bản quyền

        // Nếu không có gói bản quyền nào
        if ($subscriptions->isEmpty()) {
            return response()->json(['data' => [], 'error' => null], 200);
        }

        // Trả về danh sách gói bản quyền
        return SubscriptionResource::collection($subscriptions);
    }

    // Tạo mới gói bản quyền
    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->validated());
        return new SubscriptionResource($subscription);
    }

    // Lấy thông tin chi tiết của một gói bản quyền
    public function show($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['error' => 'Subscription not found'], 404);
        }
        return new SubscriptionResource($subscription);
    }

    // Cập nhật gói bản quyền
    public function update(UpdateSubscriptionRequest $request, $id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['error' => 'Subscription not found'], 404);
        }

        $subscription->update($request->validated());
        return new SubscriptionResource($subscription);
    }

    // Xóa gói bản quyền
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['error' => 'Subscription not found'], 404);
        }

        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
