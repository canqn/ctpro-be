@extends('layouts.app')

@section('title', 'Quản lý lượt tải')

@section('contents')
<div>
    <div class="flex justify-between items-center mb-3">
        <h1 class="font-bold text-2xl uppercase">Quản lý danh sách lượt tải</h1>
        <a href="{{ route('admin/downloadlimits/create') }}" class="text-white float-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Thêm lượt tải xuống</a>
    </div>


    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Username</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Số lượt tải</th>
                <th scope="col" class="px-6 py-3">Số lượt đã tải</th>
                <th scope="col" class="px-6 py-3">Số lượt tải còn lại</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @if($datas->count() > 0)
            @foreach($datas as $rs)
            <tr class="bg-white border-b  hover:bg-gray-50">
                <th scope="row" class="font-medium text-gray-900 whitespace-nowrap px-2 ">
                    {{ $loop->iteration }}
                </th>
                <td>
                    {{ $rs['username'] }}
                </td>
                <td>
                    {{ $rs['email'] }}
                </td>
                <td>
                   <span class="text-sm font-medium  text-blue-500">{{ $rs['downloadLimit'] }}</span>
                </td>
                <td>
                  <span class="text-sm font-medium text-green-500">{{ $rs['downloadBought'] }}</span>
                </td>
                <td>
                   <span class="text-sm font-medium  text-red-500">{{ $rs['downloadLimit'] - $rs['downloadBought'] }}</span>
                </td>
                <td class="w-auto">
                    <div class="flex gap-1 items-center text-white text-sm">
                        <a href="{{ route('admin/downloadlimits/show', $rs['id']) }}" class="px-3 py-1 rounded-md bg-blue-500  hover:bg-blue-600">Chi tiết</a>
                        <a href="{{ route('admin/downloads/show', $rs['id']) }}" class="px-3 py-1 rounded-md bg-green-500 hover:bg-green-600">Lịch sử</a>
                        {{-- <form action="{{ route('admin/users/destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="float-right text-red-800">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form> --}}
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7" class="px-6 py-4 text-center">Không có dữ liệu</td>

            </tr>
            @endif
        </tbody>
    </table>
</div>
</div>
@endsection
