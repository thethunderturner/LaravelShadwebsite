<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $directory = resource_path('blogs');

        foreach (File::files($directory) as $file) {
            if ($file->getExtension() !== 'mdx') {
                continue;
            }

            [$frontmatter, $content] = $this->parseMdx($file->getContents());

            if ($frontmatter === null) {
                continue;
            }

            Post::factory()->create([
                'image' => Str::after($frontmatter['heroImage'] ?? '', '/src/assets/images/'),
                'category' => $frontmatter['category'] ?? 'News',
                'description' => Str::limit($frontmatter['description'] ?? '', 250, ''),
                'pubDate' => isset($frontmatter['pubDate']) ? Carbon::parse($frontmatter['pubDate']) : now(),
                'tags' => $frontmatter['tags'] ?? [],
                'title' => Str::limit($frontmatter['title'] ?? $file->getBasename('.mdx'), 250, ''),
                'content' => $content,
            ]);
        }
    }

    /**
     * @return array{0: array<string, mixed>|null, 1: string}
     */
    private function parseMdx(string $raw): array
    {
        if (! preg_match('/\A---\s*\R(.*?)\R---\s*\R?(.*)\z/s', $raw, $matches)) {
            return [null, ''];
        }

        return [Yaml::parse($matches[1]) ?? [], trim($matches[2])];
    }
}
