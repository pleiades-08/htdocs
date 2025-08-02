<?php 
declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    *{
    border: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
    }
    body{
    display: grid;
    align-items: center;
    width: 100vw;
    height: 100vh;
    justify-content: center;
    margin: 0;
    background-image: url('../assets/img/loginbg.png');
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
    }
    @keyframes gradientBackground {
    0% {
        background: linear-gradient(45deg, #ff7e5f, #feb47b);
    }
    50% {
        background: linear-gradient(45deg, #58bc82, #45a56b);
    }
    100% {
        background: linear-gradient(45deg, #ff7e5f, #feb47b);
    }
    }

    .login-form {
    max-width: 420px;
    width: 100%;
    padding: 40px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1.5s ease-out;
    }

    .form-heading {
    text-align: center;
    color: #333;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 25px;
    letter-spacing: 1px;
    text-transform: uppercase;
    }

    .input-group {
    position: relative;
    margin-bottom: 20px;
    }

    .input-group .label {
    position: absolute;
    top: -16px;
    left: 12px;
    font-size: 12px;
    color: #58bc82;
    font-weight: 600;
    transition: all 0.3s ease;
    opacity: 0.7;
    }

    .input-group input {
    width: 87%;
    padding: 15px 20px;
    font-size: 1rem;
    color: #333;
    background-color: #f5f5f5;
    border: 2px solid #ddd;
    border-radius: 10px;
    outline: none;
    transition: all 0.3s ease;
    }

    .input-group input:focus {
    border-color: #58bc82;
    box-shadow: 0 0 10px rgba(88, 188, 130, 0.4);
    }

    .input-group input:focus + .label {
    top: -20px;
    font-size: 11px;
    color: #58bc82;
    opacity: 1;
    }

    .forgot-password {
    text-align: right;
    margin-bottom: 20px;
    }

    .forgot-password a {
    font-size: 14px;
    color: #58bc82;
    text-decoration: none;
    transition: color 0.3s ease;
    }

    .forgot-password a:hover {
    color: #45a56b;
    }

    .submit {
    width: 100%;
    padding: 15px;
    background-color: #58bc82;
    color: #fff;
    border: none;
    border-radius: 30px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .submit:hover {
    background-color: #45a56b;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(88, 188, 130, 0.3);
    }

    .signup-link {
    text-align: center;
    font-size: 14px;
    color: #333;
    }

    .signup-link a {
    color: #58bc82;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
    }

    .signup-link a:hover {
    color: #45a56b;
    }

    @keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
    }

    @media (max-width: 480px) {
    .login-form {
        padding: 30px;
        width: 90%;
    }
    }
    .modal_overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.5);
        display: grid;
        place-items: center;
        z-index: 999;
    }

    .modal_content {
        position: relative;
        animation: fadeIn 1.5s ease-out;
    }

    .close_modal {
        position: absolute;
        top: 6px;
        right: -74px;
        background: #58bc82;
        color: white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        text-align: center;
        line-height: 28px;
        font-size: 22px;
        cursor: pointer;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: background 0.3s;
    }

    .close_modal:hover {
        background: #45a56b;
    }

</style>
</head>
<body>

    <div class="modal_overlay" id="modalOverlay">
        <div class="modal_content">
            <span class="close_modal" onclick="toggleModal()">x</span>
            <form action="actions/login-query.php" class="login-form" method="POST">  
            <div class="form-heading">Login</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="input-group">
                <label class="label" for="username">username</label>
                <input required="" placeholder="username" name="username" id="username" type="username" />
            </div>
            <div class="input-group">
                <label class="label" for="password">password</label>
                <input required="" placeholder="Enter your password" name="password" id="password" type="password" />
            </div>
            <button class="submit" name="login" type="submit">Log In</button>
            </form>
        </div>
    </div>
<button onclick="toggleModal()" style="position: fixed; top: 20px; right: 20px; padding: 10px; background: #58bc82; color: white; border: none; border-radius: 8px; cursor: pointer;">
    Login
</button>
        <div class="container-search">
            <div class="search-bar">
                <input type="text" placeholder="Search..." />
                <button type="submit">Search</button>
            </div>
        </div>
<script>
    function toggleModal() {
        const overlay = document.getElementById("modalOverlay");
        overlay.style.display = overlay.style.display === "none" ? "grid" : "none";
    }
</script>

</body>
</html>