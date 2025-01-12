<x-filament-panels::page>
    <div>
        <div class="text-2xl">
            Welcome <span class="font-semibold">{{ auth()->user()->name }}</span> - {{ ucfirst(auth()->user()->role) }}
        </div>
        <div class="text">
            <p id="time"></p>
        </div>
    </div>
    @if (auth()->user()->isClient())
        <div id="calendar"
            class="fi-ta-ctn divide-y divide-gray-200 p-4 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        </div>
    @endif
    @if (!auth()->user()->isClient())
        <div>
            @livewire(\App\Livewire\StatsOverview::class)
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Pie Chart -->
            <div>
                <h2 class="text-2xl font-semibold">Monthly Advice/Notary Request</h2>
                <div
                    class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div style="height: 300px;">
                        <canvas id="appointmentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div>
                <h2 class="text-2xl font-semibold">Monthly Case</h2>
                <div
                    class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div style="height: 300px;">
                        <canvas id="CaseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Pie Chart -->
            <div>
                <h2 class="text-2xl font-semibold">Yearly Case</h2>
                <div
                    class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div style="height: 259px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;margin-top: 5px;">
                        <x-filament::input.wrapper style="flex: 1;">
                            <x-filament::input.select id="yearOldNew">
                                <option value="old">Old</option>
                                <option value="new">New</option>
                            </x-filament::input.select>
                        </x-filament::input.wrapper>

                        <x-filament::input.wrapper style="flex: 1;">
                            <x-filament::input.select id="typeCase">
                                <option value="Criminal">Criminal</option>
                                <option value="Administrative">Administrative</option>
                                <option value="Civil">Civil</option>
                                <option value="Appealed">Appealed</option>
                                <option value="Labor">Labor</option>
                            </x-filament::input.select>
                        </x-filament::input.wrapper>

                        <x-filament::button id='lineChartFilter'>
                            Search
                        </x-filament::button>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div>
                <h2 class="text-2xl font-semibold">Case Status Overview</h2>
                <div
                    class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div>
                        <canvas id="caseStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div style="margin-top:-10px;">
            <h2 class="text-2xl font-semibold">Yearly Case</h2>
            <div
                class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div style="height: 300px;">
                    <canvas id="lineChart"></canvas>
                </div>

                <div style="display: flex; gap: 10px; align-items: center;margin-top: 5px;">
                    <x-filament::input.wrapper style="flex: 1;">
                        <x-filament::input.select id="yearOldNew">
                            <option value="old">Old</option>
                            <option value="new">New</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper style="flex: 1;">
                        <x-filament::input.select id="typeCase">
                            <option value="Criminal">Criminal</option>
                            <option value="Administrative">Administrative</option>
                            <option value="Civil">Civil</option>
                            <option value="Appealed">Appealed</option>
                            <option value="Labor">Labor</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>

                    <x-filament::button id='lineChartFilter'>
                        Search
                    </x-filament::button>
                </div>

            </div>
        </div> --}}


        <h2 class="text-2xl font-semibold" style="margin-bottom: -30px;">Appointments</h2>
        @livewire('appointment')
    @endif
</x-filament-panels::page>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="module">
    //pie chart
    //barchart
    const appointmentData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
                label: 'Advice Requests',
                data: @json($appointmentData['advice']),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Notary Requests',
                data: @json($appointmentData['notarize']),
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    };

    // Configuration for Bar chart
    const appointmentConfig = {
        type: 'bar',
        data: appointmentData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x', // Horizontal bar chart
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        },
    };

    const myAppointmentChart = new Chart(
        document.getElementById('appointmentChart'),
        appointmentConfig
    );

    //gender
    const genderdataPie = {
        labels: ['Pending', 'Terminated', 'Resolved'],
        datasets: [{
            label: 'Status',
            data: @json($CaseStatusData),
            backgroundColor: [
                '#808080',
                '#FFFF00',
                '#90EE90',
            ],
            borderColor: [
                'black',
            ],
            borderWidth: 1
        }]
    };

    const genderconfigPie = {
        type: 'pie',
        data: genderdataPie,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    enabled: true,
                }
            }
        },
    };

    const mygenderPieChart = new Chart(
        document.getElementById('caseStatusChart'),
        genderconfigPie
    );

    //linechartcase
    const caseData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
                label: 'Criminal',
                data: @json($monthlyCase['Criminal']),
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.4
            },
            {
                label: 'Civil',
                data: @json($monthlyCase['Civil']),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.4
            },
            {
                label: 'Administrative',
                data: @json($monthlyCase['Administrative']),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            },
            {
                label: 'Appealed',
                data: @json($monthlyCase['Appealed']),
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                tension: 0.4
            },
            {
                label: 'Labor',
                data: @json($monthlyCase['Labor']),
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                tension: 0.4
            }
        ]
    };

    // Configuration for Bar chart
    const caseConfig = {
        type: 'line',
        data: caseData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Monthly Case Statistics'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        },
    };

    const myCaseChart = new Chart(
        document.getElementById('CaseChart'),
        caseConfig
    );



    //line chart
    const lineData = {
        labels: @json($years),
        datasets: [{
            label: 'Case',
            data: @json($values), // Dummy data
            backgroundColor: 'green', // Bar color
            borderColor: 'black', // Bar border color
            borderWidth: 1
        }]
    };

    // Configuration for line chart
    const lineConfig = {
        type: 'line',
        data: lineData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        },
    };

    const myLineChart = new Chart(
        document.getElementById('lineChart'),
        lineConfig
    );

    document.getElementById('lineChartFilter').addEventListener('click', function(e) {
        e.preventDefault();

        const oldNew = document.getElementById('yearOldNew').value;
        const typeCase = document.getElementById('typeCase').value;

        $.ajax({
            url: '/line-chart-filter/',
            method: 'GET',
            data: {
                "yearOldNew": oldNew,
                "typeCase": typeCase,
            },
            success: function(response) {
                myLineChart.data.datasets = [];
                myLineChart.data.labels = [];

                myLineChart.data.labels = response['years'];

                myLineChart.data.datasets.push({
                    label: 'Case',
                    data: response['values'],
                    fill: true,
                    borderWidth: 1,
                });

                myLineChart.update();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
<script>
    function startTime() {
        const today = new Date();
        document.getElementById('time').innerHTML = 'Today is ' + today;
        setTimeout(startTime, 1000);
    }
    startTime()
</script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script type="module">
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'dayGridMonth',
        selectable: true,
        events: @json($calendarData),
        eventMouseEnter: function(data) {

            let tooltipContent = `
            <div>
            <h1 > 
            <strong> EVENT INFORMATION</strong> 
            </h1>
            <div><strong>Name:</strong> <p style="padding-left: 15px"> - ${data.event.extendedProps.name} </p> </div>
            <div><strong>Attorney:</strong> <p style="padding-left: 15px"> - ${data.event.extendedProps.attorney} </p> </div>
            <div><strong>Title:</strong><br> <p style="padding-left: 15px"> - ${data.event.title} </p></div>
            <div><strong>Description:</strong><br> <p style="padding-left: 15px"> - ${data.event.extendedProps.description} </p></div>
            <div><strong>Date:</strong><br> <p style="padding-left: 15px"> - ${data.event.start} </p></div>
            </div>
            `;
            let tooltip = tippy(data.el, {
                content: tooltipContent,
                placement: "top",
                interactive: true,
                arrow: true,
                theme: "material",
                appendTo: document.body,
                allowHTML: true,
                duration: [1, 1],
                animation: "scale-extreme",
            });
        }
    });

    calendar.render();
</script>
