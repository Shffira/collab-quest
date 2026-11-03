<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Ambil tugas milik user yang login; 404 jika tidak ada, 403 jika milik orang lain
    private function findOwned(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak berhak mengakses tugas ini');
        }
        return $task;
    }

    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->latest()->get();
        return response()->json(['data' => $tasks], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $task = $request->user()->tasks()->create($data);

        return response()->json(['message' => 'Tugas dibuat', 'data' => $task], 201);
    }

    public function update(Request $request, $id)
    {
        $task = $this->findOwned($request, $id);

        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $task->update($data);

        return response()->json(['message' => 'Tugas diubah', 'data' => $task], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $task = $this->findOwned($request, $id);

        $data = $request->validate([
            'status' => 'required|in:todo,done',
        ]);

        $task->update($data);

        return response()->json(['message' => 'Status diubah', 'data' => $task], 200);
    }

    public function destroy(Request $request, $id)
    {
        $task = $this->findOwned($request, $id);
        $task->delete();

        return response()->json(['message' => 'Tugas dihapus'], 200);
    }
}