<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 6/16/18
 * Time: 12:09 AM
 */

namespace App\Services;


use Carbon\Carbon;
use GuzzleHttp\Client;

class LiveScores
{
    /**
     * @var Client
     */
    private $client;
    private $baseUrl;
    private $key;
    private $secret;
    private $matchesEndpoint = 'scores/history.json/';
    private $listLeagues = 'leagues/list.json/';
    private $fixtures = 'fixtures/matches.json/';
    private $league = 793;


    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->key = env('LIVESCORE_API_KEY');
        $this->secret = env('LIVESCORE_API_SECRET');
        $this->baseUrl = env('LIVESCORE_API_ENDPOINT');
    }

    public function getPastMatches($league = 793)
    {
        try {
            $url = $this->buildUrl($this->matchesEndpoint,[
                'page' => 1,
                'league' => $league
            ]);
            $response = $this->client->request('GET', $url);
            $response = (string)$response->getBody();
            $response = json_decode($response, true);
            return $response['data'];
        }catch (\Exception $exception) {
            report($exception);
            return  $exception->getMessage();
        }
    }

    public function getLeagues()
    {
        $url = $this->buildUrl($this->listLeagues);
        $response = $this->client->request('GET', $url);
        dd((string)$response->getBody());
    }


    public function getFixtures($league = 793)
    {
        $url = $this->buildUrl($this->fixtures, [
            'league' => $league
        ]);
        $response = $this->client->request('GET', $url);
        dd((string)$response->getBody());
    }

    private function buildUrl(string $endpoint, array $data = [])
    {
        return $this->baseUrl . $endpoint .'?'. http_build_query(array_merge($this->getKeysParameters(), $data));
    }

    private function getKeysParameters()
    {
        return [
            'key' => $this->key,
            'secret' => $this->secret
        ];
    }
}
