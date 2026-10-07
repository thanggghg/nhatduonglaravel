<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RepairPostEncoding extends Command
{
    protected $signature = 'posts:repair-encoding {post : Post ID} {--layers=1 : Number of mojibake layers to reverse} {--apply : Save the repaired content}';

    protected $description = 'Repair post content that was decoded with a legacy HTML encoding';

    public function handle(): int
    {
        $post = Post::findOrFail($this->argument('post'));
        $layers = max(1, (int) $this->option('layers'));
        $content = $post->content;
        $repaired = preg_replace_callback('/[^ \t\r\n<>]+/u', function (array $matches) use ($layers): string {
            $value = $matches[0];
            for ($layer = 0; $layer < $layers && $this->looksCorrupted($value); $layer++) {
                $decoded = $this->decodeLayer($value);
                if (! mb_check_encoding($decoded, 'UTF-8')) {
                    break;
                }
                $value = $decoded;
            }

            return $value;
        }, $content);

        $this->line(mb_substr(strip_tags($repaired), 0, 600));
        $this->newLine();
        $remaining = preg_match_all('/Ã|Â|Ä|Æ|Å|áº|á»|â[\x{0080}-\x{009F}]/u', $repaired);
        $this->line('Remaining mojibake markers: '.$remaining);
        if ($remaining) {
            preg_match_all('/.{0,30}(?:Ã|Â|Ä|Æ|Å|áº|á»|â[\x{0080}-\x{009F}]).{0,30}/u', strip_tags($repaired), $matches);
            foreach (array_unique($matches[0]) as $match) {
                $this->line('  '.$match);
            }
        }

        if (! $this->option('apply')) {
            $this->warn('Dry run only. Add --apply to save this repair.');
            return self::SUCCESS;
        }

        $backup = 'backups/posts/post-'.$post->id.'-'.now()->format('Ymd-His').'.html';
        Storage::disk('local')->put($backup, $content);
        $post->update(['content' => $repaired]);

        $this->info('Post repaired. Backup: storage/app/private/'.$backup);

        return self::SUCCESS;
    }

    private function decodeLayer(string $content): string
    {
        $windows1252 = [
            0x20AC => 0x80, 0x201A => 0x82, 0x0192 => 0x83, 0x201E => 0x84,
            0x2026 => 0x85, 0x2020 => 0x86, 0x2021 => 0x87, 0x02C6 => 0x88,
            0x2030 => 0x89, 0x0160 => 0x8A, 0x2039 => 0x8B, 0x0152 => 0x8C,
            0x017D => 0x8E, 0x2018 => 0x91, 0x2019 => 0x92, 0x201C => 0x93,
            0x201D => 0x94, 0x2022 => 0x95, 0x2013 => 0x96, 0x2014 => 0x97,
            0x02DC => 0x98, 0x2122 => 0x99, 0x0161 => 0x9A, 0x203A => 0x9B,
            0x0153 => 0x9C, 0x017E => 0x9E, 0x0178 => 0x9F,
        ];
        $decoded = '';

        $previousCodepoint = null;
        foreach (preg_split('//u', $content, -1, PREG_SPLIT_NO_EMPTY) as $character) {
            $codepoint = mb_ord($character, 'UTF-8');
            if ($codepoint === 0xA0) {
                // libxml can collapse the mojibake "Â " pair into a single NBSP.
                $decoded .= $previousCodepoint === 0xC3 ? "\xA0" : "\xC2\xA0";
            } elseif ($codepoint <= 0xFF) {
                $decoded .= chr($codepoint);
            } elseif (isset($windows1252[$codepoint])) {
                $decoded .= chr($windows1252[$codepoint]);
            } else {
                $decoded .= $character;
            }
            $previousCodepoint = $codepoint;
        }

        return $decoded;
    }

    private function looksCorrupted(string $content): bool
    {
        return preg_match('/Ã|Â|Ä|Æ|Å|áº|á»|â[\x{0080}-\x{009F}]/u', $content) === 1;
    }
}
