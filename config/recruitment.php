<?php

return [
    /**
     * The root-level endpoint at which this package will be accessible
     */
    'endpoint' => 'api',

    /**
     * The name of the Storage configuration to use for uploads
     */
    'storage' => 'cv_uploads',

    /**
     * Who receives notifications of new submissions
     */
    'hr_email' => env('RECRUITMENT_HR_EMAIL', 'hr@example.com'),
];
