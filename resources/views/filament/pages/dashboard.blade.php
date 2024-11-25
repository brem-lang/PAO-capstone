<x-filament-panels::page>
    <div>
        <div class="text-2xl">
            Welcome <span class="font-semibold">{{ auth()->user()->name }}</span> - {{ ucfirst(auth()->user()->role) }}
        </div>
        <div class="text">
            <p id="time"></p>
        </div>
    </div>
    @if (!auth()->user()->isClient())
        <div>
            @livewire(\App\Livewire\StatsOverview::class)
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-4" style="display: flex; justify-content: flex-end;">
                    {{-- <x-filament::input.wrapper style="width: 40%;">
                        <x-filament::input.select @change="$wire.test($event.target.value)">
                            <option value="advice">Advice</option>
                            <option value="notarize">Notarize</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper> --}}
                </div>
                {{-- @livewire(\App\Livewire\PieChart::class) --}}

                <div
                    class="p-4 divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                    <canvas id="pieChart"></canvas>
                </div>

            </div>
            <div>
                <div class="mb-4">
                    <x-filament::input.wrapper>
                        <x-filament::input.select>
                            <option value="draft">Draft</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="published">Published</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>
                @livewire(\App\Livewire\BarChart::class)
            </div>
        </div>
        <h2 class="text-2xl font-semibold" style="margin-bottom: -30px;">Appointments</h2>
        @livewire('appointment')
    @endif
</x-filament-panels::page>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function startTime() {
        const today = new Date();
        document.getElementById('time').innerHTML = 'Today is ' + today;
        setTimeout(startTime, 1000);
    }
    startTime()
</script>
<script type="module">
    var ctx = document.getElementById('myChart').getContext('2d');
    // Create a new Chart instance
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: [300, 50, 100],
        backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
        ],
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
