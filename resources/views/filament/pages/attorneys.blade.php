<x-filament-panels::page>

    <div class="flex justify-between items-center gap-2 mb-2" style="margin-top: -40px;">
        <div></div>
        <div>
            <x-filament::modal width="4xl">
                <x-slot name="trigger">
                    <x-filament::button>
                        Attorney
                    </x-filament::button>
                </x-slot>
                {{ $this->form }}

                <x-slot name="footerActions">
                    <x-filament::button wire:click.prevent="add" wire:loading.attr="disabled">
                        Submit
                    </x-filament::button>
                </x-slot>
            </x-filament::modal>
        </div>
    </div>
    {{ $this->table }}
</x-filament-panels::page>
