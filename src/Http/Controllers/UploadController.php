<?php

namespace Dmlogic\RecruitmentApi\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Dmlogic\RecruitmentApi\Http\Requests\UploadRequest;

class UploadController extends BaseController
{
    public function docs()
    {
        return \Response::make(
                '',
                200)
                ->header('Allow','OPTIONS, POST')
                ->header('Accept','multipart/form-data, application/x-www-form-urlencoded');
    }

    public function upload(UploadRequest $request)
    {
        \Log::info('upload',[$request->headers]);
        $request->storeFile();
        return response()
                ->json(['message' => 'Your file was uploaded']);
    }
}
