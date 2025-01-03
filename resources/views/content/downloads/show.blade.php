@extends('layouts.app')

@section('title', 'Danh sách lượt tải')

@section('contents')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-0">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold leading-tight text-gray-900">Lịch sử tải xuống</h1>
        <div class="mt-4 sm:mt-0">
            {{-- <a href="{{ route('admin/downloadlimits/create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                Thêm mới
            </a> --}}
        </div>
    </div>

    @if ($downloads->count() > 0)
    <div class="mt-3 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">User</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Số lượt tải</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Mã ổ cứng</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ngày tải</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($downloads as $download)
                <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $download->id }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download->user->username }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download->total_download }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download->driver_info }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download->download_date }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $download->created_at ? $download->created_at : 'N/A' }}</td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                        <a href="{{ route('admin/downloadlimits/edit', $download->id) }}" class="ml-4 text-green-600 hover:text-green-900">Edit</a>
                        <form action="{{ route('admin/downloadlimits/destroy', $download->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="mt-8 bg-white shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <p class="text-gray-700">Không có dữ liệu lượt tải.</p>
        </div>
    </div>
    @endif
</div>
@endsection
