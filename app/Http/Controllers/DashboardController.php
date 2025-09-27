<?php

namespace App\Http\Controllers;

use App\Models\FakeEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->query('range', 'day');
        $dateInput = $request->query('date');
        $selectedDate = null;
        $start = null;
        $end = null;
        $label = '';
        $now = Carbon::now();
        $maxDate = $now->toDateString();

        if ($dateInput) {
            try {
                $selectedDate = Carbon::createFromFormat('Y-m-d', $dateInput);
            } catch (\Exception $exception) {
                $selectedDate = null;
            }
        }

        if ($selectedDate) {
            $start = $selectedDate->copy()->startOfDay();
            $end = $selectedDate->copy()->endOfDay();
            $label = $selectedDate->format('M j, Y');
            $range = 'custom';
        } else {
            switch ($range) {
                case 'week':
                    $start = $now->copy()->startOfWeek();
                    $label = 'This Week';
                    break;
                case 'month':
                    $start = $now->copy()->startOfMonth();
                    $label = $now->format('F Y');
                    break;
                case 'day':
                default:
                    $range = 'day';
                    $start = $now->copy()->startOfDay();
                    $label = 'Today';
                    break;
            }
            $end = $now->copy()->endOfDay();
        }

        $filteredQuery = FakeEmail::query()->when($start, function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        });

        $totalCount = (clone $filteredQuery)->count();

        $repeatAddresses = (clone $filteredQuery)
            ->selectRaw('to_email, COUNT(*) as total')
            ->whereNotNull('to_email')
            ->groupBy('to_email')
            ->having('total', '>', 1)
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topDomains = (clone $filteredQuery)
            ->selectRaw("LOWER(SUBSTR(from_email, INSTR(from_email, '@') + 1)) as domain, COUNT(*) as total")
            ->whereNotNull('from_email')
            ->whereRaw("INSTR(from_email, '@') > 0")
            ->groupBy('domain')
            ->having('domain', '!=', '')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $rangeOptions = [
            'day' => 'Day',
            'week' => 'Week',
            'month' => 'Month',
        ];

        return view('dashboard', [
            'totalCount' => $totalCount,
            'range' => $range,
            'rangeLabel' => $label,
            'rangeOptions' => $rangeOptions,
            'repeatAddresses' => $repeatAddresses,
            'hasRepeatAddresses' => $repeatAddresses->isNotEmpty(),
            'topDomains' => $topDomains,
            'hasTopDomains' => $topDomains->isNotEmpty(),
            'selectedDate' => $selectedDate ? $selectedDate->toDateString() : '',
            'maxDate' => $maxDate,
        ]);
    }
}
