<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Nova Permissão')
                    ->description('Use o padrão entidade.acao (ex: projects.create)')
                    ->schema([
                        TextInput::make('name')
                            ->label('Identificador da Permissão')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('entidade.acao'),
                    ]),
            ]);
    }
}
