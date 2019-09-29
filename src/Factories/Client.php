<?php

namespace Benmag\Rancher\Factories;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;

/**
 * Rancher API wrapper for Laravel
 *
 * @package  Rancher
 * @author   @benmagg
 */
class Client implements \Benmag\Rancher\Contracts\Client {

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @param $baseUrl
     * @param $accessKey
     * @param $secretKey
     */
    public function __construct($baseUrl, $accessKey, $secretKey)
    {

        $stack = HandlerStack::create();

        $stack->push(new ErrorHandler);

        $this->client = new HttpClient([
            'handler' => $stack,
            'base_uri' => $baseUrl,
            'auth' => [$accessKey, $secretKey],
        ]);
    }

    /**
     * Prepare option data to be passed to the Guzzle request
     *
     * @param array $params
     * @param array $options
     * @return array
     */
    private function prepareData($params = [], $options = [])
    {
        if(Arr::get($options, 'content_type') == "json") {
            $data['json'] = $params; // pass data as array which gets json_encoded
        } else {
            $data['query'] = $this->prepareQueryString($params); // pass data as query string
        }

        return array_merge($data, $options);
    }

    /**
     * Prepare a query string from an array of params
     *
     * @param array $params
     * @return string
     */
    private function prepareQueryString(array $params = [])
    {
        return preg_replace('/%5B[0-9]+%5D/simU', '', http_build_query($params));
    }

    /**
     * @param $endPoint
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function get($endPoint, array $params = [])
    {
        $response = $this->client->get($endPoint, $this->prepareData($params));
        switch ($response->getHeader('content-type'))
        {
            case "application/json":
                return $response->json();
                break;
            default:
                return $response->getBody()->getContents();
        }
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function post($endPoint, array $params = [], array $options = [])
    {
        $response = $this->client->post($endPoint, $this->prepareData($params, $options));
        switch ($response->getHeader('content-type'))
        {
            case "application/json":
                return $response->json();
                break;
            default:
                return $response->getBody()->getContents();
        }
    }


    /**
     * @param $endPoint
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function put($endPoint, array $params = [], array $options = [])
    {
        $response = $this->client->put($endPoint, $this->prepareData($params, $options));
        switch ($response->getHeader('content-type'))
        {
            case "application/json":
                return $response->json();
                break;
            default:
                return $response->getBody()->getContents();
        }
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function delete($endPoint, array $params = [], array $options = [])
    {
        $response = $this->client->delete($endPoint, $this->prepareData($params, $options));
        switch ($response->getHeader('content-type'))
        {
            case "application/json":
                return $response->json();
                break;
            default:
                return $response->getBody()->getContents();
        }
    }

}

