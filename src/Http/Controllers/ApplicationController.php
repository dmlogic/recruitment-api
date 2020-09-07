<?php

namespace Dmlogic\RecruitmentApi\Http\Controllers;

use Dmlogic\RecruitmentApi\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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
}
