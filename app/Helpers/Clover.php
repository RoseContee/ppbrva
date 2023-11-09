<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Clover
{
    protected string $mId;
    protected Client $platform_client;
    protected Client $tokenization_client;
    protected Client $ecommerce_client;
    protected string $errorMessage = 'Clover API error.';

    public function __construct() {
        $mode = strtoupper(env('CLOVER_MODE', 'LIVE')) === 'SANDBOX' ? 'SANDBOX' : 'LIVE';
        $this->mId = env("CLOVER_PLATFORM_{$mode}_MID");

        $platform_base_url = [
            'LIVE' => 'https://api.clover.com',
            'SANDBOX' => 'https://sandbox.dev.clover.com',
        ];
        $access_token = env("CLOVER_PLATFORM_{$mode}_TOKEN");
        $this->platform_client = new Client([
            'base_uri' => $platform_base_url[$mode],
            'headers' => [
                'authorization' => "Bearer {$access_token}",
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        $tokenization_base_url = [
            'LIVE' => 'https://token.clover.com',
            'SANDBOX' => 'https://token-sandbox.dev.clover.com',
        ];
        $apikey = env("CLOVER_TOKENIZATION_{$mode}_APIKEY");
        $this->tokenization_client = new Client([
            'base_uri' => $tokenization_base_url[$mode],
            'headers' => [
                'apikey' => $apikey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        $ecommerce_base_url = [
            'LIVE' => 'https://scl.clover.com',
            'SANDBOX' => 'https://scl-sandbox.dev.clover.com',
        ];
        $access_token = env("CLOVER_ECOMMERCE_{$mode}_TOKEN");
        $this->ecommerce_client = new Client([
            'base_uri' => $ecommerce_base_url[$mode],
            'headers' => [
                'authorization' => "Bearer {$access_token}",
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function getCustomer(string $customerId) {
        try {
            $mId = $this->mId;
            $response = $this->platform_client->get("/v3/merchants/{$mId}/customers/{$customerId}", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function createCustomer(array $data) {
        try {
            $mId = $this->mId;
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
            $response = $this->platform_client->post("/v3/merchants/{$mId}/customers", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function updateCustomer(string $customerId, array $data) {
        try {
            $mId = $this->mId;
            $body = [
                'firstName' => substr($data['name'], 0, 64),
                'emailAddresses' => [[
                    'id' => $data['email']['id'],
                    'emailAddress' => $data['email']['value'],
                ]],
                'phoneNumbers' => [[
                    'id' => $data['phone']['id'],
                    'phoneNumber' => $data['phone']['value'],
                ]],
            ];
            $response = $this->platform_client->post("/v3/merchants/{$mId}/customers/{$customerId}", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function cardType(string $cardnumber) {
        $cardTypes = [
            'VISA'        => [4],
            'MC'          => [51, 52, 53, 54, 55, 22, 23, 24, 25, 26, 27],
            'AMEX'        => [34, 37],
            'DISCOVER'    => [60, 64, 65, 622],
            'DINERS_CLUB' => [30, 36, 38, 39],
            'JCB'         => [35],
        ];
        foreach ($cardTypes as $type => $numbers) {
            foreach ($numbers as $number) {
                if (stripos($cardnumber, $number) === 0) {
                    return $type;
                }
            }
        }
        return 'UNKNOWN';
    }

    public function createCardToken(array $data) {
        try {
            $body = [
                'card' => [
                    'number' => $data['number'],
                    'exp_month' => $data['exp_month'],
                    'exp_year' => $data['exp_year'],
                    'cvv' => $data['cvv'],
                    'last4' => substr($data['number'], -4),
                    'first6' => substr($data['number'], -6),
                    'brand' => $data['brand'],
                    'name' => $data['name'],
                    'address_line1' => $data['address'],
                    'address_zip' => $data['zipcode'],
                ],
            ];
            $response = $this->tokenization_client->post("/v1/tokens", [
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function createCustomerCard(array $data) {
        try {
            $body = [
                'ecomind' => 'moto',
                'email' => $data['email'],
                'name' => $data['name'],
                'source' => $data['card'],
            ];
            $response = $this->ecommerce_client->post("/v1/customers", [
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function updateCustomerCard(string $customerId, array $data) {
        try {
            $body = [
                'ecomind' => 'moto',
                'email' => $data['email'],
                'source' => $data['card'],
            ];
            $response = $this->ecommerce_client->put("/v1/customers/{$customerId}", [
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function revokeCustomerCard(string $customerId, string $cardId) {
        try {
            $response = $this->ecommerce_client->delete("/v1/customers/{$customerId}/sources/{$cardId}");
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }

    public function getOrders() {
        try {
            $mId = $this->mId;
            $response = $this->platform_client->get("https://sandbox.dev.clover.com/v3/merchants/{$mId}/orders", [
                'query' => [
                    'expand' => 'lineItems,payment.tender'
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
        }
        return $result['error']['message'] ?? $this->errorMessage;
    }
}
