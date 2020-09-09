<?php

namespace Dmlogic\RecruitmentApi\Http\Requests;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Http\Requests\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateApplication extends FormRequest
{
    public function applyUpdate()
    {
        $application = $this->attributes->get('application');

        if($application->confirmed_at) {
            throw new HttpResponseException(
                response()->json(['errors' => ['This application has aleady been confirmed']], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
        if(!$attributes = Arr::only($this->all(),['name','cover_letter','cv','code_example'])) {
            throw new HttpResponseException(
                response()->json(['errors' => ['No submitted data was detected']], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
        $application->fill($attributes);
        $application->save();
    }

    public function rules()
    {
        return [
            'name' => 'nullable|min:5',
            'cover_letter' => 'nullable|min:10',
            'cv' => 'nullable|min:10',
            'code_example' => 'nullable|min:10'
        ];
    }
}
