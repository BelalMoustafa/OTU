<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
            
            if (!Schema::hasColumn('messages', 'is_starred')) {
                $table->boolean('is_starred')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'is_starred')) {
                $table->dropColumn('is_starred');
            }
            if (Schema::hasColumn('messages', 'is_read')) {
                $table->dropColumn('is_read');
            }
        });
    }
};
