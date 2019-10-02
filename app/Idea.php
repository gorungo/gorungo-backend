<?php

namespace App;

use DB;
use App\Http\Requests\Photo\UploadPhoto;
use App\Traits\Imageble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Middleware\LocaleMiddleware;
use \Conner\Tagging\Taggable;

use App\Traits\TagInfo;
use App\Http\Requests\Idea\StoreIdea;

class Idea extends Model
{

    use SoftDeletes;
    use Taggable;
    use TagInfo;
    use Imageble;

    protected $table = 'ideas';

    protected $perPage = 60;

    protected $dates = ['deleted_at'];

    protected $fillable = ['author_id', 'parent_id', 'main_category_id', 'active', 'order', 'slug'];

    protected $with = ['localisedIdeaDescription', 'ideaMainCategory'];

    Public function getTitleAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->title;
        } else {
            return '';
        }

    }

    Public function getIntroAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->intro;
        } else {
            return '';
        }

    }

    Public function getDescriptionAttribute()
    {
        if ($this->localisedIdeaDescription != null) {
            return $this->localisedIdeaDescription->description;
        } else {
            return '';
        }

    }

    Public function getUrlAttribute()
    {
        if ($this->ideaMainCategory) {
            return route('ideas.show', [$this->ideaMainCategory->pathToCategory(), $this->slug]);
        } else {
            return '';
        }
    }

    public function getEditUrlAttribute()
    {
        return route('ideas.edit', [$this->slug]);
    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute()
    {

        $defaultTmb = 'images/interface/placeholders/idea.png';

        if ($this->thmb_file_name != null) {
            //если есть картинка вакансии
            $src = 'storage/images/idea/' . $this->id . '/' . htmlspecialchars(strip_tags($this->thmb_file_name));

        } else {
            //если есть картинка вакансии
            $src = $defaultTmb;
        }

        if (!file_exists($src)) {
            $src = $defaultTmb;
        }

        return $src;
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        if (request()->is('api/*')) {
            return 'id';
        } else {
            return 'slug';
        }
    }

    public function getIsPublishedAttribute(){
        return $this->active == 1;
    }

    public function ideaActions()
    {
        return $this->hasMany('App\Action');
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

    public static function itemsList(Request $request, $activeCategory = Null)
    {
        $activeCategoryId = 0;

        if($activeCategory){
            $activeCategoryId = $activeCategory->id;
        }

        // получаем список активных идей с учетом города, страницы, локали
        return Cache::tags(['ideas'])->remember('ideas_' . LocaleMiddleware::getLocale() . '_category_' . $activeCategoryId . '_' . request()->getQueryString(), 0, function () use ($activeCategory) {
            return self::whereCategory($activeCategory)
                ->joinDescription()
                ->WhereTags(MainFilter::getFiltersTagsArray())
                ->Sorting()
                ->paginate();
        });
    }

    public function actionItemsList()
    {
        return $this->ideaActions()->isActive()->paginate();
    }

    public static function backgroundImage()
    {
        return '/images/bg/mountains_blue.svg';
    }

    /**
     * Get idea actions
     * @param int $actionsCount
     * @return mixed
     */
    public function actionItemsListLimited($actionItemsCount = 4)
    {
        return $this->ideaActions()->isActive()->take($actionItemsCount)->get();
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
                'author_id' => 1,
                'main_category_id' => $request->input('attributes.main_category_id'),
                'active' => $request->input('attributes.active'),
                'slug' => $this->generateSlug($request->input('attributes.title')),
            ];

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
                'author_id' => 1,
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

            if($this->localisedIdeaDescription){
                $this->localisedIdeaDescription()->update($descriptionStoreData);
            }else{
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
        $this->saveTags($request);
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
        $tagsText = $request->input('relationships.tags.tagsText');
        $tagsAgeGroup = $request->input('relationships.tags.tagsAgeGroup');
        $tagsDayTimeGroup = $request->input('relationships.tags.tagsDayTimeGroup');
        $tagsSeasonsGroup = $request->input('relationships.tags.tagsSeasonsGroup');

        // Составляем массив из тэгов, потом сохряняем
        if ($tagsText != '') {
            $tags = explode(",", $tagsText);
            foreach ($tags as $tag) {
                if ($tag != '') {
                    $validTags[] = trim($tag);
                }
            }

        }

        if (count($tagsAgeGroup)) {
            foreach ($tagsAgeGroup as $tag) {
                $validTags[] = $tag['attributes']['name'];
            }
        }

        if (count($tagsDayTimeGroup)) {
            foreach ($tagsDayTimeGroup as $tag) {
                $validTags[] = $tag['attributes']['name'];
            }
        }

        if (count($tagsSeasonsGroup)) {
            foreach ($tagsSeasonsGroup as $tag) {
                $validTags[] = $tag['attributes']['name'];
            }
        }

        if (count($validTags)) $this->retag($validTags);

    }


    // scopes

    public function scopeIsActive($query)
    {
        return $query->where('ideas.active', '1');
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

        $activeCategory = ($category3 !== Null) ? $category3 : Null;
        $activeCategory = ($category2 !== Null && !$activeCategory) ? $category2 : Null;
        $activeCategory = ($category1 !== Null && !$activeCategory) ? $category1 : Null;

        if ($activeCategory) {

            $activeCategoryId = Category::where('slug', $activeCategory)->pluck('id')->first();

            return $query->select('idea.*', 'idea_category.category_id')->join('idea_category', 'idea.id', 'idea_category.idea_id')->where('category_id', $activeCategoryId);

        } else {

            return $query;

        }

    }

    public function scopeJoinDescription($query)
    {
        return $query->join('idea_descriptions', function ($join) {
        $join->on('ideas.id', '=', 'idea_descriptions.idea_id')
            ->where('locale_id', LocaleMiddleware::getLocaleId());
        })->select('ideas.*', 'idea_descriptions.title','idea_descriptions.intro' );
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeWhereTags($query, Array $tags)
    {
        return $query->withAllTags($tags);
    }

    public static function emptyTagsArray()
    {
        return [
            'tagsAgeGroup' => [],
            'tagsSeasonsGroup' => [],
            'tagsDayTimeGroup' => [],
        ];
    }

    public static function getByTitle(String $title){
        return self::whereHas('ideaDescriptions', function ($query) use ($title) {
            $query->where('title', 'like' , '%' . $title . '%');
        })->take(20)->get();
    }


}
