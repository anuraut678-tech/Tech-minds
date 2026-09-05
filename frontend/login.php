<?php
$pageTitle = "Login | SIF Safety";
include "includes/header.php";
?>
<section class="login-page">
    <div class="login-card">
        <div class="brand-icon">🛡</div>
        <h1>Welcome Back</h1>
        <p>Login to your SIF Safety account.</p>
        <form>
            <input type="email" placeholder="Email address">
            <input type="password" placeholder="Password">
            <button class="btn primary" type="button" onclick="alert('Connect this form to your PHP/MySQL authentication system.')">Login</button>
        </form>
    </div>
</section>
<?php include "includes/footer.php"; ?>
