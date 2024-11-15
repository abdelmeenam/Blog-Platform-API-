<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'author_id',
    ];


    /**
     * Search posts by title, author, or category
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function ($authorQuery) use ($search) {
                  $authorQuery->where('name', 'LIKE', "%{$search}%");
              })
              ->orWhere('category', 'LIKE', "%{$search}%");
        });
    }


    /**
     * Filter posts by date range and category
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $startDate
     * @param mixed $endDate
     * @param mixed $category
     * @return Builder
     */
    public function scopeFilter(Builder $query, $startDate = null, $endDate = null, $category = null)
    {
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($category) {
            $query->where('category', $category);
        }

        return $query;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
