<?php

namespace App\Filament\Pages\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;

use Filament\Pages\Page;

class RegisterPage extends BaseRegister 
{
    // protected static string $view = 'filament.pages.auth.register-page'; // Tambahkan ini

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getRoleFormComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->options([
                'mahasiswa' => 'Mahasiswa',
                'konselor' => 'Konselor',
            ])
            ->default('mahasiswa')
            ->required();
    }
}
