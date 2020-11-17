<?php

namespace App;

use App\Http\Middleware\LocaleMiddleware;
use App\Http\Requests\Place\StoreOSM;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OSM extends Model
{
    use SpatialTrait;
    private $method = 'get';
    protected $table = 'osms';
    protected $fillable = [
        'boundingbox', 'icon', 'importance', 'lat', 'lon', 'licence', 'osm_id',
        'osm_type', 'place_id', 'type', 'coordinates'
    ];
    protected $spatialFields = [
        'coordinates',
    ];

    public function localisedDescription()
    {
        return $this
            ->hasOne('App\OSMDescription', 'place_id', 'place_id')
            ->where('locale_id', LocaleMiddleware::getLocaleId());
    }

    public function descriptions()
    {
        return $this->hasMany('App\OSMDescription', 'place_id', 'place_id');
    }

    public function getTitleAttribute()
    {
        if ($this->localisedDescription != null) {
            return $this->localisedDescription->title;
        } else {
            if ($this->descriptions()->first()) {
                return $this->descriptions()->first()->title;
            }
        }

        return '';
    }

    public function getDisplayNameAttribute()
    {
        if ($this->localisedDescription != null) {
            return $this->localisedDescription->display_name;
        } else {
            if ($this->descriptions()->first()) {
                return $this->descriptions()->first()->title;
            }
        }

        return '';
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

    public static function createAndStore(StoreOSM $request)
    {
        $osm = DB::transaction(function () use ($request) {
            $omsData = $request->post();
            $omsDescriptionData = [
                'display_name' => $omsData['display_name'],
                'locale_id' => LocaleMiddleware::getLocaleId()
            ];

            $omsData['coordinates'] = new Point($omsData['lat'], $omsData['lon']);
            $omsData['boundingbox'] = serialize($omsData['boundingbox']);

            $osm = OSM::create($omsData);
            $osm->localisedDescription()->create($omsDescriptionData);

            return $osm;

        });

        return $osm;
    }
}
