@extends('layouts.app')

@section('title', 'Create User')

@section('contents')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">Tạo License Máy</h1>

        <form action="{{ route('admin.licenses.machines.store') }}" method="PUT" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            @csrf
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Người dùng:</label>
                <select id="user_id" name="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="" disabled selected>Chọn người dùng</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }} - {{ $user->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="machine_name" class="block text-gray-700 text-sm font-bold mb-2">Tên Máy:</label>
                <input type="text" id="machine_name" name="machine_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nhập tên máy">
            </div>

            <div class="mb-4">
                <label for="machine_details" class="block text-gray-700 text-sm font-bold mb-2">Chi Tiết Máy:</label>
                <textarea id="machine_details" name="machine_details" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nhập chi tiết máy" required></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Thêm Mới License
                </button>
            </div>
        </form>
    </div>

@endsection
