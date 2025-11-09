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
    Schema::create('obats', function (Blueprint $table) {
        $table->id();
        $table->string('nama_obat');
        $table->string('kategori')->nullable();
        $table->integer('stok')->default(0);
        $table->string('satuan'); // e.g., tablet, botol, strip
        $table->decimal('harga', 10, 2)->default(0);
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
