<?php

namespace Dmlogic\RecruitmentApi\Http\Controllers;

use Illuminate\Http\Request;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Routing\Controller as BaseController;
use Dmlogic\RecruitmentApi\Http\Requests\UpdateApplication;

class SubmitApplication extends BaseController
{
    public function instructions(Request $request)
    {
        return \Response::make(
                \View::make('recruitment::options_instructions',['uuid' => $request->attributes->get('application')->uuid]),
                200)
                ->header('Content-Type','text/plain')
                ->header('Allow','OPTIONS, GET, PUT, PATCH, POST')
                ->header('Accept','application/json, multipart/form-data, application/x-www-form-urlencoded');
    }

    public function view(Request $request)
    {
        return response()
                    ->json($request->attributes->get('application')->toArray(),200);
    }

    public function update(UpdateApplication $request)
    {
        $request->applyUpdate();
        return response()
                ->json(['message' => 'Your application has been updated']);
    }

    public function confirm(Request $request)
    {
        $application = $request->attributes->get('application');
        if(!$application->isComplete()) {
            return response()
                    ->json(['errors' => ['This application is not yet complete']],400);
        }
        $application->confirmed_at = now();
        $application->save();
        return response()
                ->json(['message' => 'Your application has been confirmed']);
    }


}
