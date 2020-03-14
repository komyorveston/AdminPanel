<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /***
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->string('description', 255)->default(NULL)->nullable();
            $table->text('short_description')->default(NULL)->nullable();
            $table->string('meta_desc', 255)->default(NULL)->nullable();
            $table->string('meta_tags', 255)->default(NULL)->nullable();
            $table->enum('status',['0','1'])->default(1);
            $table->string('img',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
