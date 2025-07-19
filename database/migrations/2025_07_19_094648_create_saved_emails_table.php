<?php
// database/migrations/xxxx_xx_xx_create_saved_emails_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saved_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email_address');
            $table->string('access_token', 64)->unique();
            $table->timestamp('expires_at');
            $table->integer('email_count')->default(0);
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->timestamps();
            
            $table->index(['access_token', 'status']);
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_emails');
    }
};
