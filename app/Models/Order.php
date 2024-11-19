<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Order extends Model
{
    use HasFactory;

    /**
     * ORDER ATTRIBUTES

     * $this->attributes['id'] - int - contains the order primary key (id)
     * $this->attributes['user_id'] - int - contains the user id of the order
     * $this->attributes['creationDate'] - date - contains the creation date of the order
     * $this->attributes['deliveryDate'] - date - contains the delivery date of the order
     * $this->attributes['totalPrice'] - int - contains the order total price
     *
     * RELATIONSHIPS
     *
     * User - belongsTo
     * ItemInOrder - hasMany
     */
    protected $fillable = ['creationDate', 'deliveryDate', 'totalPrice'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itemInOrders(): HasMany
    {
        return $this->hasMany(ItemInOrder::class);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function getItemInOrder(): HasMany
    {
        return $this->hasMany(ItemInOrder::class, 'order_id');
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function getDeliveryDate(): string
    {
        return $this->attributes['deliveryDate'];
    }

    public function getTotalPrice(): int
    {
        return $this->attributes['totalPrice'];
    }

    public function getCustomTotalPrice(): string
    {
        return number_format($this->attributes['totalPrice'], 2);
    }

    public function setTotalPrice(int $totalPrice): void
    {
        $this->attributes['totalPrice'] = $totalPrice;
    }

    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'creationDate' => 'required',
            'deliveryDate' => 'required',
            'totalPrice' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
