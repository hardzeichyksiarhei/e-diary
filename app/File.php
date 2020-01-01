<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;

class File extends Model
{
  protected $fillable = [
    'tmp_name', 'name',  'type', 'extension', 'user_id'
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = [
    'user'
  ];

  public static $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
  public static $document_ext = ['doc', 'docx', 'pdf', 'odt', 'xlsx'];

  /**
	 * Get the user attribute.
	 *
	 * @return string
	 */
	public function getUserAttribute()
	{
			return $this->user()->first();
  }

  /**
   * Get maximum file size
   * @return int maximum file size in kilobites
   */
  public static function getMaxSize()
  {
    return 3000;
  }

  /**
   * Get directory for the specific user
   * @return string Specific user directory
   */
  public function getUserDir()
  {
    return explode('@', Auth::user()->email)[0] . '_' . Auth::id();
  }

  /**
   * Get all extensions
   * @return array Extensions of all file types
   */
  public static function getAllExtensions()
  {
    $merged_arr = array_merge(self::$image_ext, self::$document_ext);
    return implode(',', $merged_arr);
  }

  /**
   * Get type by extension
   * @param  string $ext Specific extension
   * @return string      Type
   */
  public function getType($ext)
  {
    if (in_array($ext, self::$image_ext)) {
      return 'image';
    }
    if (in_array($ext, self::$document_ext)) {
      return 'document';
    }
  }

  /**
   * Get file name and path to the file
   * @param  string $type      File type
   * @param  string $name      File name
   * @param  string $extension File extension
   * @return string            File name with the path
   */
  public function getName($type, $name, $extension)
  {
    return '/' . $this->getUserDir() . '/' . $type . '/' . $name . '.' . $extension;
  }

  /**
   * Upload file to the server
   * @param  string $type      File type
   * @param  object $file      Uploaded file from request
   * @param  string $name      File name
   * @param  string $extension File extension
   * @return string|boolean    String if file successfully uploaded, otherwise - false
   */
  public function upload($disk, $type, $file, $name, $extension)
  {

    $path = '/' . $this->getUserDir() . '/' . $type . '/';
    $full_name = $name . '.' . $extension;

    if ($type === 'image') {

      $img = Image::make($file)->widen(600);

      return Storage::disk($disk)
        ->put($path . $full_name, $img->stream());
    } else {
      return Storage::disk($disk)
        ->putFileAs($path, $file, $full_name);
    }
  }

  public function getCreatedAtAttribute($value)
  {
    Carbon::setLocale(config('app.locale'));
    return Carbon::parse($value)->diffForHumans();
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function share_users()
  {
    return $this->belongsToMany('App\User');
  }
}
