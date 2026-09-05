<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "sif_safety";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $department = trim($_POST["department"]);
    $user_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($user_password !== $confirm_password) {
        die("Passwords do not match. <br><br><a href='register.html'>Go Back</a>");
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("An account with this email already exists. <br><br><a href='login.html'>Go to Login</a>");
    }

    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    $sql = $conn->prepare(
        "INSERT INTO users 
        (first_name, last_name, email, phone, department, password)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $sql->bind_param(
        "ssssss",
        $first_name,
        $last_name,
        $email,
        $phone,
        $department,
        $hashed_password
    );

    if ($sql->execute()) {

        echo "
        <html>
        <head>
        <title>Account Created</title>

        <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4faf7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 40px;
            width: 380px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(8,125,77,0.10);
        }

        .icon {
            font-size: 45px;
        }

        h1 {
            color: #087d4d;
            font-size: 25px;
        }

        p {
            color: #68756f;
            font-size: 13px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            background: #087d4d;
            color: white;
            padding: 12px 22px;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
        }

        a:hover {
            background: #066b40;
        }

        </style>

        </head>

        <body>

        <div class='box'>

            <div class='icon'>✓</div>

            <h1>Account Created!</h1>

            <p>
                Your SIF Safety account has been created successfully.
            </p>

            <a href='login.html'>
                Go to Login
            </a>

        </div>

        </body>
        </html>
        ";

    } else {

        echo "Error creating account: " . $sql->error;

    }

    $sql->close();
    $check->close();
}

$conn->close();

?>