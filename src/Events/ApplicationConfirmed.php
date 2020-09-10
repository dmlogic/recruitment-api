<?php

namespace Dmlogic\RecruitmentApi\Events;

use Illuminate\Queue\SerializesModels;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ApplicationConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }
}
