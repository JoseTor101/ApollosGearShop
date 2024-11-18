<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Instrument extends Model
{
    use HasFactory;

    /**
     * INSTRUMENT ATTRIBUTES
     *
     * $this->attributes['id'] - int - contains the unique identifier for the instrument
     * $this->attributes['name'] - string - contains the instrument name
     * $this->attributes['description'] - string - contains a description of the instrument
     * $this->attributes['category'] - string - contains the category of the instrument
     * $this->attributes['brand'] - string - contains the brand of the instrument
     * $this->attributes['price'] - int - contains the instrument price
     * $this->attributes['quantity'] - int - contains the quantity in stock for the instrument
     * $this->attributes['reviewSum'] - float - contains the total sum of reviews for the instrument
     * $this->attributes['numberOfReviews'] - int - contains the number of reviews for the instrument
     * $this->attributes['image'] - string - contains the URL or path to the image of the instrument
     * $this->attributes['created_at'] - string - contains the creation timestamp of the instrument record
     * $this->attributes['updated_at'] - string - contains the last update timestamp of the instrument record
     *
     * RELATIONSHIPS
     *
     * Stock - hasMany()
     * Review - hasMany
     * ItemInOrder - hasMany
     */

    protected $table = 'instruments';

    protected $guarded = [];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'instrument_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'instrument_id');
    }

    /* ---- GETTERS & SETTERS ----*/

    public function getStocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'instrument_id');
    }

    public function getReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'instrument_id');
    }

    public function getItemInOrder(): HasMany
    {
        return $this->hasMany(ItemInOrder::class, 'instrument_id');
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function getCategory(): string
    {
        return $this->attributes['category'];
    }

    public function getBrand(): string
    {
        return $this->attributes['brand'];
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getReviewSum(): float
    {
        if ($this->attributes['numberOfReviews'] == 0) {
            return $this->attributes['reviewSum'];
        }

        return $this->attributes['reviewSum'] / $this->attributes['numberOfReviews'];
    }

    public function getNumberOfReviews(): int
    {
        return $this->attributes['numberOfReviews'];
    }

    public function getQuantity(): int
    {
        return $this->getStocks()->latest('updated_at')->value('quantity') ?? 0;
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function setCategory(string $category): void
    {
        $this->attributes['category'] = $category;
    }

    public function setBrand(string $brand): void
    {
        $this->attributes['brand'] = $brand;
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setReviewSum(float $review): void
    {
        $this->attributes['reviewSum'] += $review;
    }

    public function setNumberOfReviews(): void
    {
        $this->attributes['numberOfReviews'] += 1;
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    /* ---- CUSTOM METHODS ----*/

    public function getFormattedPrice(): string
    {
        return '$ '.number_format($this->attributes['price'], 2);
    }

    public function applySorting($query, $order): object
    {
        switch ($order) {
            case 'priceAsc':
                $query->orderBy('price', 'asc');
                break;
            case 'priceDesc':
                $query->orderBy('price', 'desc');
                break;
            case 'ratingAsc':
                $query->orderBy('reviewSum', 'asc');
                break;
            case 'ratingDesc':
                $query->orderBy('reviewSum', 'desc');
                break;
        }

        return $query;
    }

    public function applyFilters($query, array $filters): object
    {
        if (! empty($filters['searchByName'])) {
            $query->where('name', 'like', '%'.$filters['searchByName'].'%');
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (! empty($filters['rating'])) {
            $query->whereRaw('reviewSum / numberOfReviews >= ?', [$filters['rating']]);
        }
        if (! empty($filters['filterOrder'])) {
            $this->applySorting($query, $filters['filterOrder']);
        }

        if (! empty($filters['filterComment'])) {
            $query->orderBy('numberOfReviews', 'desc');
        }

        return $query;
    }

    public function scopeFilterInstruments($query, array $filters): object
    {
        return $this->applyFilters($query, $filters);
    }

    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric|min:0',
            'reviewSum' => 'nullable|numeric',
            'numberOfReviews' => 'nullable|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'image' => 'file|image|max:10240', //Max 10MB
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function createInstrument(array $data, string $imagePath): self
    {
        $validatedData = (new self)->validate($data);

        $instrument = self::create(array_merge($validatedData, ['image' => $imagePath]));

        $quantity = $data['quantity'] ?? 0; // 0 by default

        $instrument->getStocks()->create([
            'quantity' => $quantity,
        ]);

        return $instrument;
    }
}
