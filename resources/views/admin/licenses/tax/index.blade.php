<!-- resources/views/admin/licenses/tax/index.blade.php -->
@extends('layouts.app')

@section('title', 'Danh Sách Mã Số Thuế')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold leading-tight text-gray-900">Danh Sách Mã Số Thuế</h1>
        <a href="{{ route('admin.licenses.tax.create') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Thêm Mới
        </a>
    </div>

    <!-- Bộ lọc -->
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.licenses.tax.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Tên Người Dùng</label>
                <input type="text" name="username" id="username" value="{{ request('username') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="tax_code" class="block text-sm font-medium text-gray-700">Mã Số Thuế</label>
                <input type="text" name="tax_code" id="tax_code" value="{{ request('tax_code') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="machine_name" class="block text-sm font-medium text-gray-700">Tên Máy</label>
                <input type="text" name="machine_name" id="machine_name" value="{{ request('machine_name') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Hiển thị danh sách -->
    <div class="bg-white shadow rounded-lg mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tên Người Dùng
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Mã Số Thuế
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tên Doanh Nghiệp
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        License Máy
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Trạng Thái
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ngày Hết Hạn
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($taxLicenses as $taxLicense)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->machineLicense->user->username ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->machineLicense->user->email ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->tax_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->business_name ?? 'Chưa có' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->machineLicense->machine_name ?? 'Máy #' . $taxLicense->machineLicense->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded text-white text-sm
                                {{ $taxLicense->status == 'active' ? 'bg-green-500' :
                                   ($taxLicense->status == 'suspended' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ ucfirst($taxLicense->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $taxLicense->expiry_date ? $taxLicense->expiry_date->format('d-m-Y') : 'Không giới hạn' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.licenses.tax.show', $taxLicense->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('admin.licenses.tax.edit', $taxLicense->id) }}" class="ml-4 text-indigo-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.licenses.tax.destroy', $taxLicense->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline" onclick="return confirm('Bạn có chắc chắn muốn xóa mã số thuế này?')">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Không có mã số thuế nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
            {{ $taxLicenses->links() }}
        </div>
    </div>
</div>
@endsection
