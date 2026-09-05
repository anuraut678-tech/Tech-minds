<?php
$pageTitle = "Contact | SIF Safety";
include "includes/header.php";
$sent = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") $sent = true;
?>
<section class="simple-page contact-page">
    <span class="eyebrow">GET IN TOUCH</span>
    <h1>Contact SIF Safety</h1>
    <?php if ($sent): ?><div class="notice">Thanks! Your message has been received.</div><?php endif; ?>
    <form method="post" class="contact-form">
        <input name="name" required placeholder="Your name">
        <input type="email" name="email" required placeholder="Email address">
        <textarea name="message" required rows="6" placeholder="Your message"></textarea>
        <button class="btn primary">Send Message</button>
    </form>
</section>
<?php include "includes/footer.php"; ?>
