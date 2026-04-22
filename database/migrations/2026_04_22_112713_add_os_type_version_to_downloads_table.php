<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->string('os')->nullable()->after('file_name');
            $table->string('type')->nullable()->after('os');
            $table->string('version')->nullable()->after('type');
        });

        DB::table('downloads')->orderBy('id')->each(function ($row) {
            if (preg_match('/^(?<os>windows|linux|macos)-(?<type>qt|cli)-(?<version>.+)$/i', (string) $row->file_name, $matches)) {
                DB::table('downloads')->where('id', $row->id)->update([
                    'os' => strtolower($matches['os']),
                    'type' => strtolower($matches['type']),
                    'version' => $matches['version'],
                ]);
            }
        });

        Schema::table('downloads', function (Blueprint $table) {
            $table->string('os')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->string('version')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropColumn(['os', 'type', 'version']);
        });
    }
};
