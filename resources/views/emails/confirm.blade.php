<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign Up Confirmation</title>
    </head>
    <body>
        <h1>Thanks for signing up, {{ $name }}!</h1>

        <p>
            <h3>In order to complete your registration, please verify your email by clicking the link below</h3>

            <div>
                <a href='{{ url("register/confirm/$token") }}'>www.flamingoleaves.dev</a>
            </div>

        </p>
    </body>
</html>
