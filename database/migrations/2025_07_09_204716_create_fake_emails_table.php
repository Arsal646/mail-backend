<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakeEmailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fake_emails', function ($t) {
            $t->id();
            $t->string('from_email')->nullable();
            $t->string('to_email')->nullable();
            $t->string('subject')->nullable();
            $t->longText('body_text')->nullable();
            $t->longText('body_html')->nullable();
            $t->string('bucket')->nullable();
            $t->string('object_key')->nullable();
            $t->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_emails');
    }
}
