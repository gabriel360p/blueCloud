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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // $table->string('name');

            $table->string('path');

            $table->string('url');

            $table->integer('user_id');

            //guarda a extensão do arquivo
            $table->string('type');

            $table->integer('folder_id')->nullable();

            $table->text('original_name')->nullable();
            $table->text('new_name')->nullable();

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
        Schema::dropIfExists('files');
    }
};
