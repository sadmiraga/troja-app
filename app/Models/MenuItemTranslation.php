<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    use HasFactory;

    // MenuItemTranslation.php
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
