<?php

namespace App\Livewire;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as LoginPage;
use Illuminate\Support\HtmlString;

class Login extends LoginPage
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->required()
            ->label(fn () => new HtmlString(
                'I agree to PAO\'s <a href="'.route('policy.index').'" target="_blank" style="text-decoration: underline;">Terms and Conditions</a>. 
                Read our <a href="'.route('policy.index').'" target="_blank" style="text-decoration: underline;">Privacy Policy</a>.'
            ));
    }

    public function authenticate(): ?LoginResponse
    {

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if ($user->status == 'inactive') {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
