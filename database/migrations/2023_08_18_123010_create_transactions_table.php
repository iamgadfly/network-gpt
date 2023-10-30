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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_request_id')->nullable();
            //            $table->foreignId('user_request_id')
            //                ->constrained('user_requests')
            //                ->onDelete('cascade')->nullOnDelete();

            $table->unsignedFloat('amount');
            $table->enum('type', ['deposit', 'withdrawal']
            ); // тип транзакции пополение или снятие
            $table->enum('status', ['created', 'processing', 'completed'])
                ->default('created');
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
        Schema::dropIfExists('transactions');
    }

};
