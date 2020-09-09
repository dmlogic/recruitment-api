<?php

namespace Dmlogic\RecruitmentApi\Http\Requests;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Http\Requests\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewApplication extends FormRequest
{
    public function createApplication()
    {
        if($existing = Application::where('email','=',$this->email)->where('position_reference','=',$this->reference)->first()) {
            throw new HttpResponseException(
                response()->json(['errors' => ['An application for this role is already in progress']], 400)
            );
        }

        return Application::create([
            'uuid' => Uuid::uuid4(),
            'email' => $this->email,
            'position_reference' => $this->reference,
            'token' => Str::random()
        ]);
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
