@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header row for titles -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Update Task</h1>
        <h1 class="text-2xl font-bold text-blue-600 cursor-pointer hover:underline"><a href="{{ route('tasks.index') }}" class="btn" style="color:blue;">Go To Task List</a></h1>
    </div>

    <!-- Task form -->
    <form action="{{ route('tasks.update') }}" method="POST" class="space-y-4">
        @csrf
        <input name="title" placeholder="Title" value="{{ old('title', $task->title) }}" required
            class="w-full border rounded-lg p-2" />
        <textarea name="description" placeholder="Description"
            class="w-full border rounded-lg p-2 mt-4">{{ old('title', $task->description) }}</textarea>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" 
            class="w-full border rounded-lg p-2" />
        <select name="priority" class="w-full border rounded-lg p-2 mt-4">
            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
            <option value="normal" {{ old('priority', $task->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
        </select>

        @if(auth()->user()->role === 'admin')
            <label class="block font-semibold">Assign to:</label>
            <select name="assigned_to" class="w-full border rounded-lg p-2 mb-4">
                <option value="">-- none --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ old('assigned_to', $task->assigned_to) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        @endif
        <input type="hidden" name="id" value="{{$task->id}}" />
        <button type="submit" style="background-color:blue; color:white;"  class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 mt-4">
            Update
        </button>
        
    </form>
</div>
@endsection
