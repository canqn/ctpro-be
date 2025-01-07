@extends('layouts.app')

@section('title', 'Danh sách người dùng')

@section('contents')
<div>
    <div class="mb-3">
        <h1 class="font-bold text-xl mb-3">DANH SÁCH NGƯỜI DÙNG</h1>
        <a href="{{ route('admin.licenses.machines.create') }}"
           class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none dark:focus:ring-blue-800">
           Thêm mới máy
        </a>
    </div>

    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 mt-4">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Username</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Mã Key</th>
                    <th scope="col" class="px-6 py-3">Tên Máy</th>
                    <th scope="col" class="px-6 py-3">Trạng Thái</th>
                    <th scope="col" class="px-6 py-3">Full mst</th>
                    <th scope="col" class="px-6 py-3">Ngày Tạo</th>
                    <th scope="col" class="px-6 py-3">Ngày hết hạn</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($machineLicenses as $license)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-3">{{ $license->id }}</td>
                <td class="px-6 py-3">{{ $license->user->username ?? '' }}</td>
                <td class="px-6 py-3">{{ $license->user->email ?? '' }}</td>
                <td class="px-6 py-3">{{ $license->machine_key }}</td>
                <td class="px-6 py-3">{{ $license->machine_name }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 text-sm font-medium rounded-sm
                        {{ $license->status == 'active' ? 'bg-blue-300 text-blue-500' :
                           ($license->status == 'suspended' ? 'bg-red-300 text-red-500' : 'bg-red-300 text-red-500') }}">
                        {{ ucfirst($license->status) }}
                    </span>
                </td>
                <td class="px-6 py-3">
                    <span class="px-2 text-sm font-medium rounded-sm
                        {{ $license->active_taxcode == 'active' ? 'bg-blue-300 text-blue-500' :
                           ($license->active_taxcode == 'suspended' ? 'bg-red-300 text-red-500' : 'bg-red-300 text-red-500') }}">
                        {{ ucfirst($license->active_taxcode) }}
                    </span>
                </td>
                <td class="px-6 py-3">{{ $license->last_activated_at->format('d/m/Y') }}</td>
                <td class="px-6 py-3">{{ $license->expires_at->format('d/m/Y') }}</td>
                <td class="w-36 px-6 py-3">
                    <div class="flex gap-2 items-center text-white text-sm">
                        <a href="{{ route('admin.licenses.machines.show', $license->id) }}" class="px-3 py-1 rounded-md bg-blue-500 hover:bg-blue-600"><i class='bx bx-info-circle'></i></a>
                        <a href="{{ route('admin.licenses.machines.edit', $license->id) }}" class="px-3 py-1 rounded-md bg-orange-500 hover:bg-orange-600"><i class='bx bxs-edit'></i></a>
                        <a href="{{ route('admin.licenses.tax.create', $license->id)}}" class="px-3 py-1 rounded-md bg-green-500 hover:bg-green-600"><i class='bx bx-key' ></i></a>
                        <a href="#" class="px-3 py-1 rounded-md bg-green-500 hover:bg-green-600"><i class='bx bx-key' ></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

     <!-- Phân trang -->
    <div class="mt-4">
        {{ $machineLicenses->links() }}
    </div>
</div>
@endsection
