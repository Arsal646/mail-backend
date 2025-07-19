<!DOCTYPE html>
<html>
<head>
    <title>Inbox for {{ $email }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .message { border: 1px solid #ccc; margin-bottom: 20px; padding: 10px; }
        .subject { font-weight: bold; }
        .from, .date { font-size: 0.9em; color: #666; }
        .body { margin-top: 10px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Inbox for: {{ $email }}</h1>
    <a href="{{ url('/') }}">Generate new temporary email</a>
    <hr>

    @if ($messages->isEmpty())
        <p>No messages received yet.</p>
    @else
        @foreach ($messages as $msg)
            <div class="message">
                <div class="subject">Subject: {{ $msg['Content']['Headers']['Subject'][0] ?? '(No Subject)' }}</div>
                <div class="from">From: {{ $msg['From']['Mailbox'] ?? 'unknown' }}@{{ $msg['From']['Domain'] ?? '' }}</div>
                <div class="date">Date: {{ $msg['Content']['Headers']['Date'][0] ?? 'unknown' }}</div>
                <div class="body">
                    {!! nl2br(e($msg['Content']['Body'] ?? '')) !!}
                </div>
            </div>
        @endforeach
    @endif
</body>
</html>
