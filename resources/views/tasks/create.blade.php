@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header row for titles -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Create Task</h1>
        <h1 class="text-2xl font-bold text-blue-600 cursor-pointer hover:underline"><a href="{{ route('tasks.index') }}" class="btn" style="color:blue;">Go To Task List</a></h1>
    </div>

    <!-- Task form -->
    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
        @csrf
        <input name="title" placeholder="Title" required
            class="w-full border rounded-lg p-2" />
        <textarea name="description" placeholder="Description"
            class="w-full border rounded-lg p-2 mt-4"></textarea>
        <input type="date" name="due_date"
            class="w-full border rounded-lg p-2" />
        <select name="priority" class="w-full border rounded-lg p-2 mt-4">
            <option value="low">Low</option>
            <option value="normal" selected>Normal</option>
            <option value="high">High</option>
        </select>

        @if(auth()->user()->role === 'admin')
            <label class="block font-semibold">Assign to:</label>
            <select name="assigned_to" class="w-full border rounded-lg p-2 mb-4">
                <option value="">-- none --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        @endif
        
        <button type="submit" style="background-color:blue; color:white;"  class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 mt-4">
            Create
        </button>
        
    </form>
</div>
@endsection
