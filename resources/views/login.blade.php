<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zopify-Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=El+Messiri:wght@700&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'El Messiri', sans-serif;
        }

        body {
            background: #031323;
            overflow: hidden;
        }

        .fas {
            width: 32px;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .box {
            position: relative;
        }

        .square {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            animation: square 10s linear infinite;
        }

        @keyframes square {

            0%,
            100% {
                transform: translateY(-20px);
            }

            50% {
                transform: translateY(20px);
            }
        }

        .square:nth-child(1) {
            width: 100px;
            height: 100px;
            top: -15px;
            right: -45px;
        }

        .square:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 105px;
            left: -125px;
            z-index: 2;
        }

        .square:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 85px;
            right: -45px;
            z-index: 2;
        }

        .square:nth-child(4) {
            width: 50px;
            height: 50px;
            bottom: 35px;
            left: -95px;
        }

        .square:nth-child(5) {
            width: 50px;
            height: 50px;
            top: -15px;
            left: -25px;
        }

        .square:nth-child(6) {
            width: 85px;
            height: 85px;
            top: 165px;
            right: -155px;
            z-index: 2;
        }

        .container {
            position: relative;
            padding: 50px;
            width: 260px;
            min-height: 380px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
        }

        .container::after {
            content: '';
            position: absolute;
            top: 5px;
            right: 5px;
            bottom: 5px;
            left: 5px;
            border-radius: 5px;
            pointer-events: none;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 2%);
        }

        .form {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .form h2 {
            color: #fff;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-align: center;
        }

        .inputBx {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .inputBx input {
            width: 80%;
            outline: none;
            border: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 10px;
            padding-left: 40px;
            border-radius: 15px;
            color: #fff;
            font-size: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .password-control {
            position: absolute;
            top: 11px;
            right: 10px;
            display: inline-block;
            width: 20px;
            height: 20px;
            background: url(https://snipp.ru/demo/495/view.svg) 0 0 no-repeat;
            transition: 0.5s;
        }

        .password-control.view {
            background: url(https://snipp.ru/demo/495/no-view.svg) 0 0 no-repeat;
        }

        .inputBx .fas {
            position: absolute;
            top: 13px;
            left: 13px;
            color: #fff;
        }

        .inputBx input[type="submit"] {
            background: #fff;
            color: #111;
            max-width: 100px;
            padding: 8px 10px;
            box-shadow: none;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 1.5s;
        }

        .inputBx input[type="submit"]:hover {
            background: linear-gradient(115deg, rgba(0, 0, 0, 0.10), rgba(255, 255, 255, 0.25));
            color: #fff;
            transition: .5s;
        }

        .inputBx input::placeholder {
            color: #fff;
        }

        .inputBx span {
            position: absolute;
            left: 30px;
            padding: 10px;
            display: inline-block;
            color: #fff;
            transition: .5s;
            pointer-events: none;
        }

        .inputBx input:focus~span,
        .inputBx input:valid~span {
            transform: translateX(-30px) translateY(-25px);
            font-size: 12px;
        }

        .form p {
            color: #fff;
            font-size: 15px;
            margin-top: 5px;
            text-align: center;
        }

        .form p a {
            color: #fff;
            text-decoration: none;
        }

        .form p a:hover {
            background-color: #000;
            background-image: linear-gradient(to right, #434343 0%, black 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .remember {
            display: inline-block;
            color: #fff;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <section>
        <div class="box">
            <div class="square" style="--i:0;"></div>
            <div class="square" style="--i:1;"></div>
            <div class="square" style="--i:2;"></div>
            <div class="square" style="--i:3;"></div>
            <div class="square" style="--i:4;"></div>
            <div class="square" style="--i:5;"></div>

            <div class="container">
                <div class="form" id="form-box">
                    <h2 id="form-title">LOGIN</h2>

                    <form id="login-form" action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="inputBx">
                            <input type="email" name="email" placeholder="Email" required>
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="inputBx password">
                            <input id="password-input" type="password" name="password" placeholder="Password" required>
                            <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                            <i class="fas fa-key"></i>
                        </div>
                        <label class="remember"><input type="checkbox"> Remember me</label>
                        <div class="inputBx">
                            <input type="submit" value="Log in">
                        </div>
                        <p>Forgot password? <a href="#">Click Here</a></p>
                        <p>Don't have an account? <a href="#" onclick="toggleForm('register')">Sign up</a></p>
                    </form>

                    <form id="register-form" action="{{ route('adminregister.store') }}" method="POST"
                        style="display: none;" enctype="multipart/form-data">
                        @csrf
                        <div class="inputBx">
                            <input type="text" name="name" placeholder="Name" required>
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="inputBx">
                            <input type="email" name="email" placeholder="Email" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="inputBx">
                            <input type="phone" name="phone" placeholder="phone" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="inputBx">
                            <input type="password" name="password" placeholder="Password" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="inputBx">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="inputBx">
                            <input type="file" name="image" placeholder="image" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="inputBx">
                            <input type="submit" value="Register">
                        </div>
                        <p>Already have an account? <a href="#" onclick="toggleForm('login')">Log in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function show_hide_password(target) {
            var input = document.getElementById('password-input');
            if (input.getAttribute('type') == 'password') {
                target.classList.add('view');
                input.setAttribute('type', 'text');
            } else {
                target.classList.remove('view');
                input.setAttribute('type', 'password');
            }
            return false;
        }



        function toggleForm(type) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const title = document.getElementById('form-title');

            if (type === 'register') {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                title.innerText = 'REGISTER';
            } else {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
                title.innerText = 'LOGIN';
            }
        }
    </script>

    </script>
</body>

</html>
