<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('about_us');
            $table->text('terms_condition');
            $table->text('privacy_policy');
            $table->text('faq');
            $table->string('phone');
            $table->string('address');
            $table->string('email');
            $table->string('facebook');
            $table->string('youtube');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('abouts');
    }
}
