<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StorageTransaction
 *
 * @property int $id
 * @property string $date
 * @property string $type
 * @property int $product_id
 * @property float $price
 * @property int $amount
 * @property int $discount
 * @property float $sum
 * @property int $code
 * @property int $appointment_id
 * @property int $client_id
 * @property int $employee_id
 * @property int $storage1_id
 * @property int $storage2_id
 * @property int $partner_id
 * @property int $account_id
 * @property string $description
 * @property bool $is_paidfor
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $transaction_items
 * @property-read \App\Account $account
 * @property-read \App\ProductCategory $categories
 * @property-read \App\Client $client
 * @property-read \App\Employee $employee
 * @property-read \App\Organization $organization
 * @property-read \App\Partner $partner
 * @property-read \App\Product $product
 * @property-read \App\Storage $storage1
 * @property-read \App\Storage $storage2
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereAppointmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereIsPaidfor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction wherePartnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereStorage1Id($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereStorage2Id($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereSum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereTransactionItems($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StorageTransaction extends Model
{
	protected $table = 'storage_transactions';
	protected $primaryKey = 'id';

	protected $fillable = [
		'type',
		'is_paidfor',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function categories()
	{
		
		//return $this->hasManyThrough(ProductCategory::class, Product::class, 'product_id', 'product_category_id', 'category_id');
		return $this->belongsToMany(ProductCategory::class, 'products', 'product_id', 'category_id');
		// $st = $this->belongsTo(Product::class, 'product_id')->getResults();

		// return $st->belongsTo(ProductCategory::class, 'category_id', 'product_category_id');
	}

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class, 'partner_id');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'client_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}

	public function storage1()
	{
		return $this->belongsTo(Storage::class, 'storage1_id');
	}

	public function storage2()
	{
		return $this->belongsTo(Storage::class, 'storage2_id');
	}
}
