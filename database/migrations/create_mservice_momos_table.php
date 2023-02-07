<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMserviceMomosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mservice_momos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('username', 12)->primary();
            $table->string('password',10)->nullable();
            $table->string('imei', 64);
            $table->string('rkey', 64);
            $table->string('aaid', 64);
            $table->string('token', 255);
            $table->string('secure_id', 64);
            $table->string('ohash', 64)->nullable();
            $table->string('setup_key_decrypt')->nullable();
            $table->json('response')->nullable();
            $table->string('model_id');
            $table->dateTime('login_at')->nullable();
            $table->dateTime('refresh_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references(app()->make(User::class)->getKeyName())->on(app()->make(User::class)->getTableName())
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mservice_momos');
    }
}
