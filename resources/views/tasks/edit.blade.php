@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Task</h3>

    <form action="{{ route('tasks.update',$task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input name="title" value="{{ $task->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" value="{{ $task->due_date }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Pending" {{ $task->status=='Pending'?'selected':'' }}>Pending</option>
                <option value="Completed" {{ $task->status=='Completed'?'selected':'' }}>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Attachment</label>
            <input type="file" name="attachment" class="form-control">
            @if($task->attachment)
                <p>Current: <a href="{{ asset('uploads/'.$task->attachment) }}" target="_blank">View</a></p>
            @endif
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
