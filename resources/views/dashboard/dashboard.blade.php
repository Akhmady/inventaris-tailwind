@extends('layouts.app')

@include('components.alert-success')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    {{-- Boxes --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div id="box-admin" class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Admin</p>
                            <h2 class="text-2xl font-bold">0</h2>
                        </div>
                        <div id="box-ruangan" class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Ruangan</p>
                            <h2 class="text-2xl font-bold">0</h2>
                        </div>
                        <div id="box-aset" class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Aset</p>
                            <h2 class="text-2xl font-bold">0</h2>
                        </div>
                    </div>


                    {{-- Horizontal Chart --}}

                    <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Tipe Aset</h3>
                        <canvas id=barChart></canvas>

                    </div>
                </div>

                {{-- Pie Chart --}}

                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Kondisi Aset</h3>
                    <canvas id="pieChart"></canvas>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const response = await fetch("{{ route('dashboard.chart') }}");
            const data = await response.json();


            // Box update Data

            document.querySelector("#box-admin h2").textContent = data.boxes.adminCount;
            document.querySelector("#box-ruangan h2").textContent = data.boxes.ruanganCount;
            document.querySelector("#box-aset h2").textContent = data.boxes.asetCount;

            // Chart Horizontal

            new Chart(document.getElementById("barChart"), {
                type: "bar",
                data: {
                    labels: data.barChart.labels,
                    datasets: [{
                        label: "Jumlah",
                        data: data.barChart.data,
                        backgroundColor: "rgba(59, 130, 246, 0.7)",
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                }
            });


            // Pie Chart

            new Chart(document.getElementById("pieChart"), {
                type: "pie",
                data: {
                    labels: data.pieChart.labels,
                    datasets: [{
                        data: data.pieChart.data,
                        backgroundColor: [
                            "rgba(16, 185, 129, 0.7)",
                            "rgba(234, 179, 8, 0.7)",
                            "rgba(239, 68, 68, 0.7)",
                        ]
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        });

        setTimeout(() => {
            const alertSuccess = document.getElementById('alert-success');
            if (alertSuccess) {
                alertSuccess.classList.add('opacity-0', '-translate-y-5', 'transition', 'duration-500');
                setTimeout(() => alertSuccess.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
