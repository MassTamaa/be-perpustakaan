<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasUuids;
    
    protected $table = 'books';

    protected $fillable = [
        'title', 'summary', 'image', 'stock', 'category_id', 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function listBarrows()
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }
}
