<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsassmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asassments', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('nik');
            $table->String('kab')->nullable();
            $table->String('kec')->nullable();
            $table->String('alamat')->nullable();
            $table->String('long')->nullable();
            $table->String('lot')->nullable();
            $table->String('nama')->nullable();
            $table->String('sektor')->nullable();
            $table->String('kewenangan')->nullable();
            $table->Integer('luas')->nullable();
            $table->Integer('harga')->nullable();

            $table->String('pondasi_l')->nullable();
            $table->String('pondasi_m')->nullable();
            $table->String('pondasi_h')->nullable();
            $table->String('pondasi_t')->nullable();
            
            $table->String('kolom_l')->nullable();
            $table->String('kolom_m')->nullable();
            $table->String('kolom_h')->nullable();
            $table->String('kolom_t')->nullable();

            $table->String('atap_t')->nullable();

            $table->String('langit_l')->nullable();
            $table->String('langit_m')->nullable();

            $table->String('dinding_m')->nullable();
            $table->String('dinding_h')->nullable();
            $table->String('dinding_t')->nullable();

            $table->String('lantai_l')->nullable();
            $table->String('lantai_t')->nullable();

            $table->String('tingkat')->nullable();
            $table->String('status')->nullable();
            
            $table->String('fpondasi')->nullable();
            $table->String('fkolom')->nullable();
            $table->String('fatap')->nullable();
            $table->String('flangit')->nullable();
            $table->String('fdinding')->nullable();
            $table->String('flantai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asassments');
    }
}
