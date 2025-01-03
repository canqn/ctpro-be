@extends('layouts.app')

@section('title', 'Chỉnh sửa Download Limit')

@section('contents')
<div class="container mx-auto max-w-2xl py-8">
    <h1 class="text-2xl font-bold mb-6">Chỉnh sửa Download Limit</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <strong>Oops!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin/downloadlimits/update', $downloadLimit->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="user_name" class="block text-gray-700 font-bold mb-2">Username:</label>
            <input type="text" id="user_name" name="user_name" value="{{ $downloadLimit->user->username }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
        </div>
        <div class="mb-6">
            <label for="download_limit" class="block text-gray-700 font-bold mb-2">Download Limit:</label>
            <input type="text" id="download_limit" name="download_limit" value="{{ $downloadLimit->download_limit }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter Download Limit">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
