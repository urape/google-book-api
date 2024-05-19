<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    use HasFactory;

    protected $fillable = ['search_history_id', 'title', 'authors', 'description', 'info_link', 'small_thumbnail'];

    public function search_history(): BelongsTo
    {
        return $this->belongsTo(SearchHistory::class);
    }
}
