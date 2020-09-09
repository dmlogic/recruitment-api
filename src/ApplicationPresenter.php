<?php

namespace Dmlogic\RecruitmentApi;

class ApplicationPresenter
{
    private $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function toArray()
    {
        return [
            'status' => $this->status(),
            'email' => $this->application->email,
            'name' => $this->application->name,
            'position_reference' => $this->application->position_reference,
            'cover_letter' => $this->application->cover_letter,
            'cv' => $this->cvState(),
            'code_example' => $this->application->code_example,
            'created_at' => $this->application->created_at->toDateTimeString(),
            'updated_at' => $this->application->updated_at->toDateTimeString(),
            'confirmed_at' => $this->application->confirmed_at ? $this->application->confirmed_at->toDateTimeString() : null,
        ];
    }

    protected function status()
    {
        return $this->application->confirmed_at
            ? 'confirmed'
            : 'draft';
    }

    protected function cvState()
    {
        if(!$this->application->cv && !$this->application->cv_upload) {
            return null;
        }

        return $this->application->cv_upload
            ? 'Uploaded: '.$this->application->cv_upload
            : $this->application->cv;
    }

}
