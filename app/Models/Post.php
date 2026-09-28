<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'cover'];

    public $appends = ['persian_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPersianDateAttribute()
    {
        return verta($this->created_at)->format('d F Y');
    }
}
