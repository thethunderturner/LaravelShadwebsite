<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class YoutubeBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'youtube';
    }

    public static function getLabel(): string
    {
        return 'Youtube';
    }

    public static function getVideoUrl(string $url): ?string
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

        return "https://www.youtube.com/embed/{$match[1]}";
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the YouTube block')
            ->schema([
                TextInput::make('url')
                    ->required(),
                TextInput::make('caption'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.youtube.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.youtube.index', $config)->render();
    }
}
