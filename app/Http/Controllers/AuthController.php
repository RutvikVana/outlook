<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Authentication\PhpLeague\AuthorizationCodeProvider;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;

class AuthController extends Controller
{
    public function redirectToMicrosoft()
    {
        $state = Str::random(40);
        session(['oauth_state' => $state]);

        $clientId = 'f2cff779-1415-48dc-9528-3aa74a9d5038';
        $redirectUri ='http://localhost:8000/callback';
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
            $clientId = 'f2cff779-1415-48dc-9528-3aa74a9d5038';
            $clientSecret = 'dVJ8Q~SJ7SK2M1t3i1kHtADcfuQzAmTLB4lACdeo';
            $redirectUri = 'http://localhost:8000/callback';
            $scopes = ['User.Read', 'Mail.Read', 'Calendars.Read'];

            $provider = new AuthorizationCodeProvider(
                $clientId,
                $clientSecret,
                $redirectUri,
                $scopes,
                'common'
            );

            $accessToken = $provider->getAccessTokenFromAuthorizationCode($code);

            $authProvider = new GraphPhpLeagueAuthenticationProvider($provider, $accessToken->getAccessToken());
            $graph = new GraphServiceClient($authProvider);

            $me = $graph->me()->get();

            session([
                'userName' => $me->getDisplayName(),
                'userEmail' => $me->getMail(),
                'accessToken' => $accessToken->getAccessToken()
            ]);

            return redirect('/')->with('success', 'Signed in successfully');

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function signout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Signed out successfully.');
    }
}
