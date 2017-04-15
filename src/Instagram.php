<?php

namespace aseba\Instagram;

class Instagram
{
    private $settings = [];
    private $last_url = '';
    private $debug = false;
    private $guzzle;
    private $access_token;
    private $sign = false;

    public function __construct($client_id, $client_secret, $callback_url = null)
    {
        $this->settings = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        );
        if (!is_null($callback_url)) {
            $this->settings['callback_url'] = $callback_url;
        }

        $this->guzzle = new \GuzzleHttp\Client(
            ['base_uri' => 'https://api.instagram.com/v1/']
        );
    }

    public function sign($new_value = true)
    {
        $this->sign = $new_value;
    }

    private function generateSignature($endpoint, $params)
    {
        $sig = $endpoint;
        ksort($params);
        foreach ($params as $key => $val) {
            $sig .= "|$key=$val";
        }

        return hash_hmac('sha256', $sig, $this->settings['client_secret'], false);
    }

    public function generic($endpoint = '', $extra_params = [], $type = 'GET')
    {
        $endpoint = ltrim($endpoint, '/');
        $params = [
            'access_token' => $this->access_token,
        ];
        $params = array_merge($params, $extra_params);
        if ($this->sign) {
            $params['sig'] = $this->generateSignature("/$endpoint", $params);
        }

        if ($type == 'GET') {
            $response = $this->guzzle->get($endpoint, [
              'query' => $params,
          ]);
        }

        if ($type == 'POST') {
            $response = $this->guzzle->request('POST', $endpoint, [
            'query' => $params,
            'form_params' => $extra_params,
          ]);
        }

        if ($type == 'DELETE') {
            $response = $this->guzzle->delete($endpoint, [
              'query' => $params,
          ]);
        }

        return json_decode($response->getBody());
    }

    public function getLogin($response_type = 'code', array $scopes = [])
    {
        $url = 'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=%s';
        $params = [
            $this->settings['client_id'],
            $this->settings['callback_url'],
            $response_type,
        ];

        if (!is_null($scopes)) {
            $url .= '&scope=%s';
            $params[] = implode('+', $scopes);
        }

        return vsprintf($url, $params);
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    public function debug($debug = true)
    {
        $this->debug = (bool) $debug;
    }

    public function comment($media_id, $text)
    {
        return $this->generic(
        sprintf('media/%s/comments', $media_id),
        ['text' => $text],
        'POST'
      );
    }

    public function delete_comment($media_id, $comment_id)
    {
        return $this->generic(
        sprintf('media/%s/comments/%s', $media_id, $comment_id),
        [],
        'DELETE'
      );
    }
}
