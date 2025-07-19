<!DOCTYPE html>
<html>
<head>
    <title>Inbox</title>
</head>
<body>
    <h1>Inbox</h1>
    @forelse ($emails as $email)
        <div style="margin-bottom: 20px; padding:10px; border: 1px solid #ccc;">
            <strong>Subject:</strong> {{ $email->subject }} <br>
            <strong>From:</strong> {{ $email->from }} <br>
            <strong>To:</strong> {{ $email->to }} <br>
            <strong>Body:</strong> <pre>{{ $email->body }}</pre>
            <small>Received at: {{ $email->created_at }}</small>
        </div>
    @empty
        <p>No emails yet.</p>
    @endforelse
</body>
</html>
