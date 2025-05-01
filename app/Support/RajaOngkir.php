<?php

namespace App\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RajaOngkir
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://api.rajaongkir.com/starter/';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10.0,
            'headers'  => [
                'key' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Get list of provinces
     */
    public function getProvinces()
    {
        return $this->request('GET', 'province');
    }

    /**
     * Get list of cities by province ID (optional)
     */
    public function getCities($provinceId = null)
    {
        $endpoint = 'city';
        if ($provinceId) {
            $endpoint .= "?province=$provinceId";
        }

        return $this->request('GET', $endpoint);
    }
    public function getProvinceFromCity($cityId = null)
    {
        $endpoint = 'city';
        if ($cityId) {
            $endpoint .= "?city=$cityId";
        }

        return $this->request('GET', $endpoint);
    }

    /**
     * Check shipping cost
     */
    public function getCost($origin, $destination, $weight, $courier)
    {
        $data = [
            'origin'      => $origin,
            'destination' => $destination,
            'weight'      => $weight,
            'courier'     => $courier,
        ];

        return $this->request('POST', 'cost', $data);
    }

    /**
     * Handle HTTP request
     */
    private function request($method, $endpoint, $data = [])
    {
        try {
            $options = [];

            if ($method === 'POST') {
                $options['form_params'] = $data;
            }

            $response = $this->client->request($method, $endpoint, $options);
            $body = json_decode($response->getBody(), true);

            return $body['rajaongkir']['results'] ?? $body;
        } catch (RequestException $e) {
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
