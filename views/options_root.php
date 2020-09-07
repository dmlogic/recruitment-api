CONGRALUTATIONS

You've found the instructions for submitting a job application.

We gave you a pretty big clue though, so there's more to do.

To start, you need to POST a json request to this endpoint.
Include a data object containing your `email` and the `reference`
of the role you wish to apply for.

The resulting response will include a `token` which should be resubmitted
on all subsequent requests as a "Authorization: Bearer <token>" header.

You will also be given a new endpoint for completing your application.
A GET request on that endpoint will provide further information.
