<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('actuator_states', function (Blueprint $table) {
        $table->id();
        $table->string('actuator_identity')->unique(); // 'led' or 'buzzer'
        $table->boolean('operating_state')->default(false); // true for ON, false for OFF
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actuator_states');
    }
};
