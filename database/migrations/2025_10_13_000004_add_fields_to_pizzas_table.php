<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            if (!Schema::hasColumn('pizzas', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('pizzas', 'ingredients')) {
                $table->text('ingredients')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            if (Schema::hasColumn('pizzas', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('pizzas', 'ingredients')) {
                $table->dropColumn('ingredients');
            }
        });
    }
};
