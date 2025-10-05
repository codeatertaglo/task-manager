@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn">Create Task</a>
    </div>

    @foreach($tasks as $task)
    <div class="p-4 border rounded mb-3">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-bold">{{ $task->title }}</h2>
                <p>{{ Str::limit($task->description, 120) }}</p>
                <p>Assigned to: {{ $task->assignedTo?->name ?? 'Unassigned' }}</p>
                <p>Priority: {{ $task->priority }} | Status: {{ $task->status }}</p>
            </div>
            <div class="text-right">
                <a href="{{ route('tasks.show', $task) }}" class="btn">View</a>
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn">Edit</a>
                @endcan
                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('tasks.assign', $task) }}" method="POST" class="mt-2">
                        @csrf
                        <select name="assigned_to" required class="border p-1">
                            <option value="">-- assign to --</option>
                            @foreach(\App\Models\User::where('role','user')->get() as $u)
                                <option value="{{ $u->id }}" @if($task->assigned_to == $u->id) selected @endif>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn">Assign</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    {{ $tasks->links() }}
</div>
@endsection
