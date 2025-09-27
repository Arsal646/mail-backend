<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Dashboard</title>
    <style>
        :root {
            color-scheme: light;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f6f8;
            color: #1f2933;
        }
        .page {
            min-height: 100vh;
            padding: 24px 18px 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }
        .date-filter {
            background: #fff;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .date-filter label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .date-filter__controls {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .date-filter input[type="date"] {
            flex: 1 1 160px;
            border: 1px solid #d0d7e2;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            color: #0f172a;
            background: #fff;
        }
        .date-filter button {
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.22);
            cursor: pointer;
        }
        .date-filter button:focus,
        .date-filter button:hover {
            background: #1d4fd8;
        }
        .date-filter__reset {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            padding: 8px 12px;
        }
        .filters {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
        .filters a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #d0d7e2;
            color: #1f2933;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease, border 0.2s ease;
        }
        .filters a.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.22);
        }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .metric-title {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .metric-value {
            margin: 0;
            font-size: 42px;
            font-weight: 700;
            color: #0f172a;
        }
        .metric-caption {
            margin: 0;
            font-size: 13px;
            color: #94a3b8;
        }
        .list {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .list header {
            padding: 18px;
            border-bottom: 1px solid #e2e8f0;
        }
        .list header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .list header p {
            margin: 6px 0 0;
            font-size: 13px;
            color: #64748b;
        }
        .list ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
        }
        .list li:last-child {
            border-bottom: none;
        }
        .list .email,
        .list .domain {
            font-size: 15px;
            font-weight: 500;
            color: #0f172a;
            word-break: break-word;
            max-width: 75%;
        }
        .list .count {
            font-size: 16px;
            font-weight: 600;
            color: #2563eb;
        }
        .empty {
            text-align: center;
            padding: 32px 18px;
            color: #94a3b8;
            font-size: 14px;
        }
        @media (min-width: 768px) {
            .page {
                max-width: 680px;
                margin: 0 auto;
                padding-top: 48px;
            }
            .header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
@php $tokenParam = request('token'); @endphp
<div class="page">
    <header class="header">
        <h1>Email Dashboard</h1>
        <p>Showing activity for {{ strtolower($rangeLabel) }}.</p>
    </header>

    <form class="date-filter" method="GET" action="{{ route('admin.dashboard') }}">
        <label for="date">Filter by date</label>
        <div class="date-filter__controls">
            <input type="date" id="date" name="date" value="{{ $selectedDate }}" max="{{ $maxDate }}">
            @if ($tokenParam)
                <input type="hidden" name="token" value="{{ $tokenParam }}">
            @endif
            <button type="submit">Apply</button>
            @if ($selectedDate)
                <a class="date-filter__reset" href="{{ route('admin.dashboard', ['range' => 'day', 'token' => $tokenParam]) }}">Reset</a>
            @endif
        </div>
    </form>

    <nav class="filters" aria-label="Time range filters">
        @foreach ($rangeOptions as $key => $label)
            <a href="{{ route('admin.dashboard', ['range' => $key, 'token' => $tokenParam]) }}" class="{{ $range === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>

    <section class="card" role="status">
        <p class="metric-title">Total received</p>
        <p class="metric-value">{{ number_format($totalCount) }}</p>
        <p class="metric-caption">Messages captured in the selected range.</p>
    </section>

    <section class="list">
        <header>
            <h2>Top sender domains</h2>
            <p>Where messages are coming from most often.</p>
        </header>
        @if ($hasTopDomains)
            <ul>
                @foreach ($topDomains as $domain)
                    <li>
                        <span class="domain">{{ $domain->domain }}</span>
                        <span class="count">x{{ $domain->total }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty">No sender domain activity in this range.</div>
        @endif
    </section>

    <section class="list">
        <header>
            <h2>Repeated recipients</h2>
            <p>Email addresses triggered more than once.</p>
        </header>
        @if ($hasRepeatAddresses)
            <ul>
                @foreach ($repeatAddresses as $item)
                    <li>
                        <span class="email">{{ $item->to_email }}</span>
                        <span class="count">x{{ $item->total }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty">No repeated email activity in this range.</div>
        @endif
    </section>
</div>
</body>
</html>
