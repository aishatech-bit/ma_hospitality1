<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('channel')->default('in_store')->after('customer_id'); // in_store | online
            $table->string('status')->default('completed')->after('channel'); // pending | completed | cancelled
            $table->string('customer_phone')->nullable()->after('status');
            $table->string('delivery_address')->nullable()->after('customer_phone');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['channel', 'status', 'customer_phone', 'delivery_address']);
        });
    }
};
