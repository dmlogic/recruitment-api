# Recruitment API

This is a Laravel package that provides a REST API to receive applications for job positions.

The idea with this package is advertise the endpoint, give the applicant whatever information we choose with a welcome view and let them figure it out from there. If they can, at least some of our candidate filtering is done.

## Application process

* The applicant is directed to GET /api where any instructions you wish to give are shown
* The applicant is expected to discover detailed instructions at OPTIONS /api
* The applicant submits to POST /api with `email` and position `reference`
* A notification is implemented to send the applicant their unique URL and access token. The URL is `route('view',['uuid' => $application->uuid'])`
* The applicant finds details instructions at OPTIONS /{$url}
* The applicant submits one or more requests to POST|PUT|PATCH /{$url} until all fields are complete
* The applicant optionally uploads a CV to POST /{$url}/cv_upload
* The applicant reviews their data at GET /{$url}
* Once happy, the applicant submits to POST /{$url}/confirm
* A notification is implemented to advise of a confirmed submission


## Notifications

This package does not make any assumptions about the notifications you'd like to send. Instead it fires events at appropriate times so you can implement the notitification workflow of your choice.

## Installation

* Create a Laravel 8.x app
* `composer require dmlogic/recruitment-api`
* Copy `views` to your `app/resources/views/vendor` folder and amend as required
* The database tables will need creating. This will not happen automatically. You can copy migrations from "database/migrations" to your app or make tables manually
* Implement appropriate listeners for `ApplicationCreated` and `ApplicationConfirmed`
* Set a `recruitment.endpoint` config value if "api" is not appropriate
* Set `recruitment.storage` to the name of your storage location if "cv_uploads" is not appropriate
