@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Task List</h1>
        <a href="{{ route('tasks.create') }}" class="btn" style="color:blue;">Create Task</a>
    </div>
    @if ($tasks->isEmpty())
        <div class="no-tasks-message" style="align:center; color:red;">
            <p>Sorry there is no such task found that has been assigned to you or created by you. Please create some tasks.</p>
        </div>
    @else
    @foreach($tasks as $task)
    <div class="p-4 border rounded mb-3" style="border-color:#737ec9;">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-bold">{{ $task->title }}</h2>
                <p>{{ Str::limit($task->description, 120) }}</p>
                <p><span style="color:red;">Assigned to:</span> {{ $task->assignedTo?->name ?? 'Unassigned' }}</p>
                <p><span style="color:red;">Priority:</span> {{ $task->priority }} | <span style="color:red;">Status:</span> {{ $task->status }}</p>
            </div>
            <div class="text-right">
                <a href="{{ route('tasks.show', $task) }}" class="btn text-blue-600 mr-4" style="color:blue;">View</a>
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn text-blue-600 ml-4" style="color:blue;">Edit</a>
                @endcan
                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('tasks.assign', $task) }}" method="POST" class="mt-2">
                        @csrf
                        <select name="assigned_to" required class="border p-1" style="width:180px;">
                            <option value="">-- assign to --</option>
                            @foreach(\App\Models\User::where('role','user')->get() as $u)
                                <option value="{{ $u->id }}" @if($task->assigned_to == $u->id) selected @else '' @endif>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn" style="background-color:blue;color:white;height:32px;padding-left:5px;padding-right:5px;border-radius:5px;">Assign</button>
                    </form>
                @endif
                @if(auth()->user()->role === 'admin' || auth()->user()->id == $task->assigned_to) 
                    <form action="{{ route('tasks.changeStatus', $task) }}" method="POST" class="mt-2">
                        @csrf
                        <select name="status" required class="border p-1" style="width:120px;">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inprogress" {{ $task->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            
                        </select>
                        <button style="background-color:blue;color:white;height:32px;padding-left:4px;padding-right:4px;border-radius:5px;"  >Change Status</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @endif

    {{ $tasks->links() }}
</div>
@endsection
