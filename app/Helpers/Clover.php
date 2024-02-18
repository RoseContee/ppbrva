<?php

namespace App\Helpers;

use App\Models\Setting;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Clover
{
    protected string $mId;
    protected Client $platform_client;
    protected Client $tokenization_client;
    protected Client $ecommerce_client;
    protected string $ecomind = 'moto';

    public function __construct() {
        $mode = strtoupper(env('CLOVER_MODE', 'LIVE')) === 'SANDBOX' ? 'SANDBOX' : 'LIVE';
        $this->mId = env("CLOVER_{$mode}_MID");

        $platform_base_url = [
            'LIVE' => 'https://api.clover.com',
            'SANDBOX' => 'https://sandbox.dev.clover.com',
        ];
        $access_token = env("CLOVER_{$mode}_PRIVATE_TOKEN");
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
        $apikey = env("CLOVER_{$mode}_PUBLIC_TOKEN");
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
        $access_token = env("CLOVER_{$mode}_PRIVATE_TOKEN");
        $this->ecommerce_client = new Client([
            'base_uri' => $ecommerce_base_url[$mode],
            'headers' => [
                'authorization' => "Bearer {$access_token}",
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);
    }

    protected function getErrorMessage(array | string $result) {
        if (!empty($result['error']['message'])) return $result['error']['message'];
        if (!empty($result['message'])) return $result['message'];
        if (gettype($result) === 'string') return $result;
        return 'Clover API error.';
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
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        logger("!!!Clover Error!!! getCustomer({$customerId})");
        logger($result);
        return $this->getErrorMessage($result);
    }

    public function createCustomer(array $data) {
        try {
            $mId = $this->mId;
            $body = [
                'firstName' => substr($data['firstname'], 0, 64),
                'lastName' => substr($data['lastname'], 0, 64),
                'emailAddresses' => [[
                    'emailAddress' => $data['email'],
                    'primaryEmail' => true,
                ]],
            ];
            if (!empty($data['phone'])) {
                $body['phoneNumbers'] = [[
                    'phoneNumber' => $data['phone'],
                ]];
            }
            $response = $this->platform_client->post("/v3/merchants/{$mId}/customers", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function updateCustomer(string $customerId, array $data) {
        try {
            $mId = $this->mId;
            $body = [
                'firstName' => substr($data['firstname'], 0, 64),
                'lastName' => substr($data['lastname'], 0, 64),
                'emailAddresses' => [[
                    'id' => $data['email']['id'],
                    'emailAddress' => $data['email']['value'],
                ]],
            ];
            $phoneId = $data['phone']['id'];
            $phone = $data['phone']['value'];
            if ($phone) {
                $body['phoneNumbers'] = [[
                    'id' => $phoneId,
                    'phoneNumber' => $phone,
                ]];
            }
            $response = $this->platform_client->post("/v3/merchants/{$mId}/customers/{$customerId}", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
                'body' => json_encode($body),
            ]);
            if ($phoneId && !$phone) {
                try {
                    $this->platform_client->delete("/v3/merchants/{$mId}/customers/{$customerId}/phone_numbers/{$phoneId}");
                } catch (Exception $exception) {}
            }
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function updateCustomerLastname(string $customerId, string $lastname) {
        try {
            $mId = $this->mId;
            $response = $this->platform_client->post("/v3/merchants/{$mId}/customers/{$customerId}", [
                'query' => [
                    'expand' => 'emailAddresses,phoneNumbers,cards',
                ],
                'body' => json_encode([
                    'lastName' => substr($lastname, 0, 64),
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function cardType(string $cardnumber): string {
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
            $response = $this->tokenization_client->post("/v1/tokens", [
                'body' => json_encode([
                    'card' => [
                        'number' => $data['number'],
                        'exp_month' => $data['exp_month'],
                        'exp_year' => $data['exp_year'],
                        'cvv' => $data['cvv'],
                        'last4' => substr($data['number'], -4),
                        'first6' => substr($data['number'], -6),
                        'brand' => $data['brand'],
                        'address_line1' => $data['address'],
                        'address_zip' => $data['zipcode'],
                    ],
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        logger("!!!Clover Error!!! createCardToken");
        logger($result);
        return $this->getErrorMessage($result);
    }

    public function createCustomerCard(array $data) {
        try {
            $response = $this->ecommerce_client->post("/v1/customers", [
                'body' => json_encode([
                    'ecomind' => $this->ecomind,
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'source' => $data['card'],
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        $data = json_encode($data);
        logger("!!!Clover Error!!! createCustomerCard({$data})");
        logger($result);
        return $this->getErrorMessage($result);
    }

    public function updateCustomerCard(string $customerId, array $data) {
        try {
            $response = $this->ecommerce_client->put("/v1/customers/{$customerId}", [
                'body' => json_encode([
                    'ecomind' => $this->ecomind,
                    'email' => $data['email'],
                    'source' => $data['card'],
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        $data = json_encode($data);
        logger("!!!Clover Error!!! updateCustomerCard({$customerId}, {$data})");
        logger($result);
        return $this->getErrorMessage($result);
    }

    public function revokeCustomerCard(string $customerId, string $cardId) {
        try {
            $response = $this->ecommerce_client->delete("/v1/customers/{$customerId}/sources/{$cardId}");
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function getTenders() {
        $mId = $this->mId;
        $offset = 0; $limit = 1000;
        $tenders = [];
        do {
            try {
                $response = $this->platform_client->get("/v3/merchants/{$mId}/tenders", [
                    'query' => [
                        'offset' => $offset,
                        'limit' => $limit,
                    ],
                ]);
                $result = json_decode($response->getBody(), true);
                $items = $result['elements'] ?? [];
                foreach ($items as $item) {
                    $tenders[] = [
                        'id' => $item['id'],
                        'labelKey' => $item['labelKey'] ?? '',
                        'label' => $item['label'] ?? '',
                    ];
                }
            } catch (Exception $exception) {
                $items = [];
            }
            $offset += $limit;
        } while (count($items) >= $limit);
        return $tenders;
    }

    public function getOrders() {
        $mId = $this->mId;
        $offset = 0; $limit = 1000;
        $createdTime = $newCreatedTime = Setting::getSetting(Setting::KEY_LastPulledOrderTime, 0) ?: 0;
        $orders = [];
        do {
            $items = [];
            for ($i = 0; $i < 60; $i++) {
                try {
                    $response = $this->platform_client->get("/v3/merchants/{$mId}/orders", [
                        'query' => [
                            'expand' => 'lineItems,payment.tender',
                            'filter' => "createdTime>{$createdTime}",
                            'offset' => $offset,
                            'limit' => $limit,
                        ],
                    ]);
                    $result = json_decode($response->getBody(), true);
                    $items = $result['elements'] ?? [];
                } catch (RequestException $exception) {
                    if ($exception->getResponse()->getStatusCode() == 429) {
                        sleep($i + 1);
                        continue;
                    }
                    $result = json_decode($exception->getResponse()->getBody(), true);
                    logger("!!!Clover Error!!! getOrders()");
                    logger($result);
                } catch (Exception $exception) {
                    $result = $exception->getMessage();
                    logger("!!!Clover Error!!! getOrders()");
                    logger($result);
                }
                break;
            }
            foreach ($items as $item) {
                $time = $item['createdTime'] ?? 0;
                if ($newCreatedTime < $time) $newCreatedTime = $time;
            }
            $orders = array_merge($orders, $items);
            $offset += $limit;
        } while (count($items) >= $limit);
        if ($newCreatedTime > $createdTime) {
            Setting::saveSetting(Setting::KEY_LastPulledOrderTime, $newCreatedTime);
        }
        return $orders;
    }

    public function updateOrderTotal(string $orderId, int $total = 0) {
        try {
            $mId = $this->mId;
            $response = $this->platform_client->post("/v3/merchants/{$mId}/orders/{$orderId}", [
                'body' => json_encode([
                    'total' => $total,
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function getCharge(string $chargeId) {
        try {
            $response = $this->ecommerce_client->get("/v1/charges/{$chargeId}");
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        return $this->getErrorMessage($result);
    }

    public function createCharge(array $data) {
        try {
            $response = $this->ecommerce_client->post("/v1/charges", [
                'body' => json_encode([
                    'ecomind' => $this->ecomind,
                    'amount' => $data['amount'] * 100,
                    'currency' => 'USD',
                    'source' => $data['source'],
                    'capture' => true,
                    'description' => $data['description'],
                ]),
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (Exception $exception) {
            $result = $exception->getMessage();
        }
        $data = json_encode($data);
        logger("!!!Clover Error!!! createCharge($data)");
        logger($result);
        return $this->getErrorMessage($result);
    }

    public function getInventoryItems() {
        $mId = $this->mId;
        $offset = 0; $limit = 1000;
        $inventoryItems = [];
        do {
            try {
                $response = $this->platform_client->get("/v3/merchants/{$mId}/items", [
                    'query' => [
                        'expand' => 'categories,tags',
                        'offset' => $offset,
                        'limit' => $limit,
                    ],
                ]);
                $result = json_decode($response->getBody(), true);
                $items = $result['elements'] ?? [];
                foreach ($items as $item) {
                    $inventoryItems[$item['id']] = [
                        'itemID' => $item['id'],
                        'item' => $item['name'],
                        'price' => $item['price'],
                        'category' => $item['categories']['elements'][0]['name'] ?? '',
                        'sortOrder' => $item['categories']['elements'][0]['sortOrder'] ?? 0,
                    ];
                }
            } catch (Exception $exception) {
                $items = [];
            }
            $offset += $limit;
        } while (count($items) >= $limit);
        return $inventoryItems;
    }

    public function getPayments() {
        $mId = $this->mId;
        $offset = 0; $limit = 1000;
        $createdTime = $newCreatedTime = Setting::getSetting(Setting::KEY_LastPulledPaymentTime, 0) ?: 0;
        $payments = [];
        do {
            $items = [];
            for ($i = 0; $i < 60; $i++) {
                try {
                    $response = $this->platform_client->get("/v3/merchants/{$mId}/payments", [
                        'query' => [
                            'filter' => "createdTime>{$createdTime}",
                            'offset' => $offset,
                            'limit' => $limit,
                        ],
                    ]);
                    $result = json_decode($response->getBody(), true);
                    $items = $result['elements'] ?? [];
                } catch (RequestException $exception) {
                    if ($exception->getResponse()->getStatusCode() == 429) {
                        sleep($i + 1);
                        continue;
                    }
                    $result = json_decode($exception->getResponse()->getBody(), true);
                    logger("!!!Clover Error!!! getPayments()");
                    logger($result);
                } catch (Exception $exception) {
                    $result = $exception->getMessage();
                    logger("!!!Clover Error!!! getPayments()");
                    logger($result);
                }
                break;
            }
            foreach ($items as $item) {
                $time = $item['createdTime'] ?? 0;
                if ($newCreatedTime < $time) $newCreatedTime = $time;
                if (in_array($item['note'] ?? '', ['Tourney Fee', 'League Fee', 'Event Payment'])) {
                    $payments[] = $item;
                }
            }
            $offset += $limit;
        } while (count($items) >= $limit);
        if ($newCreatedTime > $createdTime) {
            //Setting::saveSetting(Setting::KEY_LastPulledPaymentTime, $newCreatedTime);
        }
        return $payments;
    }
}
