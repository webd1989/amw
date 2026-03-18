<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Colleges extends Authenticatable{
  use HasFactory, Notifiable;
	
	protected $table = 'colleges';

    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $fillable = [
		'name',
		'slug',
		'country',
		'state',
		'city',
		'type',
		'rating',
		'ranking',
		'fees',
		'courses',
		'logo',
		'brochure',
		'campus',
		'hospital',
		'fees_structure',
		'mess',
		'description',
		'miscellaneous',
		'course_name',
		'address',
		'management',
		'inspection_year',
		'seats',
		'mci_recongniotion',
		'lop_date',
		'schema_tags',
		'canonical_tags',		
		'gen_boys ',
		'obc_boys',
		'ews_boys',
		'sc_boys',
		'st_boys',
		'mbc_boys',
		'sa_boys',
		'gen_girls',
		'obc_girls',
		'ews_girls',
		'sc_girls',
		'st_girls',
		'mbc_girls',
		'sa_girls',		
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