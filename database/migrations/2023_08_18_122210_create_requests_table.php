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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->longText('resp')->nullable();

            $table->foreignId('token_id')
                ->constrained('tokens')
                ->onDelete('cascade');

            $table->foreignId('network_id')
                ->constrained('networks')
                ->onDelete('cascade');

            $table->enum('status', ['success', 'processing', 'error'])->default(
                'processing'
            );
            $table->enum('type', ['string', 'image', 'video'])->default(
                'string'
            );
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
        Schema::dropIfExists('requests');
    }

};
