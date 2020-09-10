<?php

namespace Dmlogic\RecruitmentApi\Http\Controllers;

use Dmlogic\RecruitmentApi\Http\Request;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Routing\Controller as BaseController;
use Dmlogic\RecruitmentApi\Http\Requests\NewApplication;

class StartApplication extends BaseController
{
    public function welcome()
    {
        return \Response::make(\View::make('recruitment::welcome'),200)
                ->header('Allow','OPTIONS, GET, POST');
    }

    public function docs()
    {
        return \Response::make(\View::make('recruitment::options_root'),200)
                        ->header('Content-Type','text/plain')
                        ->header('Allow','OPTIONS, GET, POST')
                        ->header('Accept','application/json, multipart/form-data, application/x-www-form-urlencoded');
    }

    public function create(NewApplication $request)
    {
        $request->createApplication();
        return response()
                    ->json([
                        'message' => 'Your application has been created. Please check your email for more details.',
                    ],201);
    }

}
