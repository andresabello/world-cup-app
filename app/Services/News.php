<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 6/13/18
 * Time: 9:59 PM
 */

namespace App\Services;


use Carbon\Carbon;
use GuzzleHttp\Client;

class News
{

    protected $apiUrl;
    protected $client;
    protected $apiKey;
    protected $language = 'es';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('GOOGLE_NEWS_URL', 'https://newsapi.org/v2/');
        $this->apiKey = env('GOOGLE_NEWS_API');
    }

    public function fetchEverything(string $query)
    {
        $queryString = $this->getUrlParameters($query);
        try {
            $response = $this->client->request('GET', $this->apiUrl . 'everything', [
                'query' => $queryString
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (\Exception $exception) {
            report($exception);
            return $exception->getMessage();
        }
    }

    public function fetchTopHeadlines(string $query)
    {
        $queryString = $this->getUrlParameters($query);
        try {

            $response = $this->client->request('GET', $this->apiUrl . 'top-headlines', [
                'query' => $queryString
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (\Exception $exception) {
            report($exception);
            return $exception->getMessage();
        }
    }

    public function fetchFutbolred():array
    {
        $response = $this->client->request('GET', env('FUTBOLRED_RSS'));
        $xml = (string)$response->getBody();
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        return json_decode($json, true);
    }


    private function getUrlParameters(string $query): string
    {
        $monthAgo = Carbon::now()->subDays(15)->toDateString();
        return http_build_query([
            'q' => urlencode($query),
            'language' => $this->language,
            'from' => $monthAgo,
            'sortBy' => 'latest',
            'apiKey' => $this->apiKey
        ]);
    }

}
