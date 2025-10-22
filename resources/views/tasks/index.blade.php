@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">My Tasks</h3>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">+ Add Task</a>

    <form method="GET" class="mb-3">
        <select name="status" onchange="this.form.submit()" class="form-select w-25 d-inline">
            <option value="All">All</option>
            <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
            <option value="Completed" {{ request('status')=='Completed'?'selected':'' }}>Completed</option>
        </select>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Attachment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->status }}</td>
                <td>
                    @if($task->attachment)
                        <a href="{{ asset('uploads/'.$task->attachment) }}" target="_blank">View</a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No tasks found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
