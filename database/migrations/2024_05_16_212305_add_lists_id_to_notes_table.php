<?php

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
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedBigInteger('lists_id')->nullable(); // Optional nullable, wenn nicht jede Note eine Liste haben muss
            $table->foreign('lists_id')->references('id')->on('lists')->onDelete('set null'); // ForeignKey Constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['lists_id']);
            $table->dropColumn('lists_id');
        });
    }
};
