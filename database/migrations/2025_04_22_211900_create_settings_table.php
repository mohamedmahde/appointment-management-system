<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
            $table->charset = 'utf8'; // تغيير الترميز إلى utf8
            $table->collation = 'utf8_unicode_ci';
        });
    }
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
