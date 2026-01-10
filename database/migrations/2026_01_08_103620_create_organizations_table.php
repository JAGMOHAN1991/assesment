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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
			$table->string(\App\Models\Organization::NAME)->nullable(false);
			$table->string(\App\Models\Organization::DOMAIN)->unique()->nullable(false);
			$table->string(\App\Models\Organization::CONTACT_EMAIL)->nullable();
			$table->enum(\App\Models\Organization::STATUS, [\App\Models\Organization::STATUS_PENDING, \App\Models\Organization::STATUS_PROCESSING, \App\Models\Organization::STATUS_COMPLETED, \App\Models\Organization::STATUS_FAILED]);
			$table->string(\App\Models\Organization::BATCH_ID)->nullable();
			$table->dateTime(\App\Models\Organization::PROCESSED_AT)->nullable();
			$table->text(\App\Models\Organization::FAILED_REASON)->nullable();
			
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
