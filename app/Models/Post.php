<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'cover'];

    public $appends = ['persian_date', 'excerpt'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Old attribute definition
     */
    public function getPersianDateAttribute(): string
    {
        return verta($this->created_at)->format('d F Y');
    }

    /*
     * New attribute definition
     */
    public function excerpt(): Attribute
    {
        return Attribute::get(fn () => Str::words($this->body, 5));
    }
}
