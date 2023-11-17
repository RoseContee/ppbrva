<?php

namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Dupr
{
    protected Client $client;
    protected string $version = 'v1.0';
    protected string $token;

    public function __construct() {
        $this->token = env('DUPR_TOKEN');

        $this->client = new Client([
            'base_uri' => 'https://api.dupr.gg',
            'headers' => [
                'authorization' => $this->token,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        ]);
    }

    protected function getErrorMessage(array | string $result) {
        return $result['message'] ?? 'DUPR API error.';
    }

    public function getPlayInfo($playerId) {
        try {
            $ver = $this->version;
            $response = $this->client->get("/player/{$ver}/{$playerId}");
            $result = json_decode($response->getBody(), true);
            $ratings = $result['result']['ratings'] ?? null;
            $rating = $ratings[strtolower($ratings['defaultRating'])] ?? null;
            if ($rating) $rating = round($rating, 1);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return [
            'gender' => $result['result']['gender'] ?? null,
            'age' => $result['result']['age'] ?? null,
            'rating' => $rating ?? null,
            'matches' => null,
            'wins' => null,
            'losses' => null,
        ];
    }
}
