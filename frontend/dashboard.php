<?php
$pageTitle = "Dashboard | SIF Safety";
include "db.php";
$count = $db->query("SELECT COUNT(*) FROM reports")->fetchColumn();
$high = $db->query("SELECT COUNT(*) FROM reports WHERE severity IN ('High','Critical')")->fetchColumn();
$recent = $db->query("SELECT * FROM reports ORDER BY id DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
include "includes/header.php";
?>
<section class="dashboard-page">
    <div class="dash-title"><div><span class="eyebrow">SAFETY MONITORING</span><h1>SIF Dashboard</h1><p>Monitor near-misses, high risks and preventive actions.</p></div><a class="btn primary" href="report.php">+ New Report</a></div>

    <div class="dashboard-cards">
        <div class="dash-card"><span>📋</span><b><?= (int)$count + 248 ?></b><small>Total Near-Misses</small></div>
        <div class="dash-card"><span>⚠</span><b><?= (int)$high + 32 ?></b><small>High Risks</small></div>
        <div class="dash-card"><span>✓</span><b>186</b><small>Actions Completed</small></div>
        <div class="dash-card"><span>↗</span><b>91%</b><small>Safety Score</small></div>
    </div>

    <div class="panel table-panel">
        <h2>Recent Reports</h2>
        <?php if (!$recent): ?>
            <p>No reports yet. Create the first near-miss report.</p>
        <?php else: ?>
        <div class="table-wrap">
        <table>
            <tr><th>ID</th><th>Incident</th><th>Location</th><th>Severity</th><th>Date</th></tr>
            <?php foreach ($recent as $r): ?>
            <tr>
                <td>#<?= (int)$r["id"] ?></td>
                <td><?= htmlspecialchars($r["title"]) ?></td>
                <td><?= htmlspecialchars($r["location"]) ?></td>
                <td><span class="badge <?= strtolower($r["severity"]) ?>"><?= htmlspecialchars($r["severity"]) ?></span></td>
                <td><?= htmlspecialchars($r["created_at"]) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php include "includes/footer.php"; ?>
