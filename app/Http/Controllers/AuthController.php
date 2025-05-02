<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class AuthController extends Controller
{
    public function redirectToMicrosoft()
    {
        $state = Str::random(40);
        session(['oauth_state' => $state]);

        $clientId = 'f2cff779-1415-48dc-9528-3aa74a9d5038';
        $redirectUri = urlencode(route('microsoft.callback'));
        $scope = 'User.Read Mail.Read Calendars.Read';

        $authUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize?" . 
            http_build_query([
                'client_id' => $clientId,
                'response_type' => 'code',
                'redirect_uri' => route('microsoft.callback'),
                'response_mode' => 'query',
                'scope' => $scope,
                'state' => $state,
            ]);

        return redirect($authUrl);
    }

    public function handleMicrosoftCallback(Request $request)
    {
        if ($request->state !== session('oauth_state')) {
            return redirect('/')->with('error', 'State mismatch. Security risk detected.');
        }

        $code = $request->code;

        try {
            $accessToken = $this->getAccessTokenFromCode($code);

            if (!$accessToken) {
                return redirect('/')->with('error', 'Access token could not be retrieved.');
            }

            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            $user = $graph->createRequest('GET', '/me?$select=displayName,mail')
                ->setReturnType(Model\User::class)
                ->execute();

            session([
                'userName' => $user->getDisplayName(),
                'userEmail' => $user->getMail(),
                'accessToken' => $accessToken
            ]);

            return redirect('/')->with('success', 'Signed in successfully');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    protected function getAccessTokenFromCode($code)
    {
        $clientId = 'f2cff779-1415-48dc-9528-3aa74a9d5038';
        $clientSecret = 'dVJ8Q~SJ7SK2M1t3i1kHtADcfuQzAmTLB4lACdeo';
        $redirectUri = route('microsoft.callback');
    
        $response = Http::asForm()->post("https://login.microsoftonline.com/common/oauth2/v2.0/token", [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code'
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'] ?? null;
        } else {
            logger()->error('Failed to retrieve access token', ['status' => $response->status(), 'body' => $response->body()]);
            return null;
        }
    }

    public function signout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Signed out successfully.');
    }
}
