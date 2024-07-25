<?php
session_start();
require_once('inc/connection.php');

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM resident WHERE Rid = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['Rpassword']) {
            $_SESSION['username'] = $row['Rname'];
            $_SESSION['rid'] = $row['Rid'];
            $_SESSION['Rpic'] = $row['Rprof'];
            $_SESSION['Rcon'] = $row['Rcon'];
            header('Location: user-dash.php');
            exit();
        } else {
            $loginError = 'Error: Incorrect password.';
        }
    } else {
        $query = "SELECT * FROM hr WHERE Hid = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['Hpassword']) {
                $_SESSION['username'] = $row['Hname'];
                $_SESSION['hid'] = $row['Hid'];
                $_SESSION['Hpic'] = $row['Hprof'];
                header('Location: Management-Dashboard.php');
                exit();
            } else {
                $loginError = 'Error: Incorrect password.';
            }
        } else {
            $loginError = 'Error: NIC not found.';
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shangri-La Login</title>
    <style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('https://i.ibb.co/fGLL4nh/0069-HK-BIG.png') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            display: flex;
            width: 100%;
            max-width: 850px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .cover {
            flex: 1;
            background: url('https://i.ibb.co/0cvcrKX/0069-HK.png') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 30px;
            color: #fff;
            text-align: center;
        }
        .cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }
        .cover .text {
            position: relative;
            z-index: 1;
        }
        .cover .text-1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .cover .text-2 {
            font-size: 18px;
        }
        .form-content {
            flex: 1;
            padding: 50px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }
        .input-box {
            margin-bottom: 20px;
        }
        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .button:hover {
            background: #0056b3;
        }
        .sign-up-text {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .sign-up-text a {
            color: #007bff;
            text-decoration: none;
        }
        .toggle-form {
            display: none;
        }
        .error{
            color: red;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cover">
            <div class="text">
                <div class="text-1">Complete miles of journey with one step</div>
                <div class="text-2">Let's get started</div>
            </div>
        </div>
        <div class="form-content">
            <form id="loginForm" class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="title">Welcome Back</div>
                <div class="input-box">
                    <input type="text" name="email" placeholder="NIC" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <?php if (!empty($loginError)): ?>
                    <div class="error"><?php echo $loginError; ?></div>
                <?php endif; ?>
                <div class="input-box">
                    <button type="submit" class="button">Login</button>
                </div>
                <div class="sign-up-text">
                    <a href="#" id="showSignup">Need to register?</a>
                </div>
                <div class="sign-up-text">
                    <a href="reset-pw.html">Forgot password?</a>

                </div>
            </form>
            <form id="signupForm" class="signup-form toggle-form">
                <div class="title">Create Account</div>
                <div class="input-box">
                    <input type="text" name="Rname" placeholder="Full Name" required>
                </div>
                <div class="input-box">
                    <input type="text" name="Remail" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <input type="password" name="Rpassword" placeholder="Password" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Confirm Password" required>
                </div>
                <div class="input-box">
                    <button type="submit" class="button" name="resident_signup">Sign Up</button>
                </div>
                <div class="sign-up-text">
                    <a href="#" id="showLogin">Already have an account? Login now</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        const showSignup = document.getElementById('showSignup');
        const showLogin = document.getElementById('showLogin');

        showSignup.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('toggle-form');
            signupForm.classList.remove('toggle-form');
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            signupForm.classList.add('toggle-form');
            loginForm.classList.remove('toggle-form');
        });
    </script>
</body>
</html>
