<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class Clover
{
    protected string $mId;
    protected Client $client;

    public function __construct() {
        $mode = strtoupper(env('CLOVER_MODE', 'LIVE')) == 'SANDBOX' ? 'SANDBOX' : 'LIVE';
        $this->mId = env("CLOVER_{$mode}_MID");

        $base_url = [
            'LIVE' => 'https://api.clover.com',
            'SANDBOX' => 'https://sandbox.dev.clover.com',
        ];
        $access_token = env("CLOVER_{$mode}_TOKEN");
        $this->client = new Client([
            'base_uri' => $base_url[$mode],
            'headers' => [
                'authorization' => "Bearer {$access_token}",
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function createCustomer(array $data) {
        $body = [
            'firstName' => substr($data['name'], 0, 64),
            'emailAddresses' => [[
                'emailAddress' => $data['email'],
                'primaryEmail' => true,
            ]],
            'phoneNumbers' => [[
                'phoneNumber' => $data['phone'],
            ]],
        ];
        $response = $this->client->request('POST', "/v3/merchants/{$this->mId}/customers", [
            'body' => json_encode($body),
        ]);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }
        return null;
    }

    public function updateCustomer(string $customerId, array $data) {
        $body = [
            'firstName' => substr($data['name'], 0, 64),
            'emailAddresses' => [[
                'emailAddress' => $data['email'],
                'primaryEmail' => true,
            ]],
            'phoneNumbers' => [[
                'phoneNumber' => $data['phone'],
            ]],
        ];
        $response = $this->client->request('POST', "/v3/merchants/{$this->mId}/customers/{$customerId}", [
            'body' => json_encode($body),
        ]);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }
        return null;
    }
}
