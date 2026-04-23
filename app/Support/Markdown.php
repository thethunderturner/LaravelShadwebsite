<?php

namespace App\Support;

use Illuminate\Support\Str;

class Markdown
{
    /**
     * Render markdown to HTML and extract a table of contents from h2/h3/h4 headings.
     *
     * @return array{html: string, toc: list<array{level: int, text: string, id: string}>}
     */
    public static function renderWithToc(?string $markdown): array
    {
        if (blank($markdown)) {
            return ['html' => '', 'toc' => []];
        }

        $html = Str::markdown($markdown);

        $toc = [];
        $slugs = [];

        $html = preg_replace_callback(
            '/<h([2-4])([^>]*)>(.*?)<\/h\1>/s',
            function (array $match) use (&$toc, &$slugs): string {
                $level = (int) $match[1];
                $existingAttrs = $match[2];
                $inner = $match[3];
                $text = trim(html_entity_decode(strip_tags($inner)));

                $base = Str::slug($text) ?: 'section-'.(count($toc) + 1);
                $slug = $base;
                $n = 2;
                while (isset($slugs[$slug])) {
                    $slug = $base.'-'.$n++;
                }
                $slugs[$slug] = true;

                $toc[] = ['level' => $level, 'text' => $text, 'id' => $slug];

                return '<h'.$level.' id="'.$slug.'"'.$existingAttrs.'>'.$inner.'</h'.$level.'>';
            },
            $html,
        );

        return ['html' => $html, 'toc' => $toc];
    }
}
