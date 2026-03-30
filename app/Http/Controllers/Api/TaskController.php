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
    // Allowed constants
    private const PRIORITIES = ['low', 'medium', 'high'];
    private const STATUS_FLOW = ['pending', 'in_progress', 'done'];

    // CREATE
    public function store(StoreTaskRequest $request){
        try {
            $data = $request->validated();

            // Validate priority
            if (!$this->isValidPriority($data['priority'])) {
                return $this->errorResponse('The selected priority is invalid.', 422);
            }

            // Validate due date
            if (!$this->isValidDueDate($data['due_date'])) {
                return $this->errorResponse('Due date must be today or later', 422);
            }

            // Check for duplicate task
            if ($this->taskExists($data['title'], $data['due_date'])) {
                return $this->errorResponse('A task with the same title and due date already exists.', 422);
            }

            // Create task
            $task = Task::create($data);

            return response()->json([
                'message' => 'Task created successfully',
                'data' => $task
            ], 201);

        } catch (\Throwable $e) {
            return $this->serverErrorResponse($e);
        }
    }

    // LIST
    public function index(Request $request){
        try {
            // Validate status query parameter if present
            $status = $request->query('status');
            if ($status !== null && !in_array($status, self::STATUS_FLOW, true)) {
                return $this->errorResponse(
                    'Invalid status filter',
                    422,
                    ['valid_options' => self::STATUS_FLOW]
                );
            }

            // Build the query
            $query = Task::query();

            if ($status !== null) {
                $query->where('status', $status);
            }

            // Fetch tasks ordered by priority and due date
            $tasks = $query
                ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                ->orderBy('due_date')
                ->get();

            // Return response
            return response()->json([
                'message' => $tasks->isEmpty() ? 'No tasks found' : 'Tasks retrieved successfully',
                'data' => $tasks
            ], 200);

        } catch (\Throwable $e) {
            // Catch-all for any unexpected errors
            return $this->serverErrorResponse($e);
        }
    }

    // UPDATE STATUS
    public function updateStatus(UpdateTaskStatusRequest $request, $id){
        try {
            return DB::transaction(function () use ($request, $id) {
                $task = Task::lockForUpdate()->find($id);

                if (!$task) {
                    return $this->errorResponse('Task not found', 404);
                }

                $newStatus = $request->status;

                // Validate and check status flow
                $statusCheck = $this->validateStatusFlow($task->status, $newStatus);
                if ($statusCheck !== true) {
                    return $this->errorResponse(...$statusCheck);
                }

                $task->update(['status' => $newStatus]);

                return response()->json([
                    'message' => 'Task status updated successfully',
                    'data' => $task
                ], 200);
            });

        } catch (\Throwable $e) {
            return $this->serverErrorResponse($e);
        }
    }

    // DELETE
    public function destroy($id){
        try {
            $task = Task::find($id);

            if (!$task) {
                return $this->errorResponse('Task not found', 404);
            }

            if ($task->status !== 'done') {
                return $this->errorResponse('Only done tasks can be deleted', 403);
            }

            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);

        } catch (\Throwable $e) {
            return $this->serverErrorResponse($e);
        }
    }

    // REPORT
    public function report(Request $request){
        try {
            $date = $request->query('date');

            if (!$date) {
                return $this->errorResponse('Date is required', 422);
            }

            try {
                $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
            } catch (\Exception $e) {
                return $this->errorResponse('Invalid date format. Use YYYY-MM-DD', 422);
            }

            $tasks = Task::whereDate('due_date', $parsedDate)->get();

            $summary = [];
            foreach (self::PRIORITIES as $p) {
                foreach (self::STATUS_FLOW as $s) {
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
            return $this->serverErrorResponse($e);
        }
    }

    // HELPER METHODS
    private function isValidPriority(string $priority): bool {
        return in_array($priority, self::PRIORITIES, true);
    }

    private function isValidDueDate(string $dueDate): bool {
        $today = Carbon::today();
        return Carbon::parse($dueDate)->gte($today);
    }

    private function taskExists(string $title, string $dueDate): bool {
        return Task::where('title', $title)
            ->whereDate('due_date', $dueDate)
            ->exists();
    }

    private function validateStatusFlow(string $current, string $new) {
        if (!in_array($new, self::STATUS_FLOW, true)) {
            return ['The selected status is invalid.', 422, ['valid_options' => self::STATUS_FLOW]];
        }

        $currentIndex = array_search($current, self::STATUS_FLOW, true);
        $newIndex = array_search($new, self::STATUS_FLOW, true);

        if ($currentIndex === false) {
            return ['Invalid current task status in database', 500];
        }

        if ($newIndex === $currentIndex) {
            return ['Task is already in this status', 422];
        }

        if ($newIndex < $currentIndex) {
            return ['Cannot revert status', 422];
        }

        if ($newIndex !== $currentIndex + 1) {
            return ['Cannot skip status progression', 422];
        }

        return true;
    }

    private function errorResponse(string $message, int $code = 422, array $extra = []) {
        return response()->json(array_merge(['error' => $message], $extra), $code);
    }

    private function serverErrorResponse(\Throwable $e) {
        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}