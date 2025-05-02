<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\Timezones;

class CalendarController extends Controller
{
    public function calendar()
    {
        dd(session()->all());

        $viewData = $this->loadViewData();

        $graph = $this->getGraph();

        // Get user's timezone
        $timezone = Timezones::getTzFromWindows($viewData['userTimeZone']);

        // Get start and end of the current week (Sunday to Sunday)
        $startOfWeek = new \DateTimeImmutable('sunday -1 week', $timezone);
        $endOfWeek = new \DateTimeImmutable('sunday', $timezone);

        $viewData['dateRange'] = $startOfWeek->format('M j, Y') . ' - ' . $endOfWeek->format('M j, Y');

        $queryParams = [
            'startDateTime' => $startOfWeek->format(\DateTimeInterface::ISO8601),
            'endDateTime' => $endOfWeek->format(\DateTimeInterface::ISO8601),
            '$select' => 'subject,organizer,start,end',
            '$orderby' => 'start/dateTime',
            '$top' => 25
        ];

    //     $getEventsUrl = '/me/calendarView?' . http_build_query($queryParams);

    //     $events = $graph->createRequest('GET', $getEventsUrl)
    //         ->addHeaders([
    //             'Prefer' => 'outlook.timezone="' . $viewData['userTimeZone'] . '"'
    //         ])
    //         ->setReturnType(Model\Event::class)
    //         ->execute();

    //     $viewData['events'] = $events;

    //     return view('calendar', $viewData);
    // }

    // private function getGraph(): Graph
    // {
    //     $tokenCache = new TokenCache();
    //     $accessToken = $tokenCache->getAccessToken();

    //     $graph = new Graph();
    //     $graph->setAccessToken($accessToken);

    //     return $graph;
    // }

    // private function loadViewData()
    // {
    //     // Stub for now – populate with real user info in production
    //     return [
    //         'userTimeZone' => 'Pacific Standard Time', // or dynamically from user profile
    //     ];
    // }
}
}