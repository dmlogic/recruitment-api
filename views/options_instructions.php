FILLING IN YOUR APPLICATION

Now your application is started, you can PATCH a request to this endpoint
with the data described below. All fields are required before your application
can be confirmed.

Field: name
Description: Your full name
Format: Text

Field: cover_letter
Description: Introduce yourself and explain why you are interested in this role
Format: Text

Field: cv
Description: An up-to-date CV/Resume
Format: We accept a URL as text. If would prefer to upload a file, see "UPLOADING YOUR CV" below

Field: code_examples
Description: Links to examples of relevant code, this would typically be a GitHub profile.
             If you do not have code to share, please use this field to persuade us we
             should still consider you.
             We understand that not all work can be in the public domain but this is a
             senior position and we need to know you can code.
Format: Text

UPLOADING YOUR CV

@todo
Accept only PDF

REVIEWING YOUR APPLICATION

Make a GET request to this endpoint to see progress

CONFIRMINT YOUR APPLICATION

Once all fields are complete and you are happy, make a POST request to

<?=$submit_url?>
