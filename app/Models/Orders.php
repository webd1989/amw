<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Orders extends Authenticatable{

  use HasFactory, Notifiable;
	
	protected $table = 'orders';

    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $fillable = [
		'product_id',
		'user_id',
		'invoice_id',
		'coupon_code',
		'product_name',
		'customer_name',
		'customer_email',
		'customer_mobile',
		'customer_address',
		'customer_city',
		'customer_state',
		'customer_country',
		'customer_zipcode',
		'order_date',
		'discount',
		'total',
		'order_status',
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