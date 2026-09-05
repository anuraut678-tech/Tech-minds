<?php
$pageTitle = "SIF Safety | Home";
include "includes/header.php";
?>
<section class="hero">
    <div class="hero-copy">
        <h1>Make Every Workplace<br><span>Safer</span></h1>
        <p>Report near-misses, identify hazards and prevent incidents with AI-powered safety analysis.</p>
        <div class="hero-actions">
            <a class="btn primary" href="report.php">☷ &nbsp; Report a Near-Miss</a>
            <a class="btn outline" href="dashboard.php">▥ &nbsp; View Dashboard</a>
        </div>
    </div>
    <div class="hero-art">
        <div class="helmet">⛑</div>
        <div class="clipboard">
            <b>SAFETY REPORT</b>
            <p>✓ ━━━━━</p>
            <p>✓ ━━━━━</p>
            <p>✓ ━━━━━</p>
            <p>✓ ━━━━━</p>
        </div>
        <div class="shield">✓</div>
    </div>
</section>

<section class="section">
    <h2>How It Works</h2>
    <div class="steps">
        <div class="step"><div class="circle green">☷</div><b>1. Report</b><p>Submit safety / near-miss report</p></div>
        <div class="arrow">→</div>
        <div class="step"><div class="circle blue">◉</div><b>2. AI Analysis</b><p>Gemini AI extracts key information</p></div>
        <div class="arrow">→</div>
        <div class="step"><div class="circle purple">▥</div><b>3. Risk Analysis</b><p>Identify risks and analyze barriers</p></div>
        <div class="arrow">→</div>
        <div class="step"><div class="circle red">⬡</div><b>4. Risk Prioritization</b><p>Prioritize risks and find root causes</p></div>
        <div class="arrow">→</div>
        <div class="step"><div class="circle green">✓</div><b>5. Prevention</b><p>Recommend actions and interventions</p></div>
    </div>
</section>

<section class="two-col section">
    <div class="panel">
        <h2>AI Analysis Covers</h2>
        <div class="cards">
            <div class="mini red-bg"><b>⚠ Hazard</b><span>Identify the type and severity of hazard</span></div>
            <div class="mini yellow-bg"><b>⚙ Activity</b><span>Understand what activity was being performed</span></div>
            <div class="mini green-bg"><b>● Location</b><span>Identify where the event occurred</span></div>
            <div class="mini blue-bg"><b>♢ SIF Potential</b><span>Determine potential for serious injury or fatality</span></div>
            <div class="mini purple-bg"><b>♥ Life-Saving Rule</b><span>Connect the event with applicable rules</span></div>
        </div>
    </div>
    <div class="panel">
        <h2>Risk Insights</h2>
        <div class="insights">
            <div><b>❓ WHY?</b><span>Understand the root cause</span></div>
            <div><b>✓ PREVENT IT</b><span>Get preventive measures</span></div>
            <div><b>▥ EXPLAIN RISK</b><span>Understand risk level and impact</span></div>
            <div><b>⚒ INTERVENTION</b><span>Recommended actions</span></div>
        </div>
    </div>
</section>

<section class="stats">
    <div class="stats-intro"><div class="big-icon">▣</div><div><h3>SIF Dashboard</h3><p>Monitor trends, recurring risks and safety performance in one place.</p><a href="dashboard.php" class="small-btn">Go to Dashboard</a></div></div>
    <div class="stat"><b>248</b><span>Total Near-Misses</span><small>↑ 12% this month</small></div>
    <div class="stat"><b>32</b><span>High Risks</span><small>8 require action</small></div>
    <div class="stat"><b>186</b><span>Actions Completed</span><small>75% completion rate</small></div>
    <div class="stat"><b>91%</b><span>Safety Score</span><small>↑ 5% improvement</small></div>
</section>
<?php include "includes/footer.php"; ?>
