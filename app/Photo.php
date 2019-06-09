<?php

namespace App;


use App\Http\Requests\setMainPhoto;
use Illuminate\Http\Request;
use App\Http\Requests\UploadPhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class Photo extends Model
{

    protected $table = 'photos';
    protected $thmbWidth = 400;
    protected $maxImageWidth = 2000;

    protected $maxFileSize = 15; // megabites


    protected $fillable = [
        'img_name',
        'item_id',
        'item_type',
    ];

    public $modelName;

    protected $appends = ['url'];

    public function __construct(array $attributes = [])
    {
        if(isset($this->item_type))$this->modelName = $this->item_type;
        parent::__construct($attributes);
    }

    public function item() {
        return $this->morphTo();
    }

    public function getAbsoluteURLAttribute(){
        return asset($this->StoragePath);
    }

    public function getRelativeURLAttribute(){
        return 'storage/images/' . $this->item_type . '/' . $this->item_id . '/' . $this->img_name;
    }

    public function getUrlAttribute(){
        return asset($this->StoragePath);
    }

    /**
     * Путь к директории с изображениями
     * @param $itemId
     * @return string
     */

    public function getStoreDirectoryUrl($itemId = null){
        if($this->item_id){
            $itemId = $this->item_id;
            return 'images/' . $this->item_type . '/' . $itemId;
        } else {
            return 'images/' . $this->modelName . '/' . $itemId;
        }

    }


    /**
     * Путь к изобаржению в storage
     */

    public function getStoragePathAttribute() {
        return 'storage/images/' . mb_strtolower($this->item_type) . '/' . $this->item_id . '/' . $this->img_name;
    }


    public function createAndStore(UploadPhoto $request, Model $model){

        $newPhoto = null;

        if($model->id !== null){

            $this->modelName = ucfirst(explode('\\', get_class( $model ) )[1]);

            $image = $request->file('image');
            $newFileName = mb_strtolower('img' . str_random(5) . '.' . $image->getClientOriginalExtension());
            $uploadPath = $this->getStoreDirectoryUrl( $model->id ) . '/' . $newFileName;

            // сохраняем изображение на диске в нужной папке, если нужно ресайзим

            if($this->uploadImage( $request , $uploadPath )){

                $photoStoreData = [
                    'item_id' => $model->id,
                    'item_type' => $this->modelName,
                    'img_name' => $newFileName,
                ];

                $newPhoto = self::create($photoStoreData);


            }
        }

        return $newPhoto;
    }



    /**
     * Resizing and saving uploaded img
     *
     * @param Request $request
     * @param integer $imgId
     * @param integer $itemId
     * @return array
     */

    public function uploadImage(Request $request, $uploadPath)
    {

        if ($request->hasFile('image')) {

            try {

                $image = $request->file('image');
                $img = Image::make($image->getRealPath());

                if ($img->width() > $this->maxImageWidth) {
                    $img->resize($this->maxImageWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->stream();

                Storage::disk('public')->put( $uploadPath, $img, 'public');

                if(file_exists('storage/'. $uploadPath)){
                    return true;
                }

            } catch (\Exception $e){
                Log::error($e);
            }

        }

        return false;


    }

    public function uploadProfileImages(Request $request, $uploadPathBig, $uploadPathSmall)
    {

        if ($request->hasFile('image')) {

            try {

                array_map( 'unlink', glob( public_path( 'storage/' . $this->getStoreDirectoryUrl() ) . "/*.*" ) );

                $image = $request->file('image');
                $img = Image::make($image->getRealPath());

                // сохраняем аватарку 200 на 200

                $img->fit( 200, 200 );
                $img->stream();
                Storage::disk( 'public' )->put( $uploadPathBig, $img, 'public' );

                // сохраняем аватарку 50 на 50

                $img->fit( 50, 50 );
                $img->stream();
                Storage::disk( 'public' )->put( $uploadPathSmall, $img, 'public' );

                if(file_exists('storage/'. $uploadPathBig) && file_exists('storage/'. $uploadPathSmall)){
                    return true;
                }

            } catch (\Exception $e){
                Log::error($e);
            }

        }

        return false;


    }


    /**
     * Making photo main
     *
     * @param SetMainPhoto $request
     * @return array
     */

    Public function setMain()
    {

        // устанавливает главную картинку

        try {

            $img = Image::make($this->StoragePath);

            array_map( 'unlink', glob( public_path( 'storage/' . $this->getStoreDirectoryUrl() ) . "/tmb*.*" ) );

            list($txt, $ext) = explode(".", $this->img_name);

            $newMainPhotoFileName = 'tmb' . str_random(5) . '.' . $ext;

            if($this->item_type == 'Post'){
                $img->fit(400,300);

            }else{
                $img->resize( $this->thmbWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            }

            $img->stream(); // <-- Key point

            Storage::disk('public')->put($this->getStoreDirectoryUrl() . '/' . $newMainPhotoFileName, $img, 'public');

            $this->item->thmb_file_name = $newMainPhotoFileName;
            $this->item->save();

            return ['type' => 'ok', 'file_name' => $newMainPhotoFileName];

        } catch (\Exception $e){

            Log::error($e);

        }

        return [
            'type' => 'error',
        ];

    }

    /**
     * Remove photo
     * @return boolean
     */

    Public function deletePhoto()
    {

        // устанавливает главную картинку

        try {

            $img = Image::make($this->StoragePath);

            Storage::disk('public')->delete( $this->getStoreDirectoryUrl() . '/' . $this->img_name);

            if(file_exists('storage/'. $this->getStoreDirectoryUrl() . '/' . $this->img_name)){
                return false;
            }

            return true;

        } catch (\Exception $e){

            Log::error($e);

        }

        return false;


    }

    public function scopeIsActive($query){
        return $query->where('active', '=', '1');
    }

}
