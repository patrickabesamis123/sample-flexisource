<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hello!
    <br>
    You are receiving this email because we received a password reset request for your account.
    <br>
    Please click on the link below or copy it into the address bar of your browser to reset your password:
    <br>

    <a href="{{ url('reset-password?token='.$token)}}">Reset my password </a>

    <br/>
</div>

</body>
</html>