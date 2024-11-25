<x-filament-panels::page>
    <div x-data="{ showButtons: true, showAdviceForm: false, showNotarizeForm: false }" class="w-full flex flex-col items-center gap-4">
        <template x-if="showButtons">
            <div class="w-full flex flex-col items-center gap-4 bg-white p-6 rounded-xl border">
                <span class="font-bold text-3xl">Purpose</span>
                <div class="w-full flex justify-center space-x-4 gap-3" style="margin-bottom: 16px">
                    <x-filament::button icon="heroicon-o-arrow-right-start-on-rectangle" style="width: 300px"
                        @click="showButtons = false; showAdviceForm = true">
                        Advice
                    </x-filament::button>

                    <x-filament::button icon="heroicon-o-document-text" style="width: 300px"
                        @click="showButtons = false; showNotarizeForm = true">
                        Notarize
                    </x-filament::button>
                </div>
            </div>
        </template>

        <!-- Advice Form -->
        <template x-if="showAdviceForm">
            <div class="w-full">
                {{ $this->adviceForm }}
            </div>
        </template>

        <!-- Notarize Form -->
        <template x-if="showNotarizeForm">
            <div class="w-full">
                {{ $this->notarizeForm }}
            </div>
        </template>
    </div>

    <x-filament::modal id="preview-advice" width="5xl">
        <x-slot name="heading">
            Preview Informations
        </x-slot>
        {{ $this->previewAdviceForm }}
        <x-slot name="footer">
            <x-filament::button wire:click.prevent="saveAdviceForm">
                Save
            </x-filament::button>
            <button> </button>
        </x-slot>
    </x-filament::modal>

    <x-filament::modal id="preview-notarize" width="5xl">
        <x-slot name="heading">
            Preview Informations
        </x-slot>
        {{ $this->previewNotarizeForm }}
        <x-slot name="footer">
            <x-filament::button wire:click.prevent="saveNotarizeForm">
                Save
            </x-filament::button>
            <button> </button>
        </x-slot>
    </x-filament::modal>
</x-filament-panels::page>
