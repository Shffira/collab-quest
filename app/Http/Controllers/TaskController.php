<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

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

    #[OA\Get(
        path: '/tasks',
        tags: ['Tasks'],
        summary: 'Daftar tugas milik user',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar tugas'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
        ]
    )]
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->latest()->get();
        return response()->json(['data' => $tasks], 200);
    }

    #[OA\Post(
        path: '/tasks',
        tags: ['Tasks'],
        summary: 'Tambah tugas',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Belajar Laravel'),
                    new OA\Property(property: 'deadline', type: 'string', format: 'date', example: '2026-11-10'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Tugas dibuat'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $task = $request->user()->tasks()->create($data);

        return response()->json(['message' => 'Tugas dibuat', 'data' => $task], 201);
    }

    #[OA\Put(
        path: '/tasks/{id}',
        tags: ['Tasks'],
        summary: 'Ubah judul/deadline tugas',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Belajar Sanctum'),
                    new OA\Property(property: 'deadline', type: 'string', format: 'date', example: '2026-11-12'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Tugas diubah'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 403, description: 'Bukan tugas milik Anda'),
            new OA\Response(response: 404, description: 'Tugas tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
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

    #[OA\Patch(
        path: '/tasks/{id}/status',
        tags: ['Tasks'],
        summary: 'Ubah status tugas (todo/done)',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['todo', 'done'], example: 'done'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status diubah'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 403, description: 'Bukan tugas milik Anda'),
            new OA\Response(response: 404, description: 'Tugas tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function updateStatus(Request $request, $id)
    {
        $task = $this->findOwned($request, $id);

        $data = $request->validate([
            'status' => 'required|in:todo,done',
        ]);

        $task->update($data);

        return response()->json(['message' => 'Status diubah', 'data' => $task], 200);
    }

    #[OA\Delete(
        path: '/tasks/{id}',
        tags: ['Tasks'],
        summary: 'Hapus tugas',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tugas dihapus'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 403, description: 'Bukan tugas milik Anda'),
            new OA\Response(response: 404, description: 'Tugas tidak ditemukan'),
        ]
    )]
    public function destroy(Request $request, $id)
    {
        $task = $this->findOwned($request, $id);
        $task->delete();

        return response()->json(['message' => 'Tugas dihapus'], 200);
    }
}