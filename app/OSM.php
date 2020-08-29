<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OSM extends Model
{
    private $method = 'get';
    private $format = 'json';
    private $lang = 'ru';

    protected $table = 'place_osm';

    public function place()
    {
        return $this->hasMany('App\Place');
    }

    private function execute($uri, $params = [])
    {
        $response = null;
        $client = new Client([
            'base_uri' => config('openstreetmap.base_url'),
            'cookies' => true,
        ]);

        try {
            if ($this->method === 'post') {
                $response = $client->post($uri, [
                    'json' => $params,
                ]);
            } elseif ($this->method === 'get') {
                $response = $client->get($uri, [
                    'query' => $params,
                ]);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return $response ? json_decode($response->getBody()->getContents(), true) : null;
    }

    public function search(Request $request)
    {
        if($request->has('q') && $request->q !== ''){
            $params = [
                'q' => $request->q,
                'format' => $this->format,
                'accept-language' => $this->lang,
            ];
            return $this->execute('search.php', $params);
        }

        return null;
    }
}
