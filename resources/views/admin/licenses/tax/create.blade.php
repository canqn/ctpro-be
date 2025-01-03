<!-- resources/views/admin/licenses/tax/create.blade.php -->
@extends('layouts.app')

@section('title', 'Thêm Mới Mã Số Thuế')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-0">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold leading-tight text-gray-900">Thêm Mới Mã Số Thuế</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.licenses.tax.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cột trái -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium border-b pb-2">Thông Tin Cơ Bản</h3>

                    <!-- Machine License Selection -->
                    <div>
                        <label for="machine_license_id" class="block text-sm font-medium text-gray-700 mb-1">
                            License Máy <span class="text-red-500">*</span>
                        </label>
                        <select name="machine_license_id"
                                id="machine_license_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            <option value="">Chọn License Máy</option>
                            @foreach($machineLicenses as $license)
                                <option value="{{ $license->id }}"
                                    {{ old('machine_license_id', $selectedMachine?->id) == $license->id ? 'selected' : '' }}>
                                    {{ $license->machine_name ?? 'Máy #' . $license->id }} - {{ $license->user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tax Code -->
                    <div>
                        <label for="tax_code" class="block text-sm font-medium text-gray-700 mb-1">
                            Mã Số Thuế <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="tax_code"
                               id="tax_code"
                               value="{{ old('tax_code') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Business Name -->
                    <div>
                        <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Tên Doanh Nghiệp
                        </label>
                        <input type="text"
                               name="business_name"
                               id="business_name"
                               value="{{ old('business_name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium border-b pb-2">Cấu Hình License</h3>

                    <!-- Max Devices -->
                    <div>
                        <label for="max_devices" class="block text-sm font-medium text-gray-700 mb-1">
                            Số Thiết Bị Tối Đa
                        </label>
                        <input type="number"
                               name="max_devices"
                               id="max_devices"
                               value="{{ old('max_devices', 1) }}"
                               min="1"
                               max="10"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Giới hạn từ 1-10 thiết bị</p>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Ngày Hết Hạn
                        </label>
                        <input type="date"
                               name="expiry_date"
                               id="expiry_date"
                               value="{{ old('expiry_date') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Để trống nếu không giới hạn thời gian</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Trạng Thái <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="revoked" {{ old('status') == 'revoked' ? 'selected' : '' }}>Bị thu hồi</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Tạm Ngừng</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Hết Hạn</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('admin.licenses.machines.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Hủy Bỏ
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tạo Mới
                </button>
            </div>
        </form>
    </div>
</div>

@if($selectedMachine)
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium mb-4">Thông Tin License Máy Đã Chọn</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p><strong>Mã Key:</strong> {{ $selectedMachine->machine_key }}</p>
                <p><strong>Tên Máy:</strong> {{ $selectedMachine->machine_name ?? 'Chưa đặt tên' }}</p>
                <p><strong>Người Dùng:</strong> {{ $selectedMachine->user->username }}</p>
                <p><strong>Email:</strong> {{ $selectedMachine->user->email }}</p>
            </div>
            <div>
                <p><strong>Trạng Thái:</strong>
                    <span class="px-2 py-1 rounded text-white text-sm
                        {{ $selectedMachine->status == 'active' ? 'bg-green-500' :
                           ($selectedMachine->status == 'suspended' ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ ucfirst($selectedMachine->status) }}
                    </span>
                </p>
                <p><strong>Số MST Đã Cấp:</strong> {{ $selectedMachine->taxLicenses->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý khi chọn machine license
    const machineLicenseSelect = document.getElementById('machine_license_id');
    if (machineLicenseSelect) {
        machineLicenseSelect.addEventListener('change', function() {
            if (this.value) {
                window.location.href = "{{ route('admin.licenses.tax.create') }}/" + this.value;
            }
        });
    }
});
</script>
@endpush
