<?php

namespace App\Http\Requests\School\Classroom;

use App\Http\Requests\RequestResource;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest implements RequestResource
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        switch ($this->method()) {
            case 'POST':
                $rules = $this->getCreateRules();
                break;
            case 'PUT':
                $rules = $this->getUpdateRules();
                break;
            case 'DELETE':
                $rules = $this->getDeleteRules();
                break;
        }

        return $rules;
    }

    /**
     * Get Create Rules
     *
     * @return array
     */
    public function getCreateRules(): array
    {
        return [
            'competencies' => [
                'required', 'array', 'min:1'
            ],
            'competencies.*.id' => [
                'required', 'uuid', 'exists:competencies,id'
            ],
            'competencies.*.classrooms' => [
                'required', 'array', 'min:1'
            ],
            'competencies.*.classrooms.*' => [
                'required', 'string'
            ]
        ];
    }

    /**
     * Get Update Rules
     *
     * @return array
     */
    public function getUpdateRules(): array
    {
        return [
            'competency_id' => [
                'required'
            ],
            'competency_id.*' => [
                'uuid', 'exists:competencies,id'
            ],
            'name' => [
                'required'
            ],
            'name.*' => [
                'string'
            ]
        ];
    }

    /**
     * Get Delete Rules
     *
     * @return array
     */
    public function getDeleteRules(): array
    {
        return [
            'ids' => [
                'required', 'array', 'min:1'
            ],
            'ids.*' => [
                'uuid', 'exists:classrooms,id'
            ]
        ];
    }

    /**
     * Set Custom Message Error
     *
     * @return array
     */
    public function messages()
    {
        return [

            // Create Messages
            'competencies.required' => 'Kompetensi wajib diisi',
            'competencies.array' => 'Kompetensi harus berupa array',
            'competencies.min' => 'Minimal 1 kompetensi diperlukan',
            'competencies.*.id.required' => 'ID kompetensi diperlukan',
            'competencies.*.id.uuid' => 'ID kompetensi tidak valid',
            'competencies.*.id.exists' => 'ID kompetensi tidak ditemukan',
            'competencies.*.classrooms.required' => 'Kelas diperlukan',
            'competencies.*.classrooms.array' => 'Kelas harus berupa array',
            'competencies.*.classrooms.min' => 'Minimal 1 kelas diperlukan',
            'competencies.*.classrooms.*.required' => 'Nama kelas diperlukan',
            'competencies.*.classrooms.*.string' => 'Nama kelas harus berupa string',

            // Update Messages

            // Delete Messages
            'ids.required' => 'Id Kompetensi wajib diisi',
            'ids.array' => 'Id Kompetensi harus berupa array',
            'ids.min' => 'Minimal terdapat 1 item Id',
            'ids.*.uuid' => 'Id harus berupa UUID',
            'ids.*.exists' => 'Id tidak valid'
        ];
    }
}
