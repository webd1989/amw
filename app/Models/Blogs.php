<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;



class Blogs extends Authenticatable{

  use HasFactory, Notifiable;

	
	protected $table = 'blogs';


    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $fillable = [
		'category',
		'title',
		'slug',
		'image',
		'description',
		'added_by',
		'blog_date',
		'image_alt',
		'author_id',
		'user_views',
		'canonical_tags',
		'schema_tags',
		'seo_title',
		'seo_description',
		'seo_keyword',
		'robot_tags',
		'status'
    ];



    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array<int, string>

     */

    protected $hidden = [
        

    ];



    /**

     * The attributes that should be cast.

     *

     * @var array<string, string>

     */



	public function GetRecordById($id){

		return $this::where('id', $id)->first();

	}

	public function UpdateRecord($Details){

		$Record = $this::where('id', $Details['id'])->update($Details);

		return true;

	}

	public function CreateRecord($Details){

		$Record = $this::create($Details);

		return $Record;

	}


}