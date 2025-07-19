@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Temporary Inbox</h1>

    {{-- filter by recipient --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="email" name="to" value="{{ request('to') }}" class="form-control"
                   placeholder="Filter by recipient (optional)">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Received</th>
                <th>To</th>
                <th>From</th>
                <th>Subject / Snippet</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($emails as $mail)
            <tr>
                <td>{{ $mail->received_at->format('Y-m-d H:i') }}</td>
                <td>{{ $mail->recipient }}</td>
                <td>{{ $mail->sender }}</td>
                <td>
                    <a href="{{ route('inbox.show', $mail) }}">{{ $mail->subject ?: '(no subject)' }}</a>
                    <div class="text-muted small">{{ Str::limit($mail->body_plain, 80) }}</div>
                </td>
                <td class="text-end">
                    <form method="POST" action="{{ route('inbox.destroy', $mail) }}"
                          onsubmit="return confirm('Delete this email?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No emails found.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $emails->links() }}
</div>
@endsection
