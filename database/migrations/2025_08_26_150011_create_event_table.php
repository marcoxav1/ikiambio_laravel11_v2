<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->string('eventID', 100)->nullable()->primary();
            $table->string('parentEventID', 100)->nullable();
            $table->date('eventDate')->nullable();
            $table->time('eventTime')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->text('habitat')->nullable();
            $table->text('samplingProtocol')->nullable();
            $table->text('fieldNotes')->nullable();
            $table->text('locationID')->nullable();
            $table->text('eventRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
