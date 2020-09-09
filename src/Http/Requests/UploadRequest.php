<?php

namespace Dmlogic\RecruitmentApi\Http\Requests;

use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Http\Requests\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadRequest extends FormRequest
{
    public function storeFile()
    {
        $file = $this->file('file');
        $application = $this->attributes->get('application');
        $filename = $file->hashName();
        $file->storeAs($application->uuid, $filename, 'cv_uploads');
        $application->cv_upload = $filename;
        $application->save();
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:pdf|max:2048',
        ];
    }
}
