<?php

use Carbon\Carbon;

if (!function_exists('getMinutesPerDay')) {
    /**
     * Returns array of week days in their total minutes against a date range.
     *
     * @param string $start
     * @param string $end
     * @return array<string, int>
     */
    function getMinutesPerDay($start, $end)
    {
        $start = Carbon::create($start);

        $end = Carbon::create($end);

        $days = [];

        if ($start->isSameDay($end)) {
            $day = $start->dayName;

            $days[$day][] = $end->diffInMinutes($start);
        } else {
            while (!$start->isSameDay($end)) {
                $days[$start->dayName][] = $start->diffInMinutes($start->clone()->endOfDay());

                $start->addDay()->startOfDay();
            }
            $day = $start->dayName;

            $days[$day][] = $start->diffInMinutes($end);
        }

        $minutesPerDay = [];

        foreach ($days as $day => $array) {
            $minutesPerDay[$day] = array_sum($array);
        }

        return $minutesPerDay;
    }
}