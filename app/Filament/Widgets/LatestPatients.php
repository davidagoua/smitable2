<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestPatients extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Patient::query()->limit(100);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('code_patient')
        ];
    }
}
