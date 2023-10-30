<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_proxy_relations', function (Blueprint $table) {
            //            $table->foreignId('proxy_id')
            //                ->constrained('proxies')
            //                ->onDelete('cascade');
            //
            //            $table->foreignId('api_key_id')
            //                ->constrained('api_keys')
            //                ->onDelete('cascade');
            $table->unsignedBigInteger('proxy_id');
            $table->unsignedBigInteger('api_key_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_proxy_relations');
    }

};
