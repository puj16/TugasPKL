<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;
    protected $table = 't_pesanan_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'jumlah', 'total'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'm_menu_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 't_pesanan_id');
    }
}
