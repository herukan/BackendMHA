<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asassment extends Model
{
    protected $fillable = ['kab', 'kec','alamat','long','lot','nama','sektor','kewenangan','luas','harga','pondasi_l','pondasi_m','pondasi_h','pondasi_t','kolom_l','kolom_m','kolom_h','kolom_t','atap_t','langit_l','langit_m','dinding_m','dinding_h','dinding_t','lantai_l','lantai_t'];
}
