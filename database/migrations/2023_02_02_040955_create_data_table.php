<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companys')->onDelete('cascade');
            $table->integer('kategori_id');
            $table->integer('merek_id');
            $table->integer('type_id');
            $table->string('nopol');
            $table->string('warna');
            $table->integer('tahun');
            $table->string('pajak');
            $table->integer('harga');
            $table->integer('harga_terjual')->default(0)->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('data');
    }
    public function fotos()
    {
        return $this->hasMany(DataFoto::class);
    }
    public function biayas()
    {
        return $this->hasMany(DatBiaya::class);
    }

};
