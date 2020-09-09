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
        if($existing = Application::where('email','=',$request->email)->where('position_reference','=',$request->reference)->first()) {
            return response()
                    ->json(['errors' => ['An application for this role is already in progress']],400);
        }
        $application = $request->createApplication();
        $url = route('view',['uuid' => $application->uuid]);
        return response()
                    ->json([
                        'token' => $application->token,
                        'application_url' => $url
                    ],201)
                    ->header('Location',$url);
    }

}
