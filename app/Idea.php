<?php

namespace App;

use DB;
use App\Traits\Imageble;
use App\Traits\Hashable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Middleware\LocaleMiddleware;
use \Conner\Tagging\Taggable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

use App\Traits\TagInfo;
use App\Http\Requests\Idea\StoreIdea;
use Illuminate\Support\Facades\Log;

class Idea extends Model
{
    use SoftDeletes, Taggable, TagInfo, Imageble, Hashable, SpatialTrait;

    const hidLength = 10;

    protected $table = 'ideas';

    protected $perPage = 60;

    protected $dates = ['deleted_at'];

    protected $fillable = ['author_id', 'idea_id', 'parent_id', 'main_category_id', 'active', 'order', 'slug'];

    protected $with = ['localisedIdeaDescription', 'ideaMainCategory'];

    public $defaultTmb = null;

    protected $spatialFields = [
        'coordinates',
    ];

    Public function getTitleAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->title;
        } else {
            $ideaDescription = $this->ideaDescriptions()->first();
            if ($ideaDescription) {
                return $ideaDescription->title;
            }
        }

    }

    Public function getIntroAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->intro;
        } else {
            $ideaDescription = $this->ideaDescriptions()->first();
            if ($ideaDescription) {
                return $ideaDescription->intro;
            }
        }

    }

    Public function getDescriptionAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->description;
        } else {
            $ideaDescription = $this->ideaDescriptions()->first();
            if ($ideaDescription) {
                return $ideaDescription->description;
            }
        }

    }


    public function getHasIdeasAttribute()
    {
        return $this->futureIdeaIdeas()->count();
    }

    public function getIsPublishedAttribute()
    {
        return $this->active == 1;
    }

    public function getIsBlockedAttribute()
    {
        return $this->active == 0;
    }

    public function getCanBeOrderedAttribute()
    {
        return $this->ideaPrice->default == false;
    }

    public function ideaPlace()
    {
        return $this->belongsTo('App\OSM', 'place_id', 'place_id');
    }

    public function ideaItineraries()
    {
        return $this->hasMany('App\Itinerary')
            ->orderBy('day_num', 'asc');
    }


    public function ideaDates()
    {
        return $this->hasMany('App\IdeaDate');
    }

    public function ideaItinerary()
    {
        return null;
    }

    /**
     * Date to display on idea card
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getDateToDisplayAttribute()
    {
        $date = $this->ideaDates()->inFuture()->first();
        return $date ? $date->startDateTimeUtc : null;
    }


    /**
     * Create empty instance in database
     * @return Idea $newIdea
     */
    public static function createEmpty()
    {
        $newIdea = self::create([
            'author_id' => User::activeUser()->id,
            'slug' => 'new_idea_slug',
        ]);

        $newIdea->slug = 'new_idea_slug_' . $newIdea->id;
        $newIdea->localisedIdeaDescription()->create([
            'locale_id' => LocaleMiddleware::getLocaleId(),
        ]);
        $newIdea->save();

        return $newIdea;
    }

    /**
     * Idea child ideas
     * @return mixed
     */
    public function ideaIdeas()
    {
        return $this
            ->hasMany('App\Idea', 'idea_id')
            ->whereHas('localisedIdeaDescription')
            ->isActive();
    }

    /**
     * Idea child ideas coming in future
     * @return mixed
     */
    public function futureIdeaIdeas()
    {
        return $this
            ->hasMany('App\Idea', 'idea_id')
            ->InFuture()
            ->whereHas('localisedIdeaDescription')
            ->isActive();
    }

    public function ideaParentIdea()
    {
        return $this->belongsTo('App\Idea', 'idea_id')->isActive();
    }

    public function ideaPrice()
    {
        return $this->hasOne('App\IdeaPrice')
            ->withDefault([
                'price' => 0,
                'currency_id' => 3,
                'default' => true,
            ]);
    }

    public function price()
    {
        return $this->hasOne('App\IdeaPrice');
    }

    public function minimalFuturePrice()
    {
        return $this->ideaPrice()->whereHas('ideaDate', function($q){
            return $q->InFuture();
        })->orderBy('price', 'asc');
    }

    public function ideaDescriptions()
    {
        return $this->hasMany('App\IdeaDescription', 'idea_id', 'id');
    }


    public function localisedIdeaDescription()
    {
        //dd(LocaleMiddleware::getLocaleId());
        return $this
            ->hasOne('App\IdeaDescription', 'idea_id', 'id')
            ->where('locale_id', LocaleMiddleware::getLocaleId());
    }

    public function hasLocaleName($localeName)
    {
        return $this
            ->hasOne('App\IdeaDescription', 'idea_id', 'id')
            ->where('locale_id', LocaleMiddleware::getLocaleId($localeName))
            ->count();
    }

    public function hasLocaleId($localeId)
    {
        return $this
            ->hasOne('App\IdeaDescription', 'idea_id', 'id')
            ->where('locale_id', $localeId)->count();

    }

    /**
     * Основная категория для определения полного url идеи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * Main item category
     * @return mixed
     */
    public function ideaMainCategory()
    {
        return $this->belongsTo('App\Category', 'main_category_id');
    }

    public function getIdeaMainCategory()
    {
        return $this->ideaMainCategory()->first();
    }

    public function ideaCategories()
    {
        return $this
            ->belongsToMany('App\Category', 'idea_category')
            ->using('App\Pivots\Category');
    }

    public function ideaAuthor()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * Ideas main list
     *
     * @param  Request  $request
     * @param  null  $activeCategory
     * @return mixed
     */
    public static function itemsList(Request $request, $activeCategory = null)
    {
        $activeCategoryId = 0;

        if ($activeCategory) {
            $activeCategoryId = $activeCategory->id;
        }

        // получаем список активных идей с учетом города, страницы, локали
        return Cache::tags(['ideas'])->remember('ideas_'.LocaleMiddleware::getLocale().'_category_'.$activeCategoryId.'_'.request()->getQueryString(),
            0, function () use ($activeCategory, $request) {
                return self::whereCategory($activeCategory)
                    ->joinPlace()
                    ->inFuture()
                    ->whereFilters()
                    ->sorting()
                    ->distinct()
                    ->select(['ideas.*', 'osms.coordinates'])
                    ->paginate();
            });
    }


    /**
     * Get ideas to show on main page sections
     *
     * @param  Request  $request
     * @param  null  $placeId
     * @param  null  $category
     * @param  int  $itemsCount
     * @return mixed
     */
    public static function widgetItemsList(Request $request, $placeId = null, $category = null, $itemsCount = 6)
    {
        return Cache::tags(['ideas'])->remember('ideas_widget_'.LocaleMiddleware::getLocale().'_category_'.$category.'_'.request()->getQueryString(), 0, function () use ($request, $placeId, $category, $itemsCount) {
                return self::whereCategory($category)
                    ->wherePlaceId($placeId)
                    ->joinDescription()
                    ->inFuture()
                    ->take($itemsCount)
                    ->get()
                    ->loadMissing($request->has('include') && $request->input('include') != '' ? explode(',', $request->include): []);
            });
    }

    /**
     * Get ideas to show on main page sections
     *
     * @param  Request  $request
     * @param  null  $category
     * @param  int  $itemsCount
     * @return mixed
     */
    public static function widgetMainItemsList(Request $request, $category = null, $itemsCount = 6)
    {
        return Cache::tags(['ideas'])->remember('ideas_widget_'.LocaleMiddleware::getLocale().'_category_'.$category.'_'.request()->getQueryString(), 0, function () use ($category, $itemsCount, $request) {
                return self::whereCategory($category)
                    ->joinDescription()
                    ->main()
                    ->isActive()
                    ->take($itemsCount)
                    ->inRandomOrder()
                    ->hasImage()
                    ->get()
                    ->loadMissing($request->has('include') && $request->input('include') != '' ? explode(',', $request->include): []);
        });
    }

    public static function itemsOfUser(User $user)
    {
        return Cache::tags(['ideas'])->remember('ideas_of_user_' . $user->id . '_' . LocaleMiddleware::getLocale() . '_category_', 0, function () use ($user) {
                return $user
                    ->ideas()
                    ->joinDescription()
                    ->hasImage()
                    ->get();
            });
    }

    public function ideaIdeasList()
    {
        return $this->ideaIdeas()->isActive()->get();
    }

    public static function backgroundImage()
    {
        return null;
        //return '/images/bg/mountains_blue.svg';
    }

    /**
     * Get idea actions
     * @param  int  $itemsCount
     * @return mixed
     */
    public function ideaIdeasListLimited($itemsCount = 4)
    {
        return $this->ideaIdeas()->inFuture()->isActive()->take($itemsCount)->get();
    }

    private function generateSlug(String $title)
    {
        return str_slug($title);
    }

    public static function randomIdea()
    {
        return self::inRandomOrder()->first();
    }

    public function createAndSync(StoreIdea $request)
    {

        $createResult = DB::transaction(function () use ($request) {

            $categoriesId = []; // ids of categories of idea item

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = [
                'author_id' => Auth()->User()->id,
                'idea_id' => $request->input('relationships.idea.id'),
                'active' => $request->input('attributes.active'),
                'slug' => $this->generateSlug($request->input('attributes.title')),
            ];

            if ($request->input('attributes.main_category_id') !== null) {
                $storeData ['main_category_id'] = $request->input('attributes.main_category_id');
            }

            $descriptionStoreData = [
                'title' => $request->input('attributes.title'),
                'intro' => $request->input('attributes.intro'),
                'description' => $request->input('attributes.description'),
                'locale_id' => $localeId,
            ];

            $idea = self::create($storeData);
            $idea->localisedIdeaDescription()->create($descriptionStoreData);

            $idea->updateRelationships($request);

            return $idea;

        });

        return $createResult;
    }

    public function updateAndSync(StoreIdea $request)
    {

        $updateResult = DB::transaction(function () use ($request) {

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = [
                'idea_id' => $request->input('relationships.idea.id'),
                'active' => $request->input('attributes.active'),
            ];

            $descriptionStoreData = [
                'title' => $request->input('attributes.title'),
                'intro' => $request->input('attributes.intro'),
                'description' => $request->input('attributes.description'),
                'locale_id' => $localeId,
            ];

            $this->update($storeData);

            if ($this->localisedIdeaDescription) {
                $this->localisedIdeaDescription()->update($descriptionStoreData);
            } else {
                $this->localisedIdeaDescription()->create($descriptionStoreData);
            }

            $this->updateRelationships($request);

            return $this;

        });

        return $updateResult;

    }

    private function updateRelationships(StoreIdea $request): void
    {
        $this->saveCategories($request);
        $this->saveItineraries($request);
        $this->saveTags($request);
        $this->savePlaces($request);
        $this->saveDates($request);
        //$this->savePrice($request);

    }

    private function savePlaces(StoreIdea $request): void
    {
        $places = $request->input('relationships.places');
        $placeIds = [];

        if (count($places)) {
            foreach ($places as $place) {
                if ($place['id'] != '') {
                    $placeIds[] = $place['id'];
                }
            }

            if (count($placeIds)) {
                $this->ideaPlaces()->syncWithoutDetaching($placeIds);
            }

        }
    }

    /*    private function savePrice(StoreIdea $request): void
        {
            $actionPrice = $request->input('relationships.price');
            if ($actionPrice['id'] !== null) {
                $this->ideaPrice()->whereId($actionPrice['id'])->update([
                    'price' => (int) $actionPrice['attributes']['price'],
                    'currency_id' => $actionPrice['relationships']['currency']['id'],
                ]);
            } else {
                $this->ideaPrice()->create([
                    'price' => (int) $actionPrice['attributes']['price'],
                    'currency_id' => $actionPrice['relationships']['currency']['id'],
                ]);
            }
        }*/


    private function saveDates(StoreIdea $request): void
    {
        $datesArray = $request->input('relationships.dates');
        $usedDateIds = [];

        if ($datesArray) {
            foreach ($datesArray as $date) {

                $ideaDate = null;
                $ideaPriceArray = $date['relationships']['ideaPrice'];

                if ($date['id'] !== null && strlen((string) $date['id']) < 13) {
                    $ideaDate = $this->ideaDates()->find($date['id']);
                    $ideaDate->update([
                        'start_date' => $date['attributes']['start_date'],
                        'start_time' => $date['attributes']['start_time'],
                        'time_zone_offset' => $date['attributes']['time_zone_offset'],
                    ]);
                } else {
                    $ideaDate = $this->ideaDates()->create([
                        'start_date' => $date['attributes']['start_date'],
                        'start_time' => $date['attributes']['start_time'],
                        'time_zone_offset' => $date['attributes']['time_zone_offset'],
                    ]);
                }

                $usedDateIds[] = $ideaDate->id;

                // save date price
                if ($ideaPriceArray['id'] !== null) {
                    $this->ideaPrice()->whereId($ideaPriceArray['id'])->update([
                        'idea_date_id' => $ideaDate->id,
                        'idea_price_type_id' => 1,
                        'age_group_id' => 1,
                        'price' => (int) $ideaPriceArray['attributes']['price'],
                        'currency_id' => $ideaPriceArray['relationships']['currency']['id'],
                    ]);
                } else {
                    $this->ideaPrice()->create([
                        'idea_date_id' => $ideaDate->id,
                        'idea_price_type_id' => 1,
                        'age_group_id' => 1,
                        'price' => (int) $ideaPriceArray['attributes']['price'],
                        'currency_id' => $ideaPriceArray['relationships']['currency']['id'],
                    ]);
                }
            }

        }

        // remove not used dates from database
        $this->ideaDates()->whereNotIn('id', $usedDateIds)->forceDelete();

    }

    private function saveDatePrice(): void
    {

    }

    private function saveItineraries(StoreIdea $request): void
    {
        $itineraries = $request->input('relationships.itineraries');

        if ($request->id !== null && $itineraries) {
            foreach ($itineraries as $itinerary) {
                $descriptionStoreData = [
                    'title' => $itinerary['attributes']['title'],
                    'description' => $itinerary['attributes']['description'],
                    'what_included' => $itinerary['attributes']['whatIncluded'],
                    'will_visit' => $itinerary['attributes']['willVisit'],
                    'locale_id' => LocaleMiddleware::getLocaleId(),
                ];

                // todo
                // на фронте переделать, чтобы выдавался дефолтный id
                // соотвественно тут научить это все понимать

                if ($itinerary['id'] !== null && $itinerary['id'] !== 0) {

                    $itineraryObj = Itinerary::find($itinerary['id']);
                    $itineraryObj->start_time = $itinerary['attributes']['startTime'];
                    $itineraryObj->day_num = $itinerary['attributes']['dayNum'];
                    $itineraryObj->day_order = $itinerary['attributes']['dayOrder'];

                    if ($itineraryObj->localisedItineraryDescription) {
                        $itineraryObj->localisedItineraryDescription()->update($descriptionStoreData);
                    } else {
                        $itineraryObj->localisedItineraryDescription()->create($descriptionStoreData);
                    }

                    //$itineraryObj->localisedItineraryDescription()->updateOrCreate($descriptionStoreData);

                    $itineraryObj->save();


                } else {
                    $itineraryObj = $this->ideaItineraries()->create([
                        'idea_id' => $request->input('id'),
                        'start_time' => $itinerary['attributes']['startTime'],
                        'day_num' => $itinerary['attributes']['dayNum'],
                    ]);

                    $itineraryObj->localisedItineraryDescription()->create($descriptionStoreData);
                }
            }

        }
    }


    private function saveCategories(StoreIdea $request): void
    {
        $categories = $request->input('relationships.categories');

        $categoriesIds = [];

        if ($categories) {
            foreach ($categories as $category) {
                $categoriesIds[] = $category['id'];
            }

        }

        if (count($categoriesIds) > 0) {
            $this->ideaCategories()->sync($categoriesIds);
        }

    }

    private function saveTags(StoreIdea $request): void
    {
        $tagsArray = $request->input('relationships.tags');
        $validTags = [];

        // Составляем массив из тэгов, потом сохряняем
        if ($tagsArray && count($tagsArray)) {
            foreach ($tagsArray as $tag) {
                if ($tag['attributes']['name'] !== '') {
                    $validTags[] = trim($tag['attributes']['name']);
                }
            }
        }

        if (count($validTags)) {
            $this->retag($validTags);
        }

    }


    // scopes

    public function scopeIsActive($query)
    {
        return $query->where('ideas.active', 1);
    }

    /**
     * Item is approved by moderator
     * @param $query
     * @return mixed
     */
    public function scopeIsApproved($query)
    {
        return $query->where('ideas.is_approved', 1);
    }

    /**
     * Item is published by owner
     * @param $query
     * @return mixed
     */
    public function scopeIsPublished($query)
    {
        return $query->where('ideas.published', 1);
    }

    public function scopeWhereCategory($query, Category $activeCategory = null)
    {

        if ($activeCategory) {

            $childCategories = $activeCategory->allCategoryChildrenArray();

            return $query->whereIn('ideas.id', function ($query) use ($childCategories) {
                $query->select('idea_id')
                    ->from('idea_category')
                    ->whereIn('category_id', $childCategories);
            });
        } else {
            return $query;
        }

    }

    public function scopeWhereCategory3($query, Category $activeCategory = null)
    {

        if ($activeCategory) {

            $childCategories = $activeCategory->allCategoryChildrenArray();


            return $query->whereHas('ideaCategories.categoryChildren', function ($query) use ($childCategories) {
                $query->whereIn('category_id', $childCategories);
            });
        } else {
            return $query;
        }

    }

    public function scopeWhereCategory2($query, $category1, $category2, $category3)
    {

        $activeCategory = ($category3 !== null) ? $category3 : null;
        $activeCategory = ($category2 !== null && !$activeCategory) ? $category2 : null;
        $activeCategory = ($category1 !== null && !$activeCategory) ? $category1 : null;

        if ($activeCategory) {

            $activeCategoryId = Category::where('slug', $activeCategory)->pluck('id')->first();

            return $query->select('idea.*', 'idea_category.category_id')->join('idea_category', 'idea.id',
                'idea_category.idea_id')->where('category_id', $activeCategoryId);

        } else {

            return $query;

        }

    }

    public function scopeJoinDescription($query)
    {
        return $query->join('idea_descriptions', function ($join) {
            $join->on('ideas.id', '=', 'idea_descriptions.idea_id')
                ->where('locale_id', LocaleMiddleware::getLocaleId());
        })->select('ideas.*', 'idea_descriptions.title', 'idea_descriptions.intro');
    }

    public function scopeJoinPlace($query)
    {
        return $query->join('osms', 'ideas.place_id', '=', 'osms.place_id');
    }

    public function scopeSorting($query)
    {
        $searchPoint = MainFilter::searchPoint();
        if($searchPoint){
            return $query->distance('coordinates', $searchPoint, MainFilter::searchDistance())
                ->orderByDistance('coordinates', $searchPoint, 'asc');
        }
        return $query;
    }

    public function scopeWhereTags($query, Array $tags)
    {
        return $query->withAllTags($tags);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', 1);
    }

    public function scopeDateFilter($query)
    {
        return $query->inFuture();
    }

    /**
     * Scope items will be in future
     * @param $query
     * @return mixed
     */
    public function scopeInFuture($query)
    {
        return $query->whereHas('ideaDates', function ($query) {
            $query->whereRaw("TO_DAYS(NOW()) < TO_DAYS(`start_date`)");
        })->orDoesntHave('ideaDates');
    }

    /**
     * Scope main filter
     * @param $query
     * @return mixed
     */
    public function scopeWhereFilters($query)
    {
        return $query
            ->WherePlace()
            ->WhereTags(MainFilter::getFiltersTagsArray())
            ->WhereDates()
            ->WherePrices();
    }

    /**
     * Scope filter main filter dates
     * @param $query
     * @return mixed
     */
    public function scopeWhereDates($query)
    {
        if (request()->has('checkin')) {
            return $query->whereHas('ideaDates', function ($query) {
                $dateFrom = request()->input('checkin');
                $dateTo = request()->input('checkout');
                $query
                    ->whereDate('start_date', '>=', date_format(date_create($dateFrom), 'Y-m-d'))
                    ->whereDate('start_date', '<=', date_format(date_create($dateTo), 'Y-m-d'));

            });

        }

        return $query;
    }

    /**
     * Scope filter main filter prices
     * @param $query
     * @return mixed
     */
    public function scopeWherePrices($query)
    {
        return $query;
    }

    public function scopeHasImage($query)
    {
        return $query->whereNotNull('thmb_file_name');
    }

    public function scopeNotModerated($query)
    {
        return $query->whereNull('is_approved')->whereHas('IdeaApproval', function($q){
            $q->whereNull('moderated_at')->where(function($q2){
                $q2->where('moderator_id', null)->elseWhere('moderator_id', User::activeUser()->id);
            });
        });
    }

    /**
     * Scope ideas belonged to region or city
     * @param $query
     * @return mixed
     */
    public function scopeWherePlace($query)
    {
//        if (request()->has('place_id')) {
//            return $query->whereHas('ideaPlace', function ($q) {
//                $q->OrderByPlace();
//            });
//        }
        if(request()->has('search_type')){
            switch (request()->input('search_type')) {
                case 'place_id':
                    return $query->where('ideas.place_id', request()->input('place_id'));

                case 'nearby':
                    return $query->where('ideas.place_id', request()->input('place_id'));

                default:
                    return $query->where('ideas.place_id', request()->input('place_id'));
            }
        }
        return $query;
    }

    public function scopeWherePlaceId($query, $placeId)
    {
        if ($placeId !== null) {
            return $query->whereHas('ideaPlace', function ($q) use ($placeId) {
                $q->where('places.id', $placeId);
            });
        }
        return $query;
    }

    public static function emptyTagsArray()
    {
        return [
            'tagsAgeGroup' => [],
            'tagsSeasonsGroup' => [],
            'tagsDayTimeGroup' => [],
        ];
    }

    public static function getByTitle(String $title)
    {
        return self::whereHas('ideaDescriptions', function ($query) use ($title) {
            $query->where('title', 'like', '%'.$title.'%');
        })->take(20)->get();
    }

    public static function getMain()
    {
        return self::main()->take(50)->get();
    }


}
