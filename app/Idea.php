<?php

namespace App;

use App\Http\Requests\UploadPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Middleware\LocaleMiddleware;
use \Conner\Tagging\Taggable;

use DB;
use App\Traits\TagInfo;
use App\Http\Requests\StoreIdea;

class Idea extends Model {

    use SoftDeletes;
    use Taggable;
    use TagInfo;

    protected $table = 'ideas';

    protected $perPage = 60;

    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'author_id', 'parent_id', 'main_category_id', 'active', 'order', 'slug' ];

    protected $with = [ 'localisedIdeaDescription', 'ideaCategories' ];

    Public function getTitleAttribute() {
        if ( $this->localisedIdeaDescription != null ) {
            return $this->localisedIdeaDescription->title;
        } else {
            return '';
        }

    }

    Public function getIntroAttribute() {
        if ( $this->localisedIdeaDescription != null ) {
            return $this->localisedIdeaDescription->intro;
        } else {
            return '';
        }

    }

    Public function getDescriptionAttribute() {
        if ( $this->localisedIdeaDescription != null ) {
            return $this->localisedIdeaDescription->description;
        } else {
            return '';
        }

    }

    Public function getUrlAttribute() {
        if ( $this->ideaMainCategory() != null ) {
            return route( 'ideas.show', [ $this->ideaMainCategory()->pathToCategory(), $this->slug ] );
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

    public function ideaActions()
    {
        return $this->hasMany( 'App\Action' );
    }

    public function ideaPhotos()
    {
        return $this->morphMany('App\Photo', 'item');
    }

    public function ideaDescriptions() {
        return $this->hasMany( 'App\IdeaDescription', 'idea_id', 'id' );
    }


    public function localisedIdeaDescription() {
        return $this
            ->hasOne( 'App\IdeaDescription', 'idea_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId() );
    }

    public function hasLocaleName( $localeName ) {
        return $this
            ->hasOne( 'App\IdeaDescription', 'idea_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId( $localeName ) )
            ->count();
    }

    public function hasLocaleId( $localeId ) {
        return $this
            ->hasOne( 'App\IdeaDescription', 'idea_id', 'id' )
            ->where( 'locale_id', $localeId )->count();

    }

    /**
     * Основная категория для определения полного url идеи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * Main item category
     * @return mixed
     */
    public function ideaMainCategory() {
        return $this->ideaCategories()->first();
    }

    public function ideaCategories() {
        return $this->belongsToMany( 'App\Category', 'idea_category', 'idea_id', 'category_id' );
    }

    public function itemsList( Request $request, $activeCategoryId = Null ) {

        return self::whereCategory( $activeCategoryId )
            ->WhereTags( MainFilter::getFiltersTagsArray() )
            ->Sorting()
            ->paginate();

        // получаем список активных идей с учетом города, страницы, локали
        return Cache::remember( 'ideas_' . LocaleMiddleware::getLocale() . '_category_' . $activeCategoryId . '_' . request()->getQueryString(), 0, function () use ( $activeCategoryId ) {
            return self::whereCategory( $activeCategoryId )
                ->WhereTags( MainFilter::getFiltersTagsArray() )
                ->Sorting()
                ->paginate();
        } );
    }

    public function actionItemsList(){
        return $this->ideaActions()->isActive()->paginate();
    }

    public function createAndSync( StoreIdea $request ){

        $createResult = DB::transaction(function () use ($request) {

            $categoriesId = []; // ids of categories of idea item

            $localeId = LocaleMiddleware::getLocaleId();

            $ideaStoreData = $request->only( 'author_id', 'parent_id', 'main_category_id', 'active', 'order', 'slug' );
            $ideaDescriptionStoreData = $request->only( 'title', 'intro', 'description' );

            $ideaStoreData['slug'] = str_slug($request->title);

            // detaching old categories to attach new later

            foreach($request->categories as $category){
                // saving idea categories
                if($category['id'] !== 0){
                    $categoriesId[] = $category['id'];
                }
            }

            if($request->main_category_id != 0){

            }else if(count($categoriesId)){
                $ideaStoreData['main_category_id'] = $categoriesId[0];
            }

            $ideaStoreData['author_id'] = 1;
            $ideaDescriptionStoreData['locale_id'] = $localeId;

            $idea = Idea::create($ideaStoreData);

            $idea->localisedIdeaDescription()->create($ideaDescriptionStoreData);

            if(count($categoriesId)){
                $idea->ideaCategories()->sync($categoriesId);
            }


            return $idea;

        });

        return $createResult;
    }

    public function updateAndSync( StoreIdea $request ) {

        $categoriesId = []; // ids of categories of idea item

        $updateResult = DB::transaction( function () use ( $request ) {

            $localeId = LocaleMiddleware::getLocaleId();

            $valid_tags = [];

            $ideaStoreData = $request->only( 'author_id', 'parent_id', 'active', 'order', 'slug' );
            $ideaDescriptionStoreData = $request->only( 'title', 'intro', 'description' );

            // detaching old categories to attach new later

            foreach ( $request->categories as $category ) {
                // saving idea categories
                if ( $category['id'] !== 0 ) {
                    $categoriesId[] = $category['id'];
                }
            }
            if ( count( $categoriesId ) ) {
                $this->ideaCategories()->sync( $categoriesId );
            }

            // updating main category. the first is main
            if ( $request->main_category_id != 0 ) {

            } else if ( count( $categoriesId ) ) {
                $ideaStoreData['main_category_id'] = $categoriesId[0];
            }


            $ideaStoreData['author_id'] = 1;
            $ideaDescriptionStoreData['locale_id'] = $localeId;


            // saving new idea data with transaction

            $this->update( $ideaStoreData );

            // updating existed localised category description or creating new

            if ( isset( $this->localisedIdeaDescription()->first()->title ) ) {
                $this->localisedIdeaDescription()->update( $ideaDescriptionStoreData );
            } else {
                $this->localisedIdeaDescription()->create( $ideaDescriptionStoreData );
            }

            // Составляем массив из тэгов, потом сохряняем-----------------------------------------------------
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
            $this->untag();
            if ( count( $valid_tags ) ) $this->tag( $valid_tags );

            return $this;

        } );

        return $updateResult;

    }

    public function uploadPhoto(UploadPhoto $request){
        $photo = New Photo();
        return $photo->createAndStore($request, $this);
    }


    // scopes

    public function scopeIsActive( $query ) {

        return $query->where( 'active', '1' );
    }

    public function scopeWhereCategory( $query, $activeCategoryId ) {

        if ( $activeCategoryId ) {

            $category = Category::find( $activeCategoryId );
            $childCategories = $category->allCategoryChildrenArray();

            return $query->whereIn( 'id', function ( $query ) use ( $childCategories ) {
                $query->select( 'idea_id' )
                    ->from( 'idea_category' )
                    ->whereIn( 'category_id', $childCategories );
            } );
        } else {
            return $query;
        }

    }

    public function scopeWhereCategory2( $query, $category1, $category2, $category3 ) {

        $activeCategory = ($category3 !== Null) ? $category3 : Null;
        $activeCategory = ($category2 !== Null && !$activeCategory) ? $category2 : Null;
        $activeCategory = ($category1 !== Null && !$activeCategory) ? $category1 : Null;

        if ( $activeCategory ) {

            $activeCategoryId = Category::where( 'slug', $activeCategory )->pluck( 'id' )->first();

            return $query->select( 'idea.*', 'idea_category.category_id' )->join( 'idea_category', 'idea.id', 'idea_category.idea_id' )->where( 'category_id', $activeCategoryId );

        } else {

            return $query;

        }

    }

    public function scopeSorting( $query ) {
        return $query->orderBy( 'id', 'desc' );
    }

    public function scopeWhereTags( $query, Array $tags ) {
        return $query->withAllTags( $tags );
    }


}
