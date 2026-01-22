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
        Schema::table('statements', function (Blueprint $table) {
            $table->date('billing_start_date')->after('due_date');
            $table->date('billing_end_date')->after('billing_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            $table->dropColumn(['billing_start_date', 'billing_end_date']);
        });
    }
};
