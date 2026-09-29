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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->change();
            $table->string('sku')->nullable()->change();
            $table->string('category')->nullable()->after('name');
            $table->text('description')->nullable()->after('category');
            $table->decimal('price', 12, 2)->change();
            $table->string('image')->nullable()->after('stock');
            $table->boolean('is_active')->default(true)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'description', 'image', 'is_active']);
        });
    }
};
