<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'm_menu';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'kategori', 'harga'];

    public function pesananDetail()
    {
        return $this->hasMany(PesananDetail::class);
    }
}
