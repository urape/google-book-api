<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = ['keyword', 'searched_at'];

    public function search_results(): HasMany
    {
        return $this->hasMany(SearchResult::class);
    }
}
