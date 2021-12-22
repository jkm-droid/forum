<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<h4>Hello {{ $details['username'] }} </h4>
<p>
    You account with Forum have been successfully created.
    You need to verify your email by clicking <a style="color: red;" href="{{ route('user.verify.email', $details['token']) }}">HERE</a>
</p>
<p>
    Kindest regards,<br>
    <span style="font-style: italic;">The Forum</span><br>
</p>

</body>
</html>
