<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskController extends Controller
{
    // CREATE
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        // Check for duplicate task (same title + due_date)
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
    }

    // LIST
    public function index(Request $request){
        $query = Task::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tasks = $query
            ->orderByRaw("FIELD(priority,'high','medium','low')")
            ->orderBy('due_date')
            ->get();

        return $tasks->isEmpty()
            ? response()->json(['message' => 'No tasks found'])
            : response()->json($tasks);
    }

    // UPDATE STATUS
    public function updateStatus(UpdateTaskStatusRequest $request, $id){
        return DB::transaction(function () use ($id, $request) {

            $task = Task::lockForUpdate()->findOrFail($id);
            $newStatus = $request->status;

            // Define acceptable order
            $flow = ['pending', 'in_progress', 'done'];

            $currentIndex = array_search($task->status, $flow);
            $newIndex = array_search($newStatus, $flow);

            // Invalid status value
            if ($newIndex === false) {
                return response()->json([
                    'error' => 'Invalid status value'
                ], 422);
            }

            // Revert status (going backwards)
            if ($newIndex < $currentIndex) {
                return response()->json([
                    'error' => 'Cannot revert status'
                ], 422);
            }

            // Skip status (jumping forward more than 1 step)
            if ($newIndex > $currentIndex + 1) {
                return response()->json([
                    'error' => 'Cannot skip status progression'
                ], 422);
            }

            // Same status
            if ($newIndex === $currentIndex) {
                return response()->json([
                    'error' => 'Task is already in this status'
                ], 422);
            }

            // Valid transition
            $task->status = $newStatus;
            $task->save();

            return response()->json([
                'message' => 'Task status updated successfully',
                'task' => $task
            ]);
        });
    }

    // DELETE
    public function destroy($id){
        $task = Task::findOrFail($id);

        //deny deletion of undone tasks
        if ($task->status !== 'done') {
            return response()->json(['error' => 'Only done tasks can be deleted'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    // REPORT
    public function report(Request $request){
        $date = $request->query('date');

        // Missing date
        if (!$date) {
            return response()->json([
                'error' => 'Date is required'
            ], 422);
        }

        // Invalid date format
        if (!\Carbon\Carbon::hasFormat($date, 'Y-m-d')) {
            return response()->json([
                'error' => 'Invalid date format. Use YYYY-MM-DD'
            ], 422);
        }

        $tasks = Task::whereDate('due_date', $date)->get();

        $priorities = ['high', 'medium', 'low'];
        $statuses = ['pending', 'in_progress', 'done'];

        $summary = [];

        //order by priority(high -> medium -> low) fast then by status
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
        ]);
    }
}