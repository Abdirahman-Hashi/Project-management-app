<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Project::query();
            
            // Handle practical filtering scenarios
            if ($status = $request->get('status')) {
                $query->where('status', $status);
            }
            
            if ($request->has('overdue')) {
                $query->overdue();
            }

            // Basic sorting with reasonable defaults
            $sortField = in_array($request->get('sort'), ['name', 'created_at', 'due_date']) 
                ? $request->get('sort') 
                : 'created_at';
                
            $sortDir = $request->get('dir') === 'asc' ? 'asc' : 'desc';
            $query->orderBy($sortField, $sortDir);

            $projects = $query->get();
            return response()->json($projects);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch projects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Practical validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive,completed',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|integer|min:1|max:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project = Project::create($request->all());
            return response()->json($project, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            
            // Only validate fields that are being updated
            $rules = [];
            
            if ($request->has('name')) {
                $rules['name'] = 'required|string|max:255';
            }
            
            if ($request->has('status')) {
                $rules['status'] = 'required|in:active,inactive,completed';
            }
            
            if ($request->has('priority')) {
                $rules['priority'] = 'integer|min:1|max:5';
            }
            
            if ($request->has('due_date')) {
                $rules['due_date'] = 'nullable|date';
            }

            if (count($rules) > 0) {
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
            }

            $project->update($request->all());
            return response()->json($project);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            // Business logic: Don't allow deleting completed projects
            if ($project->status === Project::STATUS_COMPLETED) {
                return response()->json([
                    'message' => 'Completed projects cannot be deleted'
                ], 400);
            }
            
            $project->delete();
            return response()->json(['message' => 'Project deleted successfully']);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete project',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
