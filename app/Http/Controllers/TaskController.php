<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'due_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $request->file('attachment')->move(public_path('uploads'), $fileName);
            $data['attachment'] = $fileName;
        }

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully.');
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $request->file('attachment')->move(public_path('uploads'), $fileName);
            $data['attachment'] = $fileName;
        }

        $task->update($data);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    private function authorizeTask(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
    }
}
