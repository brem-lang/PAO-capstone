<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        {{ $this->loginAction }}
    @endif

    <x-filament-panels::form wire:submit="request">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
