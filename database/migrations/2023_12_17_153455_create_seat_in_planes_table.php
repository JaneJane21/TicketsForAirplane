<?php

use App\Models\Airplane;
use App\Models\Seat;
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
        Schema::create('seat_in_planes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status')->default('свободно');
            $table->foreignIdFor(Airplane::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Seat::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_in_planes');
    }
};
