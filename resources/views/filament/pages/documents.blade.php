<x-filament-panels::page>

    @if (auth()->user()->isClient())
        {{ $this->form }}
        <div class="text-left">
            @if (!auth()->user()->documents->count() > 0)
                <x-filament::button wire:click="submit" class="align-right">
                    Submit
                </x-filament::button>
            @endif
        </div>
    @endif

    @if (auth()->user()->isStaff())
        {{ $this->table }}
    @endif
</x-filament-panels::page>
