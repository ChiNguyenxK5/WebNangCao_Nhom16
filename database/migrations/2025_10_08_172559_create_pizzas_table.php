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
            Schema::create('pizzas', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->string('image_url')->nullable();
                $table->string('base')->nullable();      // đế bánh
                $table->string('topping')->nullable();   // topping
                $table->string('sauce')->nullable();     // sốt
                $table->string('type')->nullable();
                $table->string('size')->nullable();
                $table->boolean('available')->default(true);   // loại pizza (hải sản, bò, v.v.)
                $table->timestamps();
            });
        }


        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pizzas');
        }
    };