<?php

namespace App\Filament\Resources\Credentials\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;

class CredentialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('titulo')
                    ->required()
                    ->label('Título da Credencial')
                    ->placeholder('Ex: Acesso SSH Principal'),

                ComponentsGrid::make(2)->schema([
                    TextInput::make('username')
                        ->label('Usuário'),
                    
                    TextInput::make('password')
                        ->label('Senha/Chave')
                        ->password()
                        ->revealable(), // O "olhinho" para ver a senha
                ]),

                TextInput::make('url')
                    ->label('URL / IP')
                    ->placeholder('192.168.1.1 ou https://api.exemplo.com'),

                Select::make('tipo')
                    ->options([
                        'vps' => 'Servidor (VPS)',
                        'db' => 'Banco de Dados',
                        'api' => 'API / Webhook',
                        'ssh' => 'Chave SSH',
                    ])
                    ->native(false),
            ]);
    }

   public static function getFields(): array
{
    return [
        TextInput::make('titulo')->required(),
        TextInput::make('username'),
        TextInput::make('password')->password()->revealable(),
        TextInput::make('url'),
        Select::make('tipo')
            ->options([
                'vps' => 'VPS',
                'db' => 'Banco de Dados',
            ])->native(false),
    ];
}
}