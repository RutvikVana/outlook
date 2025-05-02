<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class HomeController extends Controller
{
    public function welcome()
    {
        $userName = session('userName');
        $userEmail = session('userEmail');

        return view('welcome', [
            'userName' => $userName,
            'userEmail' => $userEmail
        ]);
    }

    public function getEmails()
    {
        $accessToken = session('accessToken');
        if (!$accessToken) {
            return redirect('/')->with('error', 'User not authenticated.');
        }

        try {
            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            $emails = $graph->createRequest('GET', '/me/messages')
                ->setReturnType(Model\Message::class)
                ->execute();

            return view('emails', ['emails' => $emails]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error fetching emails: ' . $e->getMessage());
        }
    }

    public function getCalendarEvents()
    {
        $accessToken = session('accessToken');
        if (!$accessToken) {
            return redirect('/')->with('error', 'User not authenticated.');
        }

        try {
            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            $events = $graph->createRequest('GET', '/me/calendar/events')
                ->setReturnType(Model\Event::class)
                ->execute();

            return view('calendar', ['events' => $events]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error fetching calendar events: ' . $e->getMessage());
        }
    }
}
