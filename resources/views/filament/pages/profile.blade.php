<x-filament-panels::page>
    {{ $this->form }}
    <div class="text-left">
        <x-filament::button wire:click="submit" class="align-right">
            Submit
        </x-filament::button>
    </div>
</x-filament-panels::page>
