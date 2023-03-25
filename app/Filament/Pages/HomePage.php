<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class HomePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.home-page';
}
