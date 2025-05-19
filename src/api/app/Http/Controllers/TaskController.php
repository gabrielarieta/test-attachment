<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskModelRequest;
use App\Http\Requests\UpdateTaskModelRequest;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskRepository;

    private $taskService;

    public function __construct(TaskRepository $taskRepository , TaskService $taskService)
    {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
                "data" => $this->taskRepository->all(),
            ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskModelRequest $request)
    {
        try {
            return response()->json([
                "data"    => $this->taskRepository->store($request->all(), true),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json([
                "data"    => $this->taskRepository->findByPk($id),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskModelRequest $request, string $id)
    {
        try {
            return response()->json([
                "data"    => $this->taskRepository->update($id,$request->all(), true),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json([
                "data"    => $this->taskRepository->delete( $id ),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Attach file to task.
     */
    public function attach(string $id, Request $request)
    {
        try {
            return response()->json([
                "data"    => $this->taskService->attachFile($id,$request->file)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
            ], 500);
        }
    }
}
