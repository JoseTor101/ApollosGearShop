<?php

namespace App\Models;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class Stock extends Model
{
    use HasFactory;

    /**
     * STOCK ATTRIBUTES
     *
     * $this->attributes['id'] - int - contains the unique identifier for the stock entry
     *
     * $this->attributes['quantity'] - int - contains the quantity of the instrument in stock
     *
     * $this->attributes['type'] - string - contains the type of stock movement or status (e.g., 'initial', 'purchased', 'returned')
     *
     * $this->attributes['comments'] - string - contains any additional comments about the stock entry
     *
     * $this->attributes['instrument_id'] - int - contains the ID of the related instrument
     *
     * $this->attributes['created_at'] - string - contains the creation timestamp of the stock record
     *
     * $this->attributes['updated_at'] - string - contains the last update timestamp of the stock record
     *  
     * 
     */
    protected $table = 'stock';

    protected $guarded = [];

    /* ---- RELATIONSHIPS ----*/

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }

    /* ---- GETTERS & SETTERS ----*/

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function setType(string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function getComments(): ?string
    {
        return $this->attributes['comments'];
    }

    public function setComments(?string $comments): void
    {
        $this->attributes['comments'] = $comments;
    }

    public function getInstrumentId(): int
    {
        return $this->attributes['instrument_id'];
    }

    public function setInstrumentId(int $instrumentId): void
    {
        $this->attributes['instrument_id'] = $instrumentId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* ---- CUSTOM METHODS ----*/

    public function addStock(int $quantity, string $type = "Add", ?string $comments = null): void
    {
        $latestStock = Stock::where('instrument_id', $this->attributes['instrument_id'])
                        ->orderBy('created_at', 'desc')
                        ->first();

        $newQuantity = $latestStock->attributes['quantity'] + $quantity; 

        Stock::create([
            'quantity' => $newQuantity,
            'type' => $type,
            'comments' => $comments,
            'instrument_id' => $this->attributes['instrument_id'],
        ]);
    }
    
    public function lowerStock(int $quantity, string $type = "Lower", ?string $comments = null): void
    {
        // Ensure the quantity does not become negative
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
            'type' => $type,
            'instrument_id' => $this->attributes['instrument_id'],
        ]);
    }

    public  function getLatestStocks() : object
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


    public function validate(array $data)
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
    }
}