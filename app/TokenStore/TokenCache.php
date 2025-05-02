namespace App\TokenStore;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class TokenCache
{
    public function storeTokens($accessToken, $user)
    {
        session([
            'accessToken'   => $accessToken->getToken(),
            'refreshToken'  => $accessToken->getRefreshToken(),
            'tokenExpires'  => $accessToken->getExpires(),
            'userName'      => $user->getDisplayName(),
            'userEmail'     => $user->getMail() ? $user->getMail() : $user->getUserPrincipalName(),
            'userTimezone'  => $user->getMailboxSettings()->getTimeZone()
        ]);

        // Ensure session is saved
        session()->save();
    }

    public function clearTokens()
    {
        session()->forget('accessToken');
        session()->forget('refreshToken');
        session()->forget('tokenExpires');
        session()->forget('userName');
        session()->forget('userEmail');
        session()->forget('userTimezone');
        session()->save(); // Ensure session is saved
    }

    public function getAccessToken()
    {
        if (
            empty(session('accessToken')) ||
            empty(session('refreshToken')) ||
            empty(session('tokenExpires'))
        ) {
            return "";
        }

        $now = time() + 300; // 5-minute buffer

        if (session('tokenExpires') <= $now) {
            // Token is expired, attempt refresh
            $oauthClient = new GenericProvider([
                'clientId'                => env('OAUTH_APP_ID'),
                'clientSecret'            => env('OAUTH_APP_PASSWORD'),
                'redirectUri'             => env('OAUTH_REDIRECT_URI'),
                'urlAuthorize'            => env('OAUTH_AUTHORITY') . env('OAUTH_AUTHORIZE_ENDPOINT'),
                'urlAccessToken'          => env('OAUTH_AUTHORITY') . env('OAUTH_TOKEN_ENDPOINT'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => env('OAUTH_SCOPES')
            ]);

            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => session('refreshToken')
                ]);

                $this->updateTokens($newToken);
                return $newToken->getToken();
            } catch (IdentityProviderException $e) {
                return "";
            }
        }

        return session('accessToken');
    }

    public function updateTokens($accessToken)
    {
        session([
            'accessToken'  => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires()
        ]);

        session()->save(); // Ensure session is saved
    }
}
