<?php

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

        $timezone = Timezones::getTzFromWindows($viewData['userTimeZone']);

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

        // Uncomment and configure if you need to fetch events
        // $events = $graph->createRequest('GET', '/me/calendarView?' . http_build_query($queryParams))
        //     ->addHeaders(['Prefer' => 'outlook.timezone="' . $viewData['userTimeZone'] . '"'])
        //     ->setReturnType(Model\Event::class)
        //     ->execute();

        // $viewData['events'] = $events;

        // return view('calendar', $viewData);
    }

    private function getGraph(): Graph
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        return $graph;
    }

    private function loadViewData()
    {
        return [
            'userTimeZone' => 'Pacific Standard Time',
        ];
    }
}
