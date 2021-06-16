<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'idf',
    ];


    public function documents (){
        return $this->belongsToMany(Document::class ,DocumentWord::class ,"word_id", "document_id");
    }
}
