<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components as Form;
use Filament\Schemas\Components as Components;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\Section::make('Content')
                    ->schema([
                        Form\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),

                        Form\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Form\RichEditor::make('content')
                            ->required()
                            ->fileAttachmentsDirectory('posts/attachments')
                            ->columnSpanFull(),

                        Form\Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Components\Section::make('Featured Image')
                    ->schema([
                        Form\FileUpload::make('featured_image')
                            ->label('')
                            ->image()
                            ->directory('posts/featured-images')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Components\Section::make('Publishing')
                    ->schema([
                        Form\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->default(now()),

                        Form\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(2),

                Components\Section::make('SEO')
                    ->schema([
                        Form\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255),

                        Form\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
