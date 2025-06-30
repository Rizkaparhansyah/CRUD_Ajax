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
        Schema::create('data_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companys')->onDelete('cascade');
            $table->foreignId('data_id')->nullable()->constrained('data')->onDelete('cascade');
            $table->string('path'); // atau 'url' kalau kamu simpan di cloud
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
        Schema::dropIfExists('data_fotos');
    }
};
