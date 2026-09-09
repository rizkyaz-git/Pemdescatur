<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $keys = [
            'head_photo_path',
            'head_name',
            'head_title',
            'welcome_title',
            'welcome_content',
        ];

        // Delete photo file if exists
        $headPhoto = DB::table('settings')->where('key', 'head_photo_path')->value('value');
        if ($headPhoto && Storage::disk('public')->exists($headPhoto)) {
            Storage::disk('public')->delete($headPhoto);
        }

        DB::table('settings')->whereIn('key', $keys)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed for removed unused feature settings
    }
};
