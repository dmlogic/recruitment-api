# APPLICATION INSTRUCTIONS

## FILLING IN YOUR APPLICATION

Now your application is started, you can send a request to this endpoint with
the data described below. All fields are required before your application can
be confirmed. We accept various types of submission to support a variety of
http clients. See headers of this response for details. (Please note if you
wish to use "multipart/form-data" content type, you must POST your data)

### Applcation fields

Field: name
Description: Your full name
Format: Text

Field: cover_letter
Description: Introduce yourself & explain why you are interested in this role
Format: Text (multi line acceptable)

Field: cv
Description: An up-to-date CV/Resume
Format: We accept plain text  (multi line acceptable) or a URL. If you would
        prefer to upload a file, see "UPLOADING YOUR CV" below

Field: code_examples
Description: Links to examples of relevant code, this would typically be a
             GitHub profile. If you do not have code to share, please use this
             field to persuade us we should still consider you. We understand
             that not all work can be in the public domain but this is a
             senior position and we need to know you can code.
Format: Text (multi line acceptable)

## UPLOADING YOUR CV

We accept PDF file formats up to 2Mb in size

Please POST your file to:

<?=route('upload', ['uuid' => $uuid])?>


## REVIEWING YOUR APPLICATION

Make a GET request to this endpoint to see progress

## CONFIRMING YOUR APPLICATION

Once all fields are complete and you are happy, make a POST request to:

<?=route('confirm', ['uuid' => $uuid])?>
