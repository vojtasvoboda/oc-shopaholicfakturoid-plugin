<?php namespace VojtaSvoboda\ShopaholicFakturoid\Models;

use Backend\Facades\BackendAuth;
use Backend\Models\User as BackendUser;
use Lovata\OrdersShopaholic\Models\Order;
use Model;
use October\Rain\Argon\Argon;

/**
 * Invoice Model
 */
class Invoice extends Model
{
    /**
     * @var string $table The database table used by the model.
     */
    public $table = 'lovata_orders_shopaholic_order_fakturoid_invoices';

    /**
     * @var array $fillable Fillable fields.
     */
    protected $fillable = ['order_id', 'fakturoid_id', 'fakturoid_number', 'created_by'];

    /**
     * @var bool $timestamps Disable timestamps since we don't have updated_at.
     */
    public $timestamps = false;

    /**
     * @var array $rules Validation rules for attributes.
     */
    public $rules = [
        'order_id' => 'required|numeric',
        'fakturoid_id' => 'required|numeric',
        'fakturoid_number' => 'required|max:20',
    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances.
     */
    protected $dates = ['created_at'];

    /**
     * @var array $belongsTo relations.
     */
    public $belongsTo = [
        'order' => [Order::class],
        'author' => [
            BackendUser::class,
            'key' => 'created_by',
        ],
    ];

    /**
     * Before create event handler.
     */
    public function beforeCreate()
    {
        $backend_user = BackendAuth::getUser();
        if (!empty($backend_user)) {
            $this->created_by = $backend_user->id;
        }
        $this->created_at = Argon::now();
    }
}
