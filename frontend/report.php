<?php
$pageTitle = "Report Near-Miss | SIF Safety";
include "db.php";

$message = "";
$analysis = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $severity = trim($_POST["severity"] ?? "Medium");

    if ($title === "" || $description === "") {
        $message = "Please enter the incident title and description.";
    } else {
        $stmt = $db->prepare("INSERT INTO reports(title,description,location,severity) VALUES(?,?,?,?)");
        $stmt->execute([$title, $description, $location, $severity]);
        $message = "Near-miss report submitted successfully.";
    }
}
include "includes/header.php";
?>
<section class="form-page">
    <div class="form-head">
        <span class="eyebrow">SAFETY REPORT</span>
        <h1>Report a Near-Miss</h1>
        <p>Enter the event details. Gemini AI can analyze the report and suggest preventive actions.</p>
    </div>

    <?php if ($message): ?><div class="notice"><?= htmlspecialchars($message) ?></div><?php endif; ?>

    <form method="post" class="report-form">
        <label>Incident Title
            <input name="title" required placeholder="Example: Forklift nearly hit a pedestrian">
        </label>
        <label>Location
            <input name="location" placeholder="Example: Warehouse A">
        </label>
        <label>Severity
            <select name="severity">
                <option>Low</option>
                <option selected>Medium</option>
                <option>High</option>
                <option>Critical</option>
            </select>
        </label>
        <label>What happened?
            <textarea name="description" required rows="8" placeholder="Describe what happened, what activity was taking place, hazards noticed, and what could have caused an injury."></textarea>
        </label>
        <button class="btn primary" type="submit">Submit Report</button>
        <button class="btn gemini" type="button" id="analyzeBtn">✦ Analyze with Gemini</button>
    </form>

    <div id="aiBox" class="ai-box hidden">
        <h2>✦ Gemini Safety Analysis</h2>
        <div id="aiResult">Waiting for analysis...</div>
    </div>
</section>

<script>
document.getElementById("analyzeBtn").addEventListener("click", async () => {
    const title = document.querySelector('[name="title"]').value.trim();
    const description = document.querySelector('[name="description"]').value.trim();
    const location = document.querySelector('[name="location"]').value.trim();
    const severity = document.querySelector('[name="severity"]').value;

    if (!title || !description) {
        alert("Enter the incident title and description first.");
        return;
    }

    const box = document.getElementById("aiBox");
    const result = document.getElementById("aiResult");
    box.classList.remove("hidden");
    result.innerHTML = "Gemini is analyzing the safety report...";

    const response = await fetch("api/gemini.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({title, description, location, severity})
    });

    const data = await response.json();
    result.textContent = data.analysis || data.error || "No response received.";
});
</script>
<?php include "includes/footer.php"; ?>
