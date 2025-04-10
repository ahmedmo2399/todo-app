<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
     use AuthorizesRequests;

     public function index(Request $request)
     {
         $query = Task::query();


         if ($request->has('status') && $request->status !== 'all') {
             $query->where('status', $request->status);
         }


         if ($request->has('query') && $request->query !== '') {
             $query->where('title', 'like', '%' . $request->query . '%')
                   ->orWhere('description', 'like', '%' . $request->query . '%');
         }

         
         $tasks = $query->paginate(10);

         return TaskResource::collection($tasks);
     }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
        ]);

        return new TaskResource($task);
    }

    public function show($id)
{
    $task = Task::find($id);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    return new TaskResource($task);
}


    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->all());

        return new TaskResource($task);
    }


    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }


    public function restore($id)
    {
        $task = Task::withTrashed()->find($id);
        if ($task) {
            $task->restore();
            return new TaskResource($task);
        }

        return response()->json(['message' => 'Task not found'], 404);
    }

    public function filterByStatus(Request $request)
    {

        $status = $request->input('status', 'pending');


        $validStatuses = ['pending', 'in-progress', 'completed'];


        if (!in_array($status, $validStatuses)) {
            $status = 'pending';
        }


        $tasks = Task::where('status', $status)->paginate(10);

        return TaskResource::collection($tasks);
    }



    public function search(Request $request)
    {
        $searchTerm = $request->input('query', '');
        $tasks = Task::where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->paginate(10);
dd($tasks);
        return TaskResource::collection($tasks);
    }
}


