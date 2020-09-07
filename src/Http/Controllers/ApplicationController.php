<?php

namespace Dmlogic\RecruitmentApi\Http\Controllers;

use Dmlogic\RecruitmentApi\Http\Request;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Routing\Controller as BaseController;
use Dmlogic\RecruitmentApi\Http\Requests\NewApplication;

class ApplicationController extends BaseController
{
    public function welcome()
    {
        return view('recruitment::welcome');
    }

    public function docs()
    {
        return \Response::make(\View::make('recruitment::options_root'),200)
                        ->header('Content-Type','text/plain');
    }

    public function create(NewApplication $request)
    {
        if($existing = Application::where('email','=',$request->email)->where('position_reference','=',$request->reference)->first()) {
            return response()
                    ->json(['error' => 'An application for this role is already in progress'],400);
        }
        $application = $request->createApplication();
        return response()
                    ->json(['token' => $application->token],201)
                    ->header('Location','/recruitment/'.$application->uuid);
    }
}
