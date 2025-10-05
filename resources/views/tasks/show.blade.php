@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Task Details</h1>
        <a href="{{ route('tasks.index') }}" class="btn" style="color:blue;">Go To Task List</a>
    </div>
   
    <div class="p-4 border rounded mb-3" style="border-color:#737ec9;">
        <div class="flex justify-between">
            <div>
                <table >
                    <tr><td style="width:200px;"><span class="text-xl font-bold">Title:</span></td><td>{{ $task->title }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Description:</span></td><td>{{ $task->description }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Assigned To:</span></td><td>{{ $task->assignedTo?->name }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Priority:</span></td><td>{{ $task->priority }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Status:</span></td><td>{{ $task->status }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Due Date:</span></td><td>{{ $task->due_date }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Created by:</span></td><td>{{ $task->creator?->name }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Created At:</span></td><td>{{ $task->created_at->format('d M Y, h:i A') }}</td></tr>
                    <tr><td><span class="text-xl font-bold">Updated At:</span></td><td>{{ $task->updated_at->format('d M Y, h:i A') }}</td></tr>
                </table>                
            </div>
            
        </div>
    </div>    
</div>
@endsection
