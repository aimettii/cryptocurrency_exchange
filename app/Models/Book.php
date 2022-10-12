<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $table = 'books';

    public $fillable = [
        'name',
        'author'
    ];

    protected $casts = [
        'name' => 'string',
        'author' => 'string'
    ];

    public static $rules = [
        'name' => 'required|string',
        'author' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    protected static function newFactory()
    {
        return \Database\Factories\BookFactory::new();
    }
}
