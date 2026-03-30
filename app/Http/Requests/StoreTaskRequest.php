<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
            'status' => ['required', 'in:pending,in_progress,done']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'due_date.required' => 'Due date is required',
            'due_date.after_or_equal' => 'Due date must be today or later',
            'priority.required' => 'Priority is required',
            'priority.in' => 'The selected priority is invalid.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status. Allowed values: pending, in_progress, done.'
        ];
    }

    /**
     * Force JSON response for validation errors (Laravel 13)
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors()->first();

        throw new HttpResponseException(
            response()->json([
                'error' => $message
            ], 422)
        );
    }

}