<?php
/**
 * App\Models\SellerProductsIds
 *
 * @property integer $user_id
 * @property integer $seller_account_id
 * @property array $products ([[sku:'', asin:'', quantity: ''],[sku:'', asin:'', quantity: '']])
 **/


namespace App;
use App\Models\Traits\ExtendedMysqlQueries;
use Illuminate\Database\Eloquent\Model;

class SellerInventorySupply extends Model
{
    use  ExtendedMysqlQueries;
    protected $table = 'seller_inventory_supply';


}
