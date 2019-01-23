<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainFilter extends Model
{

    public static function hasFiler( $fiter, $value )
    {
        if ( request()->has( $fiter ) ) {
            foreach ( explode( ',', request()->input( $fiter ) ) as $activeFilter ) {

                if ( $activeFilter == $value ) return $value;

            };
        }
        return false;
    }

    public static function getFilterTitle( $filter )
    {

        $title = '';
        $filtersInTitleCount = 0;

        if ( request()->has( $filter ) && request()->input( $filter ) != null ) {
            foreach ( explode( ',', request()->input( $filter ) ) as $value ) {

                if ( self::isRealFilter( $filter, $value ) ) {
                    $title = $title . ($title == '' ? '' : ', ') .
                        __( 'menu.' . mb_strtolower( $filter ) . '_' . mb_strtolower( $value ) );
                    $filtersInTitleCount++;
                }

                if ( $filtersInTitleCount > 1 ) break;
            };
        } else {
            $title = __( 'menu.' . mb_strtolower( $filter ) . '_' );
        }

        return $title;
    }

    private static function isRealFilter( String $filter, String $value )
    {

        $mainFilters = collect( config( 'menu.filters' ) );

        // if filter name exists
        if ( !$mainFilters->has( mb_strtolower( $filter ) ) ) return false;

        // if filter value exists
        $filterItems = collect( $mainFilters->get( $filter ) );

        if ( $filterItems->contains( mb_strtolower( $value ) ) ) {
            return true;
        }

        return false;

    }


    public static function getFiltersTagsArray()
    {
        $filtersTags = [];

        foreach ( config( 'menu.filters' ) as $filter => $values ) {
            if ( request()->has( $filter ) && request()->input( $filter ) != '' ) {
                foreach ( $values as $value ) {
                    if ( self::hasFiler( $filter, $value ) ) {
                        $filtersTags[] = $value;
                    }
                }
            }

        }

        return $filtersTags;
    }
}
