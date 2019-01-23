<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Middleware\LocaleMiddleware;
use \Conner\Tagging\Taggable;

use DB;
use App\ActionDescription;
use App\Traits\TagInfo;
use App\Http\Requests\StoreIdea;
use App\Http\Requests\UploadPhoto;

class Action extends Model {

    use SoftDeletes;
    use Taggable;
    use TagInfo;

    protected $table = 'actions';

    protected $perPage = 60;

    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'author_id', 'idea_id', 'active', 'slug' ];

    protected $with = [ 'localisedActionDescription' ];



    Public function getTitleAttribute() {
        if ( $this->localisedActionDescription != null ) {
            return $this->localisedActionDescription->title;
        } else {
            return '';
        }

    }

    Public function getIntroAttribute() {
        if ( $this->localisedActionDescription != null ) {
            return $this->localisedActionDescription->intro;
        } else {
            return '';
        }

    }

    Public function getDescriptionAttribute() {
        if ( $this->localisedActionDescription != null ) {
            return $this->localisedActionDescription->description;
        } else {
            return '';
        }

    }

    Public function getUrlAttribute() {


        if ( $this->actionIdea->ideaMainCategory() != null ) {
            return route( 'actions.show', [ $this->actionIdea->ideaMainCategory()->pathToCategory(),$this->actionIdea->slug, $this->slug ] );
        } else {
            return '';
        }

    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute() {

        $defaultTmb = 'images/interface/placeholders/idea.png';

        if ( $this->thmb_file_name != null ) {
            //если есть картинка вакансии
            $src = 'storage/images/idea/' . $this->id . '/' . htmlspecialchars( strip_tags( $this->thmb_file_name ) );

        } else {
            //если есть картинка вакансии
            $src = $defaultTmb;
        }

        if ( !file_exists( $src ) ) {
            $src = $defaultTmb;
        }

        return $src;
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() {
        if( request()->is('api/*')){
            return 'id';
        }else{
            return 'slug';
        }
    }

    /**
     * Action idea
     * @return mixed
     */
    public function actionIdea() {
        return $this->belongsTo( 'App\Idea', 'idea_id','id');
    }

    public function actionPhotos()
    {
        return $this->morphMany('App\Photo', 'item');
    }

    public function actionDescriptions() {
        return $this->hasMany( 'App\ActionDescription', 'action_id', 'id' );
    }


    public function localisedActionDescription() {
        return $this
            ->hasOne( 'App\ActionDescription', 'action_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId() );
    }

    public function hasLocaleName( $localeName ) {
        return $this
            ->hasOne( 'App\ActionDescription', 'action_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId( $localeName ) )
            ->count();
    }

    public function hasLocaleId( $localeId ) {
        return $this
            ->hasOne( 'App\ActionDescription', 'action_id', 'id' )
            ->where( 'locale_id', $localeId )->count();

    }


    public function itemsList( Request $request) {

        return self::WhereTags( MainFilter::getFiltersTagsArray() )
            ->Sorting()
            ->paginate();

        // получаем список активных идей с учетом города, страницы, локали
        return Cache::remember( 'actions_' . LocaleMiddleware::getLocale() . '_' . request()->getQueryString(), 0, function () use ( $activeCategoryId ) {
            return self::WhereTags( MainFilter::getFiltersTagsArray() )
                ->Sorting()
                ->paginate();
        } );
    }

    public function createAndSync( StoreAction $request ){

        $createResult = DB::transaction(function () use ($request) {

            $categoriesId = []; // ids of categories of idea item

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = $request->only( 'author_id', 'parent_id', 'main_category_id', 'active', 'order', 'slug' );
            $descriptionStoreData = $request->only( 'title', 'intro', 'description' );

            $storeData['slug'] = str_slug($request->title);
            $storeData['author_id'] = 1;

            $descriptionStoreData['locale_id'] = $localeId;

            $action = self::create($storeData);
            $action->localisedActionDescription()->create($descriptionStoreData);

            return $action;

        });

        return $createResult;
    }

    public function updateAndSync( StoreAction $request ) {

        $updateResult = DB::transaction( function () use ( $request ) {

            $localeId = LocaleMiddleware::getLocaleId();

            $valid_tags = [];

            $storeData = $request->only( 'author_id', 'parent_id', 'active', 'order', 'slug' );
            $descriptionStoreData = $request->only( 'title', 'intro', 'description' );

            $storeData['author_id'] = 1;
            $descriptionStoreData['locale_id'] = $localeId;

            $this->update( $storeData );
            $this->saveTags( $request );

            return $this;

        } );

        return $updateResult;

    }

    private function saveTags( StoreAction $request ) : void {

        // Составляем массив из тэгов, потом сохряняем

        if ( $request->tag != '' ) {
            $tags = explode( ",", $request->tag );
            foreach ( $tags as $tag ) {
                if ( $tag != '' ) {
                    $valid_tags[] = trim( $tag );
                }
            }

        }

        if ( $request->tag_extra ) {
            foreach ( $request->tag_extra as $key => $tag ) {
                $valid_tags[] = trim( $tag );
            }

        }

        // save all tags
        $this->retag($valid_tags);

    }

    public function uploadPhoto(UploadPhoto $request){
        $photo = New Photo();
        return $photo->createAndStore($request, $this);
    }


    // scopes

    public function scopeIsActive( $query ) {

        return $query->where( 'active', '1' );
    }


    public function scopeSorting( $query ) {
        return $query->orderBy( 'id', 'desc' );
    }

    public function scopeWhereTags( $query, Array $tags ) {
        return $query->withAllTags( $tags );
    }


}
