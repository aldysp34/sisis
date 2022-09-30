<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'type',
        'size',
        'folder_path',
        'data_id'
    ];

    public function data(){
        return $this->belongsTo('App\Models\Data');
    }
}
