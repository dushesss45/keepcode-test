<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя пользователя');
            $table->string('email')->unique()->comment('Email пользователя');
            $table->string('password')->comment('Пароль пользователя');
            $table->decimal('balance', 10, 2)->default(0)->comment('Денежный баланс пользователя');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
