<?php
namespace RummyKhan\Socialite\Two;

class InstagramProvider extends AbstractProvider implements ProviderInterface
{
    
    protected $scopeSeparator = ' ';
    

    protected $scopes = ['basic'];
    

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://api.instagram.com/oauth/authorize', $state
        );
    }
    

    protected function getTokenUrl()
    {
        return 'https://api.instagram.com/oauth/access_token';
    }
    

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://api.instagram.com/v1/users/self?access_token='.$token, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true)['data'];
    }
    

    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'], 'nickname' => $user['username'],
            'name' => $user['full_name'], 'email' => null,
            'avatar' => $user['profile_picture'],
        ]);
    }
    

    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'form_params' => $this->getTokenFields($code),
        ]);
        return $this->parseAccessToken($response->getBody()->getContents());
    }
    

    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}