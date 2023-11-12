<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function ($collection) {
            $collection->unique('username');
            $collection->index('email', null, null,
                [
                    'unique' => true,
                    'sparse' => true,
                    'background' => true
                ]
            );
            $collection->index('phone_number', null, null,
                [
                    'unique' => true,
                    'sparse' => true,
                    'background' => true
                ]
            );

            $collection->index(['username', 'status', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function ($collection) {
            $collection->dropIndexIfExists('username_1');
            $collection->dropIndexIfExists('email_1');
            $collection->dropIndexIfExists('phone_number_1');
            $collection->dropIndexIfExists('username_1_status_1_role_1');
        });
    }
};
