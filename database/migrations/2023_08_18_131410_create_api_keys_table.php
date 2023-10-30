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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('value');
            $table->string('url');
            $table->unsignedBigInteger('max_requests')->nullable();
            $table->unsignedBigInteger('current_requests')->default(0);
            $table->foreignId('network_id')
                ->constrained('networks')
                ->onDelete('cascade');

            $table->enum('status', ['worked', 'not_worked', 'broken'])->default(
                'worked'
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
        Schema::dropIfExists('api_keys');
    }

};
