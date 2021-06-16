<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tf',
        'document_id',
        'word_id',
        'weight',
    ];


    public function word (){
        return $this->belongsTo(Word::class);
    }
}
