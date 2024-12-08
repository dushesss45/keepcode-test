<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Внещний ключ пользователя')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->comment('Внещний ключ пользователя')->constrained('products')->onDelete('cascade');
            $table->enum('type', ['purchase', 'rental'])->comment('Статус транзакции(куплен или арендован)');
            $table->timestamp('rental_end_time')->nullable()->comment('Время окончания аренды');
            $table->string('unique_code')->nullable()->comment('UUID транзакции');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
