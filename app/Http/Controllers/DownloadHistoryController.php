<?php

namespace App\Http\Controllers;

use App\Models\DownloadLimit;
use App\Http\Requests\StoreDownloadLimitRequest;
use App\Http\Requests\UpdateDownloadLimitRequest;
use App\Models\Download;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DownloadHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách user
        $users = User::all();

        // Khởi tạo mảng selectedUsers
        $datas = new Collection();

        // Lặp qua từng user và thêm thông tin downloadBought và downloadLimit
        foreach ($users as $user) {
            // Lấy thông tin download bought của user
            $downloadBought = Download::where('user_id', $user->id)
                ->sum('total_download');

            // Lấy thông tin download limit của user
            $downloadLimit = DownloadLimit::where('user_id', $user->id)
                ->sum('download_limit');

            // Thêm thông tin vào mảng selectedUsers
            $datas->push([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'downloadBought' => $downloadBought ?? 0,
                'downloadLimit' => $downloadLimit ?? 0,
            ]);
        }
        //dd($datas);
        // Trả về view với dữ liệu đã được chọn
        return view('content/downloadlimits.index', compact('datas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách người dùng từ cơ sở dữ liệu chỉ với các trường id, username, và email
        $users = User::select('id', 'username', 'email')->get();
        // dd($users);
        // Trả về view với danh sách người dùng
        return view('content/downloadlimits.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'download_limit' => 'required|integer|max:191',
            // 'tenvt' => 'required|string|max:191', // Uncomment if required
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = auth('api')->user(); // Assuming Laravel Sanctum or Passport

        $data = DownloadLimit::create([
            'download_limit' => $request->total_download,
            'user_id' => $user ? $user->id : $request->user_id, // Set user_id only if user is authenticated
            // 'tenvt' => $request->tenvt, // Uncomment if required
        ]);

        return response()->json([
            'status' => 201, // Created (more specific than 200)
            'message' => 'Download created successfully',
            'data' => $data,
        ], 201);
    }

    public function storeDownload(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'download_limit' => 'required|integer|min:0',
        ]);

        try {
            // Create a new DownloadLimit instance
            $downloadLimit = new DownloadLimit();
            $downloadLimit->user_id = $request->user_id;
            $downloadLimit->download_limit = $request->download_limit;

            // Save the new download limit
            $downloadLimit->save();

            // Optionally, you can return a success response
            return redirect()->route('admin/downloadlimits')->with('success', 'Download limit created successfully.');
        } catch (\Exception $e) {
            // If an error occurs during the process, handle it appropriately
            return redirect()->back()->with('error', 'Failed to create download limit. ' . $e->getMessage())->withErrors(['error' => 'Failed to create download limit.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        // Lấy danh sách lượt tải dựa trên user_id
        $downloads = Download::where('user_id', $userId)->get();
        return view('content.downloads.show', compact('downloads'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $downloadLimit = DownloadLimit::findOrFail($id);
        $users = User::all();
        return view('content.downloadlimits.edit', compact('downloadLimit', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $downloadLimit = DownloadLimit::findOrFail($id);

        $validatedData = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'download_limit' => 'required|numeric|min:1',
        ]);

        $downloadLimit->update($validatedData);

        return redirect()->route('admin/downloadlimits')->with('success', 'Download limit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $downloadLimit = DownloadLimit::findOrFail($id);
        $downloadLimit->delete();

        return redirect()->route('admin/downloadlimits')->with('success', 'Download limit deleted successfully.');
    }
}
