<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// --- DATA QUERIES ---

// 1. KPI Cards
$total_rsvp = $conn->query("SELECT COUNT(*) as count FROM rsvp")->fetch_assoc()['count'];
$total_attending = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'Yes'")->fetch_assoc()['count'];
$total_not_attending = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'No'")->fetch_assoc()['count'];
$total_pax = $conn->query("SELECT SUM(pax) as total FROM rsvp WHERE attendance = 'Yes'")->fetch_assoc()['total'] ?? 0;

// 2. RSVP Trend (Line Chart) - Daily RSVPs
$trend_query = "SELECT DATE_FORMAT(submitted_at, '%Y-%m-%d') as rsvp_date, COUNT(*) as count 
                FROM rsvp 
                GROUP BY DATE_FORMAT(submitted_at, '%Y-%m-%d') 
                ORDER BY rsvp_date ASC LIMIT 14";
$trend_res = $conn->query($trend_query);
$trend_dates = [];
$trend_counts = [];
while ($row = $trend_res->fetch_assoc()) {
    $trend_dates[] = date('d M', strtotime($row['rsvp_date']));
    $trend_counts[] = $row['count'];
}

// 3. Pax Distribution (Bar Chart)
$pax_query = "SELECT pax, COUNT(*) as count FROM rsvp WHERE attendance = 'Yes' GROUP BY pax ORDER BY pax ASC";
$pax_res = $conn->query($pax_query);
$pax_labels = [];
$pax_values = [];
while ($row = $pax_res->fetch_assoc()) {
    $pax_labels[] = $row['pax'] . ' Pax';
    $pax_values[] = $row['count'];
}

// 4. Guest Type Analysis (Solo vs Couple vs Family)
$solo = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'Yes' AND pax = 1")->fetch_assoc()['count'];
$couple = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'Yes' AND pax = 2")->fetch_assoc()['count'];
$family = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'Yes' AND pax > 2")->fetch_assoc()['count'];

?>

