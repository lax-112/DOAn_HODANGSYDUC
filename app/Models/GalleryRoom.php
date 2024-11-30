<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GalleryRoom extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'image'];
    protected $table = 'galleries_room';
    protected $path = 'public/images/galleries_room/';
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for gallery
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000'
        ];
    }

    /**
     * @param $roomId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImages($roomId)
    {
        return $this->where('room_id', $roomId)->get();
    }

    /**
     * Store image for gallery
     *
     * @param Request $request
     * @param $roomId
     */
    public function storeGallery(Request $request, $roomId)
    {
        room::findOrFail($roomId);

        $images = $request->file('images');
        $files = Utilities::storeMultiImage($images, $this->path);
        $data = [];

        foreach ($files as $file) {
            $input = [
                'room_id' => $roomId,
                'image' => $file,
            ];
            $data[] = $input;
        }

        self::insert($data);
    }

    /**
     * Delete the image by id in galleries.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $gallery = $this->findOrFail($id);
        Storage::delete($this->path . $gallery->image);
        return $gallery->delete();
    }
}
