@extends('layouts.app')

@section('title', 'Danh sách bản quyền máy')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Chi Tiết License Máy</h1>
        <a href="{{ url()->previous() }}" class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow">
            Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center border-b pb-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Thông Tin License</h2>
            <div class="flex flex-col sm:flex-row sm:gap-4">
                <div class="flex gap-2 justify-center">
                    <!-- Form cập nhật trạng thái active_taxcode -->
                    <h3>Trạng thái active</h3>
                    <form action="{{ route('admin.licenses.active', ['type' => 'activetaxcode', 'id' => $machineLicense->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="border border-gray-300 rounded-md p-2 text-sm" onchange="this.form.submit()">
                            <option value="active" {{ $machineLicense->active_taxcode === 'active' ? 'selected' : '' }}>
                                Hoạt Động
                            </option>
                            <option value="blocked" {{ $machineLicense->active_taxcode === 'blocked' ? 'selected' : '' }}>
                                Chặn
                            </option>
                        </select>
                    </form>
                </div>

                <div class="flex gap-2 justify-center">
                    <h3>Status:</h3>
                    <!-- Form cập nhật trạng thái License -->
                    <form action="{{ route('admin.licenses.status', ['type' => 'machine', 'id' => $machineLicense->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="border border-gray-300 rounded-md p-2 text-sm" onchange="this.form.submit()">
                            <option value="active" {{ $machineLicense->status == 'active' ? 'selected' : '' }}>
                                Hoạt Động
                            </option>
                            <option value="suspended" {{ $machineLicense->status == 'suspended' ? 'selected' : '' }}>
                                Tạm Ngừng
                            </option>
                            <option value="inactive" {{ $machineLicense->status == 'inactive' ? 'selected' : '' }}>
                                Hết Hạn
                            </option>
                            <option value="blocked" {{ $machineLicense->status == 'blocked' ? 'selected' : '' }}>
                                Chặn
                            </option>
                        </select>
                    </form>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Thông Tin Cơ Bản</h3>
                <p><strong>Mã Key:</strong> {{ $machineLicense->machine_key }}</p>
                <p><strong>Tên Máy:</strong> {{ $machineLicense->machine_name ?? 'Chưa đặt tên' }}</p>
                <p><strong>Người Dùng:</strong> {{ $machineLicense->user->username ?? 'Không xác định' }}</p>
                <p><strong>Email:</strong> {{ $machineLicense->user->email ?? 'Không xác định' }}</p>
                <p><strong>SĐT:</strong> {{ $machineLicense->user->phone ?? 'Không xác định' }}</p>
                <p><strong>Ngày hết hạn:</strong> {{ $machineLicense->expires_at?->format('d/m/Y') ?? 'Không xác định' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Chi Tiết Máy</h3>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-auto">{{ json_encode($machineLicense->machine_details, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>

        <h3 class="text-lg font-medium text-gray-800 mb-4">Danh Sách Mã Số Thuế</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Mã Số Thuế</th>
                        <th class="px-4 py-2 border">Tên Doanh Nghiệp</th>
                        <th class="px-4 py-2 border">Trạng Thái</th>
                        <th class="px-4 py-2 border">Thiết Bị</th>
                        <th class="px-4 py-2 border">Hạn Sử Dụng</th>
                        <th class="px-4 py-2 border">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machineLicense->taxLicenses as $taxLicense)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $taxLicense->tax_code }}</td>
                            <td class="px-4 py-2 border">{{ $taxLicense->business_name }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 rounded text-white {{ $taxLicense->status == 'active' ? 'bg-green-500' : ($taxLicense->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ ucfirst($taxLicense->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">{{ $taxLicense->current_devices }}/{{ $taxLicense->max_devices }}</td>
                            <td class="px-4 py-2 border">{{ $taxLicense->expiry_date?->format('d/m/Y') ?? 'Không giới hạn' }}</td>
                            <td class="px-4 py-2 border text-center space-x-2">
                                <a href="{{ route('admin.licenses.tax.edit', $taxLicense->id) }}" class="text-blue-600 hover:underline">Chỉnh sửa</a>
                                <form action="{{ route('admin.licenses.tax.destroy', $taxLicense->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc chắn muốn xóa mã số thuế này?')">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
