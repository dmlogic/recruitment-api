CONGRALUTATIONS

You've found the instructions for submitting a job application.

To start, you need to POST a request to this endpoint.
Include data containing your `email` and the `reference`
of the position you wish to apply for.

The resulting response will direct you to the `Location` of the next
request and provide a `token` which should be supplied on all subsequent
requests as a "Authorization: Bearer token" header.

An OPTIONS request to the location provided will provide further instructions.
