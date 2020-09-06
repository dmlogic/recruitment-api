# Recruitment API

This is a Laravel package that provides a REST API to receive applications for job positions.

I find it very time consuming to filter the good from the bad with development applications. But it also has to be me that does it if I'm being fussy - which I generally am.

The idea with this package is advertise the the endpoint, give the applicant whatever information we choose with a welcome view and let them figure it out from there. If they can, at least some of our filtering job is done.

## Installation

* Create a Laravel 8.x app
* `composer require dmlogic/recruitment-api`
* Save `resources/welcome.sample.php` to `resources.php` and amend as required
* Run database migrations and populate the `positions` table
