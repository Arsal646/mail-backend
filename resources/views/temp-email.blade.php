<!DOCTYPE html>
<html>
<head>
    <title>Temporary Email</title>
</head>
<body>
    <h1>Your temporary email:</h1>
    <p><strong>{{ $email }}</strong></p>
    <p>Send emails to this address and check your inbox here:</p>
    <a href="{{ url('/inbox/' . $email) }}">View Inbox</a>
</body>
</html>
