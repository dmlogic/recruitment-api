<?php

namespace Dmlogic\RecruitmentApi\Events;

use Illuminate\Queue\SerializesModels;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ApplicationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $application;
    public $resend;

    public function __construct(Application $application, $resend = false)
    {
        $this->application = $application;
        $this->resend = $resend;
    }
}
