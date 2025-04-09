<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class APIController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Bypass SSL verification (since it's HTTP)
        ]);

        $this->baseUrl = env('OFMIS_API_URL'); // Store API URL in .env
    }

    public function getAccounts()
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/accounts", [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
