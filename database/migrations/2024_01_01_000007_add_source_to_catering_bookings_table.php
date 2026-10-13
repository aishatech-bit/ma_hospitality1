<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catering_bookings', function (Blueprint $table) {
            $table->string('source')->default('staff')->after('status'); // staff | customer
        });
    }

    public function down(): void
    {
        Schema::table('catering_bookings', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
