<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->integer('like_count');
            $table->timestamp('sent_at');
            $table->timestamps();
            
            $table->index('person_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_notifications');
    }
};
