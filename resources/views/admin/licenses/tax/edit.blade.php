@extends('layouts.app')

@section('title', 'Chỉnh Sửa License Thuế')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-0">
    <h1 class="text-2xl font-bold leading-tight text-gray-900 mb-4">Chỉnh Sửa License Thuế</h1>

    <form action="{{ route('admin.licenses.tax.update', $taxLicense->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white shadow rounded-lg p-6">
            <!-- Machine License -->
            <div>
                <label for="machine_license_id" class="block text-sm font-medium text-gray-700 mb-1">License Máy</label>
                <select name="machine_license_id" id="machine_license_id" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($machineLicenses as $machineLicense)
                        <option value="{{ $machineLicense->id }}"
                                {{ $taxLicense->machine_license_id == $machineLicense->id ? 'selected' : '' }}>
                            {{ $machineLicense->machine_name ?? 'Máy #' . $machineLicense->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tax Code -->
            <div>
                <label for="tax_code" class="block text-sm font-medium text-gray-700 mb-1">Mã Số Thuế</label>
                <input type="text" name="tax_code" id="tax_code" value="{{ old('tax_code', $taxLicense->tax_code) }}" required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Business Name -->
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Tên Doanh Nghiệp</label>
                <input type="text" name="business_name" id="business_name"
                       value="{{ old('business_name', $taxLicense->business_name) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Max Devices -->
            <div>
                <label for="max_devices" class="block text-sm font-medium text-gray-700 mb-1">Số Thiết Bị Tối Đa</label>
                <input type="number" name="max_devices" id="max_devices" min="1" max="10"
                       value="{{ old('max_devices', $taxLicense->max_devices) }}" required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Expiry Date -->
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày Hết Hạn</label>
                <input type="date" name="expiry_date" id="expiry_date"
                       value="{{ old('expiry_date', $taxLicense->expiry_date?->format('Y-m-d')) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng Thái</label>
                <select name="status" id="status" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="active" {{ $taxLicense->status == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                    <option value="pending" {{ $taxLicense->status == 'pending' ? 'selected' : '' }}>Chờ Duyệt</option>
                    <option value="expired" {{ $taxLicense->status == 'expired' ? 'selected' : '' }}>Hết Hạn</option>
                    <option value="suspended" {{ $taxLicense->status == 'suspended' ? 'selected' : '' }}>Tạm Ngừng</option>
                    <option value="revoked" {{ $taxLicense->status == 'revoked' ? 'selected' : '' }}>Thu Hồi</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.licenses.tax.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Hủy Bỏ
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cập Nhật
            </button>
        </div>
    </form>
</div>
@endsection
