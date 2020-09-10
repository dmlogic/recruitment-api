<?php

namespace Dmlogic\RecruitmentApi\Http\Requests;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Events\ApplicationCreated;
use Dmlogic\RecruitmentApi\Http\Requests\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewApplication extends FormRequest
{
    public function createApplication()
    {
        if($existing = Application::where('email','=',$this->email)->where('position_reference','=',$this->reference)->first()) {
            return $this->handleExistingApplication($existing);
        }

        $application = Application::create([
            'uuid' => Uuid::uuid4(),
            'email' => $this->email,
            'position_reference' => $this->reference,
            'token' => Str::random(),
            'token' => Str::random(),
        ]);
        event(new ApplicationCreated($application));
    }

    protected function handleExistingApplication($existing)
    {
        event(new ApplicationCreated($existing,true));
        throw new HttpResponseException(
            response()->json(['errors' => ['An application for this role is already in progress. We have sent you a reminder of details']], JsonResponse::HTTP_CONFLICT)
        );
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
