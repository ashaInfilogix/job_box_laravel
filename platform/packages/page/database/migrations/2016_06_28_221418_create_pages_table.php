<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('college_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->after('id')->constrained('companies')->onDelete('cascade');
            $table->string('name', 120);
            $table->longText('content')->nullable();
            $table->foreignId('user_id')->index()->nullable();
            $table->string('image')->nullable();
            $table->string('template', 60)->nullable();
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
