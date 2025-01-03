@extends('layouts.app')

@section('title', 'Create User')

@section('contents')
<h1 class="text-2xl font-bold mb-4">Thêm mới người dùng</h1>
<hr />

<div class="container mx-auto px-4 py-8">
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-3 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded shadow-md p-6">
        <form action="{{ route('admin/users/store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-input mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-input mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" class="form-select mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1">
                    <option value="">Choose Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                <select id="is_active" name="is_active" class="form-select mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1">
                    <option value="">Choose Status</option>
                    <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="mt-4 bg-indigo-600 text-white font-bold py-2 px-4 rounded shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">Create User</button>
        </form>
    </div>
</div>
@endsection
