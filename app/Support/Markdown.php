<?php

namespace App\Support;

use Illuminate\Support\Str;

class Markdown
{
    /**
     * Convert legacy MDX blog content to HTML compatible with Filament's rich editor:
     * runs markdown, rewrites legacy image paths, and converts <YoutubeEmbed /> tags
     * into the editor's custom block format so the YoutubeBlock renderer picks them up.
     */
    public static function mdxToEditorHtml(?string $mdx): string
    {
        if (blank($mdx)) {
            return '';
        }

        $processed = preg_replace_callback(
            '/<YoutubeEmbed\b([^>]*)\/?\s*>/i',
            function (array $match): string {
                $attrs = $match[1];
                preg_match('/\burl=["\']([^"\']+)["\']/i', $attrs, $url);
                preg_match('/\btitle=["\']([^"\']+)["\']/i', $attrs, $title);

                $config = ['url' => $url[1] ?? ''];

                if (! empty($title[1])) {
                    $config['caption'] = $title[1];
                }

                return '<div data-type="customBlock" data-id="youtube" data-config="'
                    .htmlspecialchars(json_encode($config), ENT_QUOTES)
                    .'"></div>';
            },
            $mdx,
        );

        $html = Str::markdown($processed);

        return preg_replace(
            '#(<img[^>]+src=["\'])/src/assets/images/#i',
            '$1/images/',
            $html,
        );
    }

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
