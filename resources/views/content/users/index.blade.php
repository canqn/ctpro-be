@extends('layouts.app')

@section('title', 'Danh sách người dùng')

@section('contents')
<div>
    <div class="mb-3">
        <h1 class="font-bold text-xl mb-3">DANH SÁCH NGƯỜI DÙNG</h1>
        <a href="{{ route('admin/users/create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none dark:focus:ring-blue-800">Thêm người dùng</a>
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
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Joining Date</th>
                    <th scope="col" class="px-6 py-3">Active</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($user->count() > 0)
                @foreach($user as $rs)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="font-medium text-gray-900 whitespace-nowrap px-6 py-3">
                        {{ $loop->iteration }}
                    </th>
                    <td class="px-6 py-3">
                        {{ $rs->username }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $rs->email }}
                    </td>
                    <td class="px-6 py-3">
                        @if($rs->role == 'admin')
                            <span class="bg-red-500 text-white px-2 py-1 rounded">Admin</span>
                        @elseif($rs->role == 'user')
                            <span class="bg-blue-500 text-white px-2 py-1 rounded">User</span>
                        @elseif($rs->role == 'mod')
                            <span class="bg-green-500 text-white px-2 py-1 rounded">Mod</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">
                        {{ $rs->created_at }}
                    </td>
                    <td class="px-6 py-3">
                        @if($rs->is_active == 1)
                            <span class='px-2 text-sm font-medium rounded-sm bg-blue-300 text-blue-500'>ACTIVE</span>
                        @else
                            <span class='px-2 text-sm font-medium rounded-sm bg-red-300 text-red-500'>BLOCK</span>
                        @endif
                    </td>
                    <td class="w-36 px-6 py-3">
                        <div class="flex gap-2 items-center text-white text-sm">
                            <a href="{{ route('admin/users/show', $rs->id) }}" class="px-3 py-1 rounded-md bg-blue-500 hover:bg-blue-600"><i class='bx bx-info-circle'></i></a>
                            <a href="{{ route('admin/users/edit', $rs->id)}}" class="px-3 py-1 rounded-md bg-green-500 hover:bg-green-600"><i class='bx bx-edit'></i></a>
                            <form action="{{ route('admin/users/destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="px-3 py-1 rounded-md bg-red-500 hover:bg-red-600">
                                @csrf
                                @method('DELETE')
                                <button><i class='bx bxs-message-rounded-x'></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center px-6 py-3" colspan="7">User not found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

     <!-- Phân trang -->
    <div class="mt-4">
        {{ $user->links() }}
    </div>
</div>
@endsection
