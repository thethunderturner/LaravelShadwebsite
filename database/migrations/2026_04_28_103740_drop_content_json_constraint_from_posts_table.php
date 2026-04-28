<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `posts` DROP CONSTRAINT `content`');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `posts` ADD CONSTRAINT `content` CHECK (json_valid(`content`))');
    }
};
