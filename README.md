# Recruitment API

This is a Laravel package that provides a REST API to receive applications for job positions.

The idea with this package is advertise the the endpoint, give the applicant whatever information we choose with a welcome view and let them figure it out from there. If they can, at least some of our filtering job is done.

## Installation

* Create a Laravel 8.x app
* `composer require dmlogic/recruitment-api`
* Copy `views` to your `app/resources/views/vendor` folder and amend as required
* The database tables will need creating. This will not happen automatically. You can copy migrations from "database/migrations" to your app or make tables manually
