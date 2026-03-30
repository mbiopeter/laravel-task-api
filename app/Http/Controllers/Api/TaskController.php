<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Carbon\Carbon;

class TaskController extends Controller
{
    // CREATE
    public function store(StoreTaskRequest $request)
    {
        try {
            $data = $request->validated();

            $exists = Task::where('title', $data['title'])
                ->whereDate('due_date', $data['due_date'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => 'A task with the same title and due date already exists.'
                ], 422);
            }

            $task = Task::create($data);

            return response()->json([
                'message' => 'Task created successfully',
                'data' => $task
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // LIST
    public function index(Request $request)
    {
        try {
            $query = Task::query();

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $tasks = $query
                ->orderByRaw("FIELD(priority,'high','medium','low')")
                ->orderBy('due_date')
                ->get();

            if ($tasks->isEmpty()) {
                return response()->json([
                    'message' => 'No tasks found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'data' => $tasks
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // UPDATE STATUS
    public function updateStatus(UpdateTaskStatusRequest $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $task = Task::lockForUpdate()->find($id);

                if (!$task) {
                    return response()->json([
                        'error' => 'Task not found'
                    ], 404);
                }

                $newStatus = $request->status;

                $flow = ['pending', 'in_progress', 'done'];

                $currentIndex = array_search($task->status, $flow);
                $newIndex = array_search($newStatus, $flow);

                if ($newIndex === false) {
                    return response()->json([
                        'error' => 'Invalid status value'
                    ], 422);
                }

                if ($newIndex < $currentIndex) {
                    return response()->json([
                        'error' => 'Cannot revert status'
                    ], 422);
                }

                if ($newIndex > $currentIndex + 1) {
                    return response()->json([
                        'error' => 'Cannot skip status progression'
                    ], 422);
                }

                if ($newIndex === $currentIndex) {
                    return response()->json([
                        'error' => 'Task is already in this status'
                    ], 422);
                }

                $task->status = $newStatus;
                $task->save();

                return response()->json([
                    'message' => 'Task status updated successfully',
                    'data' => $task
                ], 200);
            });

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE
    public function destroy($id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'error' => 'Task not found'
                ], 404);
            }

            if ($task->status !== 'done') {
                return response()->json([
                    'error' => 'Only done tasks can be deleted'
                ], 403);
            }

            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // REPORT
    public function report(Request $request)
    {
        try {
            $date = $request->query('date');

            if (!$date) {
                return response()->json([
                    'error' => 'Date is required'
                ], 422);
            }

            try {
                $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Invalid date format. Use YYYY-MM-DD'
                ], 422);
            }

            $tasks = Task::whereDate('due_date', $parsedDate)->get();

            $priorities = ['high', 'medium', 'low'];
            $statuses = ['pending', 'in_progress', 'done'];

            $summary = [];

            foreach ($priorities as $p) {
                foreach ($statuses as $s) {
                    $summary[$p][$s] = $tasks
                        ->where('priority', $p)
                        ->where('status', $s)
                        ->count();
                }
            }

            return response()->json([
                'date' => $date,
                'summary' => $summary
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}