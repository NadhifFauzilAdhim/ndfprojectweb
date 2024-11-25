<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->get();
        return view('dashboard.todo.index', [
            'title' => 'To-Do List',
            'todos' => $todos,
        ]);
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'status' => 'required|in:pending,in_progress,completed',
                'priority' => 'required|in:low,medium,high',
                'due_date' => 'nullable|date',
                'color' => 'nullable|string',
            ]);
            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'color' => $request->color,
                'user_id' => Auth::id(), 
            ]);
            return response()->json(['success' => true, 'todo' => $todo], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the status of the to-do item via AJAX.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);
            $todo = Todo::findOrFail($id);
            $todo->update([
                'status' => $request->status,
            ]);
            return response()->json(['success' => true, 'todo' => $todo], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);

        }
    }
    

    /**
     * Remove the specified resource from storage via AJAX.
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->json(['success' => true]);
    }
}
