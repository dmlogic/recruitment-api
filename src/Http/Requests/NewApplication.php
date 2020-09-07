<?php

namespace Dmlogic\RecruitmentApi\Http\Requests;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Http\Requests\FormRequest;

class NewApplication extends FormRequest
{
    public function createApplication()
    {
        return Application::create([
            'uuid' => Uuid::uuid4(),
            'email' => $this->email,
            'position_reference' => $this->reference,
            'token' => Str::random()
        ]);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'reference' => 'required|exists:positions,reference,deleted_at,NULL'
        ];
    }

    public function messages()
    {
        return [
            'reference.exists' => 'No open position for this reference',
        ];
    }
}
