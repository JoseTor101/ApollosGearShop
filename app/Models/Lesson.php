<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Lesson extends Model
{
    use HasFactory;

    /**
     * ORDER ATTRIBUTES

     * $this->attributes['id'] - int - contains the Lesson primary key (id)

     * $this->attributes['name'] - string - contains the Lesson name

     * $this->attributes['description'] - satring - contains the lesson description

     * $this->attributes['difficulty'] - string - contains the difficulty of the lesson

     * $this->attributes['schedule'] - string - contains the lesson schedule

     * $this->attributes['totalHours'] - int - contains the total hours of the lesson

     * $this->attributes['location'] - string - contains the lesson location

     * $this->attributes['price'] - int - contains the lesson price

     * $this->attributes['string'] - int - contains the teacher of the lesson
     */
    protected $table = 'lessons';

    protected $fillable = [
        'name', 'description', 'difficulty', 'schedule', 'totalHours',
        'location', 'price', 'teacher',
    ];

    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'required|string',
            'schedule' => 'required|string',
            'totalHours' => 'required|numeric|gt:0',
            'location' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'teacher' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    // Getters y setters
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getDifficulty(): string
    {
        return $this->attributes['difficulty'];
    }

    public function setDifficulty(string $difficulty): void
    {
        $this->attributes['difficulty'] = $difficulty;
    }

    public function getSchedule(): string
    {
        return $this->attributes['schedule'];
    }

    public function setSchedule(string $schedule): void
    {
        $this->attributes['schedule'] = $schedule;
    }

    public function getTotalHours(): int
    {
        return $this->attributes['totalHours'];
    }

    public function setTotalHours(int $totalHours): void
    {
        $this->attributes['totalHours'] = $totalHours;
    }

    public function getLocation(): string
    {
        return $this->attributes['location'];
    }

    public function setLocation(string $location): void
    {
        $this->attributes['location'] = $location;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getFormattedPrice(): string
    {
        return '$ '.number_format($this->getPrice(), 2);
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getTeacher(): string
    {
        return $this->attributes['teacher'];
    }

    public function setTeacher(string $teacher): void
    {
        $this->attributes['teacher'] = $teacher;
    }
}
