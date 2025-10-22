@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Task</h3>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Attachment</label>
            <input type="file" name="attachment" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
