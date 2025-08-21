<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        $userId = Auth::user()->id;
        $taskId = $this->request->get('id');
        $taskOwnerId = Task::find($taskId)->first()->creator_id;
        if ($userId == $taskOwnerId) {
            return true;
        }

        $projectId = $this->request->get('project_id');
        $projectOwnerId = Project::find($projectId)->first()->creator_id;
        return $userId == $projectOwnerId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|string|in:Pending,In Progress,Completed',
            'due_date' => 'required|date',
        ];
    }
}
