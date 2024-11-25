<?php

namespace App\Livewire;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as RegisterPage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Register extends RegisterPage
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getContactNumberFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rules([
                Password::min(8) // Minimum length of 8 characters
                    ->mixedCase(), // Requires uppercase and lowercase letters
                'regex:/^(?=(.*\d){4,}).*$/', // Custom rule: At least 4 numeric characters
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Custom rule: At least one special character
            ])
            ->validationMessages([
                'regex' => 'The password must include at least 4 numeric characters and one special character.',
            ])
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    protected function getContactNumberFormComponent(): Component
    {
        return TextInput::make('number')
            ->tel()->telRegex('/^(0|63)\d{10}$/')
            ->label('Contact Number')
            ->required();
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = 'client';

        return $data;
    }
}
