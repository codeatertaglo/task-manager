@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h1>Update Task</h1>
    <form action="{{ route('tasks.update') }}" method="POST">
        @csrf
        <input name="title" placeholder="Title" value="{{ old('title', $task->title) }}" required />
        <textarea name="description" placeholder="Description">{{ old('title', $task->description) }}</textarea>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" />
        <select name="priority">
            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
            <option value="normal" {{ old('priority', $task->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
        </select>

        @if(auth()->user()->role === 'admin')
            <label>Assign to:</label>
            <select name="assigned_to">
                <option value="">-- none --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ old('assigned_to', $task->assigned_to) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        @endif
        <input type="hidden" name="id" value="{{$task->id}}" />
        <button type="submit" style="background-color: blue;width:100px;height: 42px;Color: white;">Update</button>
    </form>
</div>
@endsection
