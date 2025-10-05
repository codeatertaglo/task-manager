<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TaskController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        return [
            // Apply 'auth' middleware to all methods in this controller
            'auth',

            // Or, for more granular control:
            // new Middleware(middleware: 'auth', except: ['index', 'show']),
            // new Middleware(middleware: 'auth:sanctum', only: ['store', 'update']),
        ];
    } 

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $tasks = Task::with(['assignedTo','creator'])->latest()->paginate(10);
        } else {
            $tasks = Task::where('assigned_to', $user->id)
                         ->orWhere('created_by', $user->id)
                         ->with(['assignedTo','creator'])
                         ->latest()
                         ->paginate(10);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Admin may choose to assign while creating; non-admins create unassigned
        $users = User::where('role','user')->get();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|string',
            // assigned_to will be set only if admin selects
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data['created_by'] = Auth::id();

        // only allow admin to force assignment on creation
        if (Auth::user()->role !== 'admin') {
            $data['assigned_to'] = null;
        }

        Task::create($data);

        return redirect()->route('tasks.index')->with('success','Task created.');
    }

    public function show(Task $task)
    {   
        //dd($task);     
        $this->authorize('view', $task);
        $taskdet = Task::with(['assignedTo','creator'])->find($task->id);
                         ///dd($taskdet->creator?->name);
        return view('tasks.show', ['task' => $taskdet]);
    }

    public function edit(Task $task)
    {
        //dd($task);
        $this->authorize('update', $task);
        $users = User::where('role','user')->get();
        return view('tasks.edit', compact('task','users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'nullable|string',
        ]);

        // only admin can assign/unassign
        //dd($request->input('assigned_to'));
        if (Auth::user()->role !== 'admin') {
            unset($data['assigned_to']);
        }
        else
        {
            $data['assigned_to']=$request->input('assigned_to');
        }
        
        $task=Task::find($request->input('id'));        
        $task->update($data);
        return redirect()->route('tasks.index')->with('success','Task updated.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return back()->with('success','Task deleted.');
    }

    // Admin assign endpoint
    public function assign(Request $request, Task $task)
    {
        $this->authorize('assign', $task);

        $request->validate(['assigned_to' => 'required|exists:users,id']);
        $task->assigned_to = $request->assigned_to;
        $task->save();

        return back()->with('success','Task assigned.');
    }

    // Assigned user or admin can change status
    public function changeStatus(Request $request, Task $task)
    {
        $this->authorize('changeStatus', $task);

        $request->validate(['status' => 'required|in:pending,inprogress,completed']);
        $task->status = $request->status;
        $task->save();

        return back()->with('success','Status updated.');
    }
}
