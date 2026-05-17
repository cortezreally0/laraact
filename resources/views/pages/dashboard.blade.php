@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard -->
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary border-opacity-25">
                <h1 class="h2 text-white">Project Dashboard</h1>
                <h2 class="text-white fs-5">Welcome, {{ Auth::user()->name }}!</h2>
            </div>

            <!-- Stat Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card glass-card stat-card p-3 border-secondary border-opacity-25">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-secondary text-uppercase ls-1">Total Users</small>
                                <h2 class="text-white mt-2 mb-0 stat-number" id="stat-users">{{ $userCount }}</h2>
                                <span class="text-success small"><i class="bi bi-people-fill me-1"></i> Registered</span>
                            </div>
                            <div class="stat-icon-box">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card glass-card stat-card p-3 border-secondary border-opacity-25">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-secondary text-uppercase ls-1">Recipe List</small>
                                <h2 class="text-white mt-2 mb-0 stat-number" id="stat-recipes">{{ $recipeCount }}</h2>
                                <span class="text-info small"><i class="bi bi-journal-bookmark-fill me-1"></i> Entries</span>
                            </div>
                            <div class="stat-icon-box stat-icon-recipe">
                                <i class="bi bi-journal-bookmark fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card glass-card stat-card p-3 border-secondary border-opacity-25">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-secondary text-uppercase ls-1">System Status</small>
                                <h2 class="text-white mt-2 mb-0 stat-number">Online</h2>
                                <span class="text-success small"><i class="bi bi-check-circle-fill me-1"></i> Healthy</span>
                            </div>
                            <div class="stat-icon-box stat-icon-status">
                                <i class="bi bi-activity fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-3 mb-4">
                <!-- Doughnut Chart — Users vs Recipes -->
                <div class="col-lg-5">
                    <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25 chart-container">
                        <h5 class="text-white mb-1">Records Overview</h5>
                        <p class="text-secondary small mb-3">Distribution of data across tables</p>
                        <div class="chart-wrapper d-flex align-items-center justify-content-center">
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart — Monthly Registrations -->
                <div class="col-lg-7">
                    <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25 chart-container">
                        <h5 class="text-white mb-1">Monthly Registrations</h5>
                        <p class="text-secondary small mb-3">User signups over the past 6 months</p>
                        <div class="chart-wrapper">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Line Chart — Full Width -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25 chart-container">
                        <h5 class="text-white mb-1">Activity Trend</h5>
                        <p class="text-secondary small mb-3">Weekly active users over the past 8 weeks</p>
                        <div class="chart-wrapper">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Shared defaults ─────────────────────────────
    Chart.defaults.color = 'rgba(255,255,255,0.55)';
    Chart.defaults.font.family = "'Inter', -apple-system, sans-serif";
    const green  = '#00ed64';
    const cyan   = '#00edff';
    const navy   = '#001e2b';

    // ── 1. Doughnut – Users vs Recipes ──────────────
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Users', 'Recipes'],
            datasets: [{
                data: [{{ $userCount }}, {{ $recipeCount }}],
                backgroundColor: [green, cyan],
                borderColor: navy,
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true, pointStyleWidth: 12 }
                }
            }
        }
    });

    // ── 2. Bar – Monthly Registrations (placeholder) ─
    const months = ['Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'];
    const regData = [3, 7, 5, 12, 9, {{ $userCount }}];

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Registrations',
                data: regData,
                backgroundColor: (ctx) => {
                    const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(0, 237, 100, 0.7)');
                    gradient.addColorStop(1, 'rgba(0, 237, 100, 0.15)');
                    return gradient;
                },
                borderColor: green,
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.55
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5 },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // ── 3. Line – Weekly Active Users (placeholder) ──
    const weeks = ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8'];
    const weeklyData = [4, 6, 5, 8, 10, 7, 12, 11];

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: weeks,
            datasets: [{
                label: 'Active Users',
                data: weeklyData,
                borderColor: green,
                backgroundColor: (ctx) => {
                    const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 250);
                    gradient.addColorStop(0, 'rgba(0, 237, 100, 0.25)');
                    gradient.addColorStop(1, 'rgba(0, 237, 100, 0)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointBackgroundColor: green,
                pointBorderColor: navy,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 3 },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection
