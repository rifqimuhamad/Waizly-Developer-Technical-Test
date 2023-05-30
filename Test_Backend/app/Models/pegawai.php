<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;
    protected $table = "pegawai";
    protected $fillable = ['nama', 'email', 'alamat', 'notlpn'];
    static protected function booted()
    {
        static::factory(function($pegawai) {
            return [
                'nama' => $pegawai->name,
                'email' => $pegawai->unique->safeEmail,
                'alamat' => $pegawai->address,
                'notlpn' => $pegawai->phoneNumber
            ];
        });
    }
    
}