<style>
    .content-wrapper {
        background-color: #f4f6f9;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: none;
        margin-bottom: 2rem;
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-3px);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.2rem 1.5rem;
    }

    .card-title {
        font-weight: 700;
        color: #495057;
        font-size: 1.1rem;
    }

    /* Custom KPI Boxes */
    .kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .kpi-card h3 {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0;
        color: #333;
    }

    .kpi-card p {
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        margin-bottom: 0;
    }

    .kpi-card .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.1;
        transform: rotate(-15deg);
    }

    .border-left-primary {
        border-left: 5px solid #007bff;
    }

    .border-left-success {
        border-left: 5px solid #28a745;
    }

    .border-left-danger {
        border-left: 5px solid #dc3545;
    }

    .border-left-warning {
        border-left: 5px solid #ffc107;
    }

    .chart-container {
        height: 350px;
        width: 100%;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-weight: 800; color: #333;">Wedding Analytics</h1>
                    <p class="text-muted">Real-time insights and guest statistics.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Print button removed -->
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- KPI Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="kpi-card border-left-primary">
                        <div class="inner">
                            <h3><?php echo $total_rsvp; ?></h3>
                            <p>Total Responses</p>
                        </div>
                        <i class="fas fa-envelope icon-bg text-primary"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="kpi-card border-left-success">
                        <div class="inner">
                            <h3><?php echo $total_attending; ?></h3>
                            <p>Confirmed Coming</p>
                        </div>
                        <i class="fas fa-check-circle icon-bg text-success"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="kpi-card border-left-danger">
                        <div class="inner">
                            <h3><?php echo $total_not_attending; ?></h3>
                            <p>Declined</p>
                        </div>
                        <i class="fas fa-times-circle icon-bg text-danger"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="kpi-card border-left-warning">
                        <div class="inner">
                            <h3><?php echo $total_pax; ?></h3>
                            <p>Total Guests (Pax)</p>
                        </div>
                        <i class="fas fa-users icon-bg text-warning"></i>
                    </div>
                </div>
            </div>

            <!-- ROW 1: Trend & Donut -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title"><i class="fas fa-chart-area mr-2"></i> RSVP Timeline</h3>
                        </div>
                        <div class="card-body">
                            <div id="trendChart" class="chart-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i> Attendance Ratio</h3>
                        </div>
                        <div class="card-body">
                            <div id="attendanceChart" class="chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2: Guest Types & Pax Distribution -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-friends mr-2"></i> Guest Groups</h3>
                        </div>
                        <div class="card-body">
                            <div id="guestTypeChart" class="chart-container"></div>
                            <div class="mt-3 text-center small text-muted">
                                * Solo (1), Couple (2), Family (3+)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i> Pax Distribution</h3>
                        </div>
                        <div class="card-body">
                            <div id="paxChart" class="chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 3: Recent Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Latest Submissions</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                        <th>Pax Detail</th>
                                        <th>Message</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $latest = $conn->query("SELECT * FROM rsvp ORDER BY submitted_at DESC LIMIT 5");
                                    while ($row = $latest->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold"><?php echo $row['name']; ?></td>
                                            <td>
                                                <?php if ($row['attendance'] == 'Yes'): ?>
                                                    <span class="badge badge-success px-3 py-2 rounded-pill">Attending</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary px-3 py-2 rounded-pill">Declined</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo ($row['pax'] > 0) ? $row['pax'] . ' Guests' : '-'; ?></td>
                                            <td class="text-muted font-italic">
                                                <?php echo substr($row['message'], 0, 50) . (strlen($row['message']) > 50 ? '...' : ''); ?>
                                            </td>
                                            <td class="text-muted small"><?php echo formatDate($row['submitted_at']); ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a href="rsvp/index.php" class="text-primary font-weight-bold">View Full Guest List <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(function () {
        // --- 1. Attendance Donut ---
        var attChart = echarts.init(document.getElementById('attendanceChart'));
        attChart.setOption({
            tooltip: { trigger: 'item' },
            legend: { bottom: 0 },
            series: [{
                name: 'Attendance',
                type: 'pie',
                radius: ['50%', '70%'],
                itemStyle: { borderRadius: 10, borderColor: '#fff', borderWidth: 2 },
                label: { show: false },
                emphasis: { label: { show: true, fontSize: 20, fontWeight: 'bold' } },
                data: [
                    { value: <?php echo $total_attending; ?>, name: 'Attending', itemStyle: { color: '#28a745' } },
                    { value: <?php echo $total_not_attending; ?>, name: 'Not Attending', itemStyle: { color: '#dc3545' } }
                ]
            }]
        });

        // --- 2. Trend Area Chart ---
        var trendChart = echarts.init(document.getElementById('trendChart'));
        trendChart.setOption({
            tooltip: { trigger: 'axis' },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'category', boundaryGap: false, data: <?php echo json_encode($trend_dates); ?> },
            yAxis: { type: 'value' },
            series: [{
                name: 'RSVPs', type: 'line', smooth: true,
                lineStyle: { width: 3, color: '#007bff' },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: 'rgba(0,123,255,0.5)' },
                        { offset: 1, color: 'rgba(0,123,255,0.01)' }
                    ])
                },
                data: <?php echo json_encode($trend_counts); ?>
            }]
        });

        // --- 3. Pax Bar Chart ---
        var paxChart = echarts.init(document.getElementById('paxChart'));
        paxChart.setOption({
            tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'category', data: <?php echo json_encode($pax_labels); ?> },
            yAxis: { type: 'value' },
            series: [{
                data: <?php echo json_encode($pax_values); ?>,
                type: 'bar',
                showBackground: true,
                backgroundStyle: { color: 'rgba(180, 180, 180, 0.2)' },
                itemStyle: { color: '#17a2b8', borderRadius: [5, 5, 0, 0] }
            }]
        });

        // --- 4. Guest Type Pie Chart ---
        var guestTypeChart = echarts.init(document.getElementById('guestTypeChart'));
        guestTypeChart.setOption({
            tooltip: { trigger: 'item' },
            series: [{
                name: 'Group Type',
                type: 'pie',
                radius: '60%',
                data: [
                    { value: <?php echo $solo; ?>, name: 'Solo', itemStyle: { color: '#6610f2' } },
                    { value: <?php echo $couple; ?>, name: 'Couple', itemStyle: { color: '#e83e8c' } },
                    { value: <?php echo $family; ?>, name: 'Family', itemStyle: { color: '#fd7e14' } }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        // Responsive Resize
        window.addEventListener('resize', function () {
            attChart.resize();
            trendChart.resize();
            paxChart.resize();
            guestTypeChart.resize();
        });
    });
</script>