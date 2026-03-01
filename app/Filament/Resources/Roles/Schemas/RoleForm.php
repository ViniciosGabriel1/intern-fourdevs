<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // 1. Nome no topo (Largura Total)
                Section::make('Informações do Cargo')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Cargo')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),

                // 2. Gerenciamento de Acessos
                Section::make('Gerenciamento de Acessos')
                    ->schema([
                        // Para evitar quebra, usamos 1 coluna para o Grid principal
                        // e aumentamos as colunas dentro dos Fieldsets.
                        Grid::make(1)
                            ->schema([
                                Fieldset::make('Cargos')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->relationship(
                                                name: 'permissions',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: fn($query) => $query?->where('name', 'like', 'roles.%')
                                            )
                                            ->getOptionLabelFromRecordUsing(fn($record) => str($record->name)->after('.')->title())
                                            ->hiddenLabel()
                                            ->bulkToggleable()
                                            ->columns(4), // Aqui 4 colunas funcionam bem se o Fieldset for largura total
                                    ]),
                                Fieldset::make('Projetos')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->relationship(
                                                name: 'permissions',
                                                titleAttribute: 'name',
                                                // Filtra apenas o que começa com "projects." no banco
                                                modifyQueryUsing: fn($query) => $query?->where('name', 'like', 'projects.%')
                                            )
                                            ->getOptionLabelFromRecordUsing(fn($record) => str($record->name)->after('.')->title())
                                            ->hiddenLabel()
                                            ->bulkToggleable()
                                            ->columns(4), // Mantendo o padrão de 4 colunas que você aprovou
                                    ]),

                                // Fieldset::make('Pessoas')
                                //     ->schema([
                                //         CheckboxList::make('permissions')
                                //             ->relationship(
                                //                 name: 'permissions',
                                //                 titleAttribute: 'name',
                                //                 modifyQueryUsing: fn($query) => $query?->where('name', 'like', 'users.%')
                                //             )
                                //             ->getOptionLabelFromRecordUsing(fn($record) => str($record->name)->after('.')->title())
                                //             ->hiddenLabel()
                                //             ->bulkToggleable()
                                //             ->columns(4),
                                //     ]),

                                // Fieldset::make('Cargos (Teste de Stress)')
                                //     ->schema([
                                //         CheckboxList::make('roles_fake')
                                //             ->options([
                                //                 'roles.view' => 'Visualizar Todos',
                                //                 'roles.create' => 'Criar Novo',
                                //                 'roles.edit' => 'Editar',
                                //                 'roles.delete' => 'Excluir',
                                //                 'roles.assign' => 'Atribuir',
                                //                 'roles.export' => 'Exportar',
                                //                 'roles.import' => 'Importar',
                                //                 'roles.audit' => 'Auditoria',
                                //                 'roles.notify' => 'Notificar',
                                //                 'roles.history' => 'Histórico',
                                //                 'roles.restore' => 'Restaurar',
                                //                 'roles.reports' => 'Relatórios',
                                //                 'roles.clone' => 'Duplicar',
                                //             ])
                                //             ->getOptionLabelFromRecordUsing(fn($label) => str($label)->title())
                                //             ->hiddenLabel()
                                //             ->bulkToggleable()
                                //             ->columns(4), 
                                //     ]),
                            ]),
                    ]),
            ])
            ->columns(1);
    }
}
