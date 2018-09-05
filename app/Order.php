<?php namespace App;

use App\Models\Traits\ExtendedMysqlQueries;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use  ExtendedMysqlQueries;

    protected $table = 'orders';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];


}
