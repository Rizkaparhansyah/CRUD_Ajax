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
        Schema::create('data_biayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companys')->onDelete('cascade');
            $table->foreignId('data_id')->nullable()->constrained('data')->onDelete('cascade');
            $table->string('nama');
            $table->integer('nominal');
            $table->integer('from')->default(0);
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
        Schema::dropIfExists('data_biayas');
    }
};
