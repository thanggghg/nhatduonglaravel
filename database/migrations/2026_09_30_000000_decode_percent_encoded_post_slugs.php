<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('posts')
            ->select(['id', 'slug'])
            ->orderBy('id')
            ->each(function (object $post): void {
                if (! preg_match('/%[0-9a-f]{2}/i', $post->slug)) {
                    return;
                }

                $slug = rawurldecode($post->slug);
                if ($slug === $post->slug || DB::table('posts')->where('slug', $slug)->exists()) {
                    return;
                }

                DB::table('posts')->where('id', $post->id)->update([
                    'slug' => $slug,
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        // Decoded slugs are canonical content identifiers and should not be re-encoded.
    }
};
