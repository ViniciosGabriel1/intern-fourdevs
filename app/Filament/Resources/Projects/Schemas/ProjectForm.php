<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Resources\Credentials\Schemas\CredentialForm;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Seção de Dados: Na v4, usamos Section::make() do namespace Forms
                ComponentsSection::make('Dados do Projeto')
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->label('Nome do Projeto'),

                        Select::make('status')
                            ->options([
                                'ativo' => 'Ativo',
                                'inativo' => 'Inativo',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                ComponentsSection::make('Credenciais')
                    ->schema([
                        Repeater::make('credentials')
                            ->relationship('credentials')
                            ->schema(CredentialForm::getFields())
                            ->grid(2)
                            ->addActionLabel('Adicionar Credencial')
                            ->collapsible()
                            // Na v4, o deleteAction precisa ser explicitamente configurado para persistência
                            ->deleteAction(
                                fn(ActionsAction $action) => $action
                                    ->requiresConfirmation()
                                    ->modalHeading('Excluir Credencial')
                                    ->modalDescription('Deseja apagar permanentemente este acesso?')
                                    ->action(function (array $arguments, Repeater $component): void {
                                        // 1. Obtemos a chave (ID) do item que foi clicado
                                        $itemKey = $arguments['item'];

                                        // 2. Buscamos o registro no banco através do relacionamento do Repeater
                                        // Isso garante que estamos deletando a Credencial, não o Projeto.
                                        $record = $component->getRelationship()->find($itemKey);

                                        if ($record) {
                                            $record->delete(); // Executa o DELETE físico (ou soft delete)
                                        }

                                        // 3. Na v4, para remover o item da tela após o delete manual:
                                        $state = $component->getState();
                                        unset($state[$itemKey]);
                                        $component->state($state);

                                        // Opcional: Notificação de sucesso
                                        \Filament\Notifications\Notification::make()
                                            ->title('Credencial excluída com sucesso')
                                            ->success()
                                            ->send();
                                    })
                            )
                    ]),
            ])
            ->columns(1);
    }
}
