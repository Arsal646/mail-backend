<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Dashboard</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f5f6f7;
            --surface: #ffffff;
            --surface-alt: #f9fafb;
            --border: #d1d5db;
            --text-strong: #111827;
            --text-muted: #6b7280;
            --accent: #111827;
            --accent-light: rgba(17, 24, 39, 0.08);
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 4px 12px rgba(17, 24, 39, 0.08);
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text-strong);
        }
        .app {
            width: min(92%, 720px);
            margin: 0 auto;
            padding: 20px 0 64px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .hero {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .hero h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .hero p {
            margin: 0;
            font-size: 14px;
            color: var(--text-muted);
        }
        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .filter-card__legend {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        .filter-card__controls {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .filter-card input[type="date"] {
            grid-column: span 2;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 15px;
            color: var(--text-strong);
            background: var(--surface-alt);
        }
        .filter-card input[type="date"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }
        .filter-card button {
            border: none;
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 15px;
            font-weight: 600;
            background: var(--accent);
            color: #ffffff;
        }
        .filter-card__reset {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--accent);
            text-decoration: none;
        }
        .filters {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        .filters::-webkit-scrollbar {
            display: none;
        }
        .filters a {
            flex: 0 0 auto;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--surface);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
        }
        .filters a.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        .metric-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }
        .metric-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .metric-card__title {
            margin: 0;
            font-size: 12px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        .metric-card__value {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }
        .metric-card__caption {
            margin: 0;
            font-size: 13px;
            color: var(--text-muted);
        }
        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .panel header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        .panel header p {
            margin: 2px 0 0;
            font-size: 13px;
            color: var(--text-muted);
        }
        .panel ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .panel li {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .panel li:last-child {
            border-bottom: none;
        }
        .panel .label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-strong);
            word-break: break-word;
            max-width: 70%;
        }
        .panel .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-strong);
        }
        .panel .empty {
            padding: 12px 0;
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
        }
        .panel-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }
        @media (min-width: 520px) {
            .filter-card__controls {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .filter-card input[type="date"] {
                grid-column: span 2;
            }
            .filter-card button {
                grid-column: auto;
            }
        }
        @media (min-width: 640px) {
            .panel-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body>
@php $tokenParam = request('token'); @endphp
<div class="app">
    <header class="hero">
        <h1>Email Dashboard</h1>
        <p>Showing activity for {{ strtolower($rangeLabel) }}.</p>
    </header>

    <form class="filter-card" method="GET" action="{{ route('admin.dashboard.open') }}">
        <div class="filter-card__legend">
            <span>Filter by date</span>
            @if ($selectedDate)
                <a class="filter-card__reset" href="{{ route('admin.dashboard.open', ['range' => 'day', 'token' => $tokenParam]) }}">Reset</a>
            @endif
        </div>
        <div class="filter-card__controls">
            <input type="date" id="date" name="date" value="{{ $selectedDate }}" max="{{ $maxDate }}">
            @if ($tokenParam)
                <input type="hidden" name="token" value="{{ $tokenParam }}">
            @endif
            <button type="submit">Apply</button>
        </div>
    </form>

    <nav class="filters" aria-label="Time range filters">
        @foreach ($rangeOptions as $key => $label)
            <a href="{{ route('admin.dashboard.open', ['range' => $key, 'token' => $tokenParam]) }}" class="{{ $range === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="metric-strip">
        <section class="metric-card">
            <p class="metric-card__title">Total received</p>
            <p class="metric-card__value">{{ number_format($totalCount) }}</p>
            <p class="metric-card__caption">Messages captured in the selected range.</p>
        </section>
        @if ($busiestDay)
            <section class="metric-card">
                <p class="metric-card__title">Busiest date</p>
                <p class="metric-card__value">{{ number_format($busiestDay['total']) }}</p>
                <p class="metric-card__caption">Arrived on {{ $busiestDay['label'] }}.</p>
            </section>
        @endif
    </div>

    @if ($showDatewiseCounts)
        <section class="panel">
            <header>
                <h2>Daily email volume</h2>
                <p>Messages received for each day in this range.</p>
            </header>
            <ul>
                @foreach ($datewiseCounts as $item)
                    <li>
                        <span class="label">{{ $item['label'] }}</span>
                        <span class="value">x{{ number_format($item['total']) }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <div class="panel-grid">
        <section class="panel">
            <header>
                <h2>Top sender domains</h2>
                <p>Where messages are coming from most often.</p>
            </header>
            @if ($hasTopDomains)
                <ul>
                    @foreach ($topDomains as $domain)
                        <li>
                            <span class="label">{{ $domain->domain }}</span>
                            <span class="value">x{{ number_format($domain->total) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty">No sender domain activity in this range.</div>
            @endif
        </section>

        <section class="panel">
            <header>
                <h2>Repeated recipients</h2>
                <p>Email addresses triggered more than once.</p>
            </header>
            @if ($hasRepeatAddresses)
                <ul>
                    @foreach ($repeatAddresses as $item)
                        <li>
                            <span class="label">{{ $item->to_email }}</span>
                            <span class="value">x{{ number_format($item->total) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty">No repeated email activity in this range.</div>
            @endif
        </section>
    </div>
</div>
</body>
</html>
