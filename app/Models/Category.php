<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends UuidModel
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['title', 'metaTitle', 'parent_id', 'slug'];

    public $incrementing = false;
}
