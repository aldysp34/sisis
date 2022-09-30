<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';
    protected $fillable = [
        'standar',
        'judul',
        'kategori',
        'tahun',
        'status',
        'link',
        'deskripsi',
        'validasi_status'
    ];
    use HasFactory;

    public function document(){
        return $this->hasOne('App\Models\Document');
    }
}
