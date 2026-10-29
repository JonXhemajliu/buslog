<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->cascadeOnDelete();

            $table->string('type', 20);                          // service | defect
            $table->string('title', 150);
            $table->text('description')->nullable();

            $table->date('record_date');
            $table->unsignedInteger('odometer_km')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('workshop', 150)->nullable();

            $table->string('severity', 20)->nullable();          // defect: low | medium | high | critical
            $table->string('status', 20)->default('resolved');   // open | in_progress | resolved
            $table->date('next_service_date')->nullable();       // service only
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();

            $table->index(['bus_id', 'record_date']);
            $table->index(['bus_id', 'type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_records');
    }
};