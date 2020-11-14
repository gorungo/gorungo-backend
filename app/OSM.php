<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OSM extends Model
{
    private $method = 'get';
    protected $table = 'osms';

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
        // делаем запрос в осм
        // сохраняем результат в нашу базу
        // делам запрос в нашу базу
        // отправляем результат

        if($request->has('q') && $request->q !== ''){
            $params = [
                'q' => $request->q,
                'format' => $request->get('format'),
                'accept-language' => $request->get('accept-language'),
            ];
            return $this->execute('search.php', $params);
        }

        return null;
    }
}
