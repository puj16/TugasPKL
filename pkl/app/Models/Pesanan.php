<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 't_pesanan';
    protected $primaryKey = 'id';
    protected $fillable = ['id'];
    protected $dates = ['tanggal'];

    public function pesananDetail()
    {
        return $this->hasMany(PesananDetail::class, 't_pesanan_id');
    }
}
