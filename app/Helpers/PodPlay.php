<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PodPlay
{
    protected string|null $token = null;
    protected Client|null $client = null;

    public function __construct() {
        try {
            $username = env('PODPLAY_USER');
            $password = env('PODPLAY_PASS');
            $client = new Client([
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);
            $response = $client->post('https://ppbrva.podplay.app/apis/v2/oauth2/token', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'grant_type' => 'password',
                ],
            ]);
            $result = json_decode($response->getBody(), true);
            $this->token = $result['access_token'];
            $this->client = new Client([
                'base_uri' => 'https://ppbrva.podplay.app',
                'headers' => [
                    'authorization' => "Bearer {$this->token}",
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ]
            ]);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
            logger("!!!PodPlay Error!!! getToken");
            logger($result);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
            logger("!!!PodPlay Error!!! getToken");
            logger($result);
        }
    }

    public function getToken() {
        return $this->token;
    }

    public function createUser(array $data) {
        if (!$this->client) return null;
        try {
            $response = $this->client->post("/apis/v2/users", [
                'body' => json_encode([
                    'firstName' => $data['firstname'],
                    'lastName' => $data['lastname'],
                    'email' => $data['email'],
                ]),
            ]);
            $result = json_decode($response->getBody(), true);
            return $result['id'];
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
        }
        $data = json_encode($data);
        logger("!!!PodPlay Error!!! createUser({$data})");
        logger($result);
        return null;
    }

    public function createMembership($member) {
        if (!$this->client) return null;
        try {
            // Find member and map local plan ID to podplay plan ID
            if ($member['plan_id'] == 1) $podplay = 'elite-team';
            else if ($member['plan_id'] == 2) $podplay = 'performance-team';
            else if ($member['plan_id'] == 3) $podplay = 'corporate';
            else if ($member['plan_id'] == 4) $podplay = 'morning-team';
            else if ($member['plan_id'] == 5) $podplay = 'student-team';
            else if ($member['plan_id'] == 8) $podplay = 'family-elite';
            else if ($member['plan_id'] == 12) $podplay = 'family-elite-complementary';
            else if ($member['plan_id'] == 11) $podplay = 'elite-team';
            else $podplay = NULL;

            $response = $this->client->post("/apis/v2/users/{$member['podplay_id']}/memberships", [
                'body' => json_encode([
                    'membership' => [
                        'id' => $podplay,
                    ],
                    'chargeType' => 'FREE',
                    'price' => 0,
                    'initiationFee' => 0
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
        }
        logger("!!!PodPlay Error!!! createMembership({$member['podplay_id']})");
        logger($result);
        return null;
    }

    public function getRevenue(string $start, string $end) {
        if (!$this->client) return [];
        try {
            $response = $this->client->get("/apis/v2/tenants/current/analytics/revenue", [
                'query' => [
                    'startTime' => $start,
                    'endTime' => $end,
                ],
            ]);
            $result = json_decode($response->getBody(), true);
            return $result['items'];
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
        }
        logger("!!!PodPlay Error!!! getRevenue()");
        logger($result);
        return [];
    }

    public function getUsers() {
        if (!$this->client) return [];
        try {
            $response = $this->client->get("/apis/v2/users", [
                'query' => [
                    'ipp' => 1000,
                ],
            ]);
            $result = json_decode($response->getBody(), true);
            return $result['items'];
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
        }
        logger("!!!PodPlay Error!!! getUsers()");
        logger($result);
        return [];
    }
}
