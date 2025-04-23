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
        Schema::table('requests', function (Blueprint $table) {
            $table->string('type')->nullable()->after('description'); // نوع الطلب (مقابلة، إلخ)
            $table->timestamp('scheduled_time')->nullable()->after('status'); // وقت المقابلة
            $table->text('rejection_reason')->nullable()->after('scheduled_time'); // سبب الرفض
            $table->charset = 'utf8'; // تغيير الترميز إلى utf8
            $table->collation = 'utf8_unicode_ci';
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['type', 'scheduled_time', 'rejection_reason']);
        });
    }
};
