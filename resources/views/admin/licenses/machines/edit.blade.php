@extends('layouts.app')

@section('title', 'Chỉnh sửa License Máy')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Chỉnh Sửa License Máy</h1>
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
        <form action="{{ route('admin.licenses.machines.update', $machineLicense->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Thông Tin Cơ Bản</h3>

                    <div>
                        <label for="machine_key" class="block text-sm font-medium text-gray-700">Mã Key</label>
                        <input type="text" name="machine_key" id="machine_key"
                               value="{{ old('machine_key', $machineLicense->machine_key) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('machine_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="machine_name" class="block text-sm font-medium text-gray-700">Tên Máy</label>
                        <input type="text" name="machine_name" id="machine_name"
                               value="{{ old('machine_name', $machineLicense->machine_name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('machine_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700">Ngày hết hạn</label>
                        <input type="date" name="expires_at" id="expires_at"
                               value="{{ old('expires_at', $machineLicense->expires_at?->format('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('expires_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái License</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('status', $machineLicense->status) == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                            <option value="suspended" {{ old('status', $machineLicense->status) == 'suspended' ? 'selected' : '' }}>Tạm Ngừng</option>
                            <option value="inactive" {{ old('status', $machineLicense->status) == 'inactive' ? 'selected' : '' }}>Hết Hạn</option>
                            <option value="blocked" {{ old('status', $machineLicense->status) == 'blocked' ? 'selected' : '' }}>Chặn</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="active_taxcode" class="block text-sm font-medium text-gray-700">Trạng thái Active</label>
                        <select name="active_taxcode" id="active_taxcode"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('active_taxcode', $machineLicense->active_taxcode) === 'active' ? 'selected' : '' }}>Hoạt Động</option>
                            <option value="blocked" {{ old('active_taxcode', $machineLicense->active_taxcode) === 'blocked' ? 'selected' : '' }}>Chặn</option>
                        </select>
                        @error('active_taxcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Thông Tin Người Dùng</h3>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Tên người dùng</label>
                        <input type="text" id="username"
                               value="{{ $machineLicense->user->username ?? 'Không xác định' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100" disabled>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email"
                               value="{{ $machineLicense->user->email ?? 'Không xác định' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100" disabled>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" id="phone"
                               value="{{ $machineLicense->user->phone ?? 'Không xác định' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100" disabled>
                    </div>

                    <div>
                        <label for="machine_details" class="block text-sm font-medium text-gray-700">Chi tiết máy</label>
                        <pre class="mt-1 block w-full bg-gray-50 border rounded p-4 text-sm overflow-auto">{{ json_encode($machineLicense->machine_details, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
