<!-- resources/views/admin/licenses/tax/show.blade.php -->
@extends('layouts.app')

@section('title', 'Chi Tiết Mã Số Thuế')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold leading-tight text-gray-900">Chi Tiết Mã Số Thuế</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Cột trái -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium border-b pb-2">Thông Tin Cơ Bản</h3>
                <p><strong>Mã Số Thuế:</strong> {{ $taxLicense->tax_code }}</p>
                <p><strong>Tên Doanh Nghiệp:</strong> {{ $taxLicense->business_name ?? 'Chưa có' }}</p>
                <p><strong>License Máy:</strong> {{ $taxLicense->machineLicense->machine_name ?? 'Máy #' . $taxLicense->machineLicense->id }}</p>
                <p><strong>Người Dùng:</strong> {{ $taxLicense->machineLicense->user->username }}</p>
            </div>

            <!-- Cột phải -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium border-b pb-2">Cấu Hình License</h3>
                <p><strong>Số Thiết Bị Tối Đa:</strong> {{ $taxLicense->max_devices }}</p>
                <p><strong>Trạng Thái:</strong>
                    <span class="px-2 py-1 rounded text-white text-sm
                        {{ $taxLicense->status == 'active' ? 'bg-green-500' :
                           ($taxLicense->status == 'suspended' ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ ucfirst($taxLicense->status) }}
                    </span>
                </p>
                <p><strong>Ngày Hết Hạn:</strong> {{ $taxLicense->expiry_date ? $taxLicense->expiry_date->format('d-m-Y') : 'Không giới hạn' }}</p>
            </div>
        </div>
    </div>

    <!-- Danh sách các máy liên quan (nếu cần) -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h3 class="text-lg font-medium border-b pb-2">License Máy Liên Quan</h3>
        <ul class="list-disc list-inside space-y-2">
            <li>
                <p><strong>Mã Key:</strong> {{ $taxLicense->machineLicense->machine_key }}</p>
            </li>
        </ul>
    </div>

    <!-- Nút điều hướng -->
    <div class="flex justify-end space-x-3 mt-6">
        <a href="{{ route('admin.licenses.tax.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Quay Lại Danh Sách
        </a>
        {{-- <a href="{{ route('admin.licenses.tax.edit', $taxLicense->id) }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Chỉnh Sửa
        </a> --}}
    </div>
</div>
@endsection
