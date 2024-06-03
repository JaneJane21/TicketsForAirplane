<?php

use App\Models\Airplane;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('city_start_id');
            $table->unsignedBigInteger('city_finish_id');
            $table->unsignedBigInteger('airport_start_id');
            $table->unsignedBigInteger('airport_finish_id');

            $table->float('overprice');
            $table->foreignIdFor(Airplane::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status')->default('доступен');
            $table->dateTime('date_start');
            $table->dateTime('date_finish');
            $table->dateTime('date_start_fact')->nullable();
            $table->dateTime('date_finish_fact')->nullable();
            $table->string('time_in_air');

            $table->foreign('airport_start_id')->references('id')->on('airports');
            $table->foreign('airport_finish_id')->references('id')->on('airports');
            $table->foreign('city_start_id')->references('id')->on('cities');
            $table->foreign('city_finish_id')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
