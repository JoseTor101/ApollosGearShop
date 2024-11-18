<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class Stock extends Model
{
    use HasFactory;

    /**
     * STOCK ATTRIBUTES
     *
     * $this->attributes['id'] - int - contains the unique identifier for the stock entry
     * $this->attributes['quantity'] - int - contains the quantity of the instrument in stock
     * $this->attributes['type'] - string - contains the type of stock movement or status (e.g., 'initial', 'purchased', 'returned')
     * $this->attributes['comments'] - string - contains any additional comments about the stock entry
     * $this->attributes['instrument_id'] - int - contains the ID of the related instrument
     * $this->attributes['created_at'] - string - contains the creation timestamp of the stock record
     * $this->attributes['updated_at'] - string - contains the last update timestamp of the stock record
     *
     * RELATIONSHIPS
     *
     * Instrument - belongsTo
     */

    protected $table = 'stocks';

    protected $guarded = [];

    /* ---- GETTERS & SETTERS ----*/

    public function getInstrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }

    public function getInstrumentId(): int
    {
        return $this->attributes['instrument_id'];
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function getComments(): ?string
    {
        return $this->attributes['comments'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function setInstrumentId(int $instrumentId): void
    {
        $this->attributes['instrument_id'] = $instrumentId;
    }

    public function setType(string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function setComments(?string $comments): void
    {
        $this->attributes['comments'] = $comments;
    }

    /* ---- CUSTOM METHODS ----*/

    public function addStock(int $quantity, ?string $comments = null): void
    {
        $latestStock = Stock::where('instrument_id', $this->attributes['instrument_id'])
            ->orderBy('created_at', 'desc')
            ->first();

        $newQuantity = $latestStock->attributes['quantity'] + $quantity;

        Stock::create([
            'quantity' => $newQuantity,
            'type' => 'Add',
            'comments' => $comments,
            'instrument_id' => $this->attributes['instrument_id'],
        ]);
    }

    /*public function lowerStock(int $quantity, ?string $comments = null): void
    {
        if ($this->attributes['quantity'] < $quantity) {
            throw new InvalidArgumentException('Quantity cannot be negative.');
        }

        $latestStock = Stock::where('instrument_id', $this->attributes['instrument_id'])
            ->orderBy('created_at', 'desc')
            ->first();

        $newQuantity = $latestStock->attributes['quantity'] - $quantity;

        Stock::create([
            'quantity' => $newQuantity,
            'comments' => $comments,
            'type' => 'Lower',
            'instrument_id' => $this->attributes['instrument_id'],
        ]);
    }*/

    public function lowerStock(int $quantity, ?string $comments = null): void
    {
        $latestStock = Stock::where('instrument_id', $this->attributes['instrument_id'])
            ->orderBy('updated_at', 'desc')
            ->first();

        if (! $latestStock) {
            throw new InvalidArgumentException('No stock available for this instrument.');
        }

        if ($latestStock->getQuantity() < $quantity) {
            throw new InvalidArgumentException('Quantity cannot be negative or exceed available stock.');
        }

        $newQuantity = $latestStock->getQuantity() - $quantity;

        Stock::create([
            'quantity' => $newQuantity,
            'comments' => $comments,
            'type' => 'Lower',
            'instrument_id' => $this->attributes['instrument_id'],
        ]);
    }

    public function getLatestStocks(): object
    {
        return self::select('s1.*')
            ->from(DB::raw('(SELECT * FROM stock s1
                         WHERE s1.created_at = (SELECT MAX(s2.created_at)
                                                 FROM stock s2
                                                 WHERE s2.instrument_id = s1.instrument_id)
                        ) as s1'))
            ->orderBy('s1.created_at', 'desc')
            ->get();
    }

    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'instrument_id' => 'required|exists:instruments,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
