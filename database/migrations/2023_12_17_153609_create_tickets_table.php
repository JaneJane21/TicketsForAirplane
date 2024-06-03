<?php

use App\Models\Flight;
use App\Models\SeatInPlane;
use App\Models\User;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->nullable();
            $table->foreignIdFor(SeatInPlane::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Flight::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('fio');
            $table->date('birthday');
            $table->string('passport_data')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('status')->default('бронь');
            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
