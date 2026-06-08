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
        Schema::table('livres', function (Blueprint $table) {
            $table->integer('duration_borrow')->default(14)->after('nombre_exemplaires'); // duration in days
            $table->string('image')->nullable()->after('duration_borrow'); // cover image path/URL
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image_profile')->nullable()->after('email'); // profile image path/URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livres', function (Blueprint $table) {
            $table->dropColumn(['duration_borrow', 'image']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_profile');
        });
    }
};
