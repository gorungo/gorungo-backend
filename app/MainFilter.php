<?php

namespace App;

use App\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;

class MainFilter extends Model
{

    public static function hasFiler($filter, $value)
    {
        if (request()->has($filter)) {
            foreach (explode(',', request()->input($filter)) as $activeFilter) {

                if ($activeFilter == $value) return $value;

            };
        }
        return false;
    }

    public static function getFilterTitle($filter)
    {

        $title = '';
        $filtersInTitleCount = 0;

        if (request()->has($filter) && request()->input($filter) != null) {
            foreach (explode(',', request()->input($filter)) as $value) {

                if (self::isRealFilter($filter, $value)) {
                    $title = $title . ($title == '' ? '' : ', ') .
                        __('menu.' . mb_strtolower($filter) . '_' . mb_strtolower($value));
                    $filtersInTitleCount++;
                }

                if ($filtersInTitleCount > 1) break;
            };
        } else {
            $title = __('menu.' . mb_strtolower($filter) . '_');
        }

        return $title;
    }

    private static function isRealFilter(String $filter, String $value)
    {

        $mainFilters = collect(config('menu.filters'));

        // if filter name exists
        if (!$mainFilters->has(mb_strtolower($filter))) return false;

        // if filter value exists
        $filterItems = collect($mainFilters->get($filter));

        if ($filterItems->contains(mb_strtolower($value))) {
            return true;
        }

        return false;

    }


    public static function getFiltersTagsArray()
    {
        $filtersTags = [];

        foreach (config('menu.filters') as $filter => $values) {
            if (request()->has($filter) && request()->input($filter) != '') {
                foreach ($values as $value) {
                    if (self::hasFiler($filter, $value)) {
                        $filtersTags[] = $value;
                    }
                }
            }

        }

        return $filtersTags;
    }

    /**
     * From which geo position we finding objects
     * @return Point
     */
    public static function searchPoint()
    {
        $place = Place::currentPlace();
        if($place && $place->coordinates) return $place->coordinates;

        return User::currentPosition();
    }

    /**
     * In what radius we finding geo objects
     * @return Point
     */
    public static function searchDistance()
    {
        $distance = config('main_filter.distance.default');
        if (request()->has('distance') && in_array( request()->input('distance'), config('menu.filters.distance'))) {
            $distance = config('main_filter.distance')[request()->input('distance')];
        }

        return $distance;
    }
}
