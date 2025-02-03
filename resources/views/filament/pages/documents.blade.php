<x-filament-panels::page>
    <style>
        .container {
            max-width: 400px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        a.test {
            color: #007BFF;
            text-decoration: none;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>
    @if (auth()->user()->isClient())

        {{-- @if (auth()->user()?->terms_condition) --}}

        @if (auth()->user()->documents->first()?->status === 'rejected')
            <div class="container">
                <h1></h1>
                <p style="color: red">Your ID has been rejected. It may be a blurred or unidentified image. Please
                    re-upload it.</p>
                <p style="font-size: 12px;">{{ auth()->user()->documents->first()->reason }}</p>
            </div>
        @endif


        {{ $this->form }}
        <div class="text-left">
            @if (auth()->user()->documents->first()?->status === 'rejected')
                <x-filament::button wire:click="submit" class="align-right">
                    Submit
                </x-filament::button>
            @endif
            @if (!auth()->user()->documents->count() > 0)
                <x-filament::button wire:click="submit" class="align-right">
                    Submit
                </x-filament::button>
            @endif
        </div>
        {{-- @else
            <div class="container">
                <h1>Privacy Policy and Terms</h1>
                <p>By using this service, you agree to upload a valid government-issued ID (front and back) as part of
                    our
                    verification process. Please review our <a class="test" href="#">Privacy Policy</a> and <a
                        class="test" href="#">Terms &
                        Conditions</a> carefully before proceeding.</p>
                <div class="buttons">
                    <x-filament::modal>
                        <x-slot name="trigger">
                            <x-filament::button>
                                Accept
                            </x-filament::button>
                        </x-slot>


                        <x-slot name="heading">
                            Are you sure you want to accept the terms and conditions?
                        </x-slot>

                        <x-filament::button wire:click="accept" class="align-right">
                            Confirm
                        </x-filament::button>
                    </x-filament::modal>
                </div>
            </div>
        @endif --}}

    @endif

    @if (auth()->user()->isStaff())
        {{ $this->table }}
    @endif

    <x-filament-actions::modals />
</x-filament-panels::page>
