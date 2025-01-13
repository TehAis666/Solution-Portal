<!DOCTYPE html>
<html>

<head>
    <title>Login & Registration Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">

    <style>
        *,
        *:before,
        *:after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            border-radius: 50%;
            background-color: #f3f3f9;
            background: linear-gradient(to bottom,
                    rgba(13, 22, 75, 0.95),
                    /* Deep dark blue */
                    rgba(26, 35, 126, 0.9),
                    /* Stronger dark blue */
                    rgba(33, 64, 154, 0.85),
                    /* Mid-tone blue */
                    rgba(52, 152, 219, 0.7)
                    /* Lighter blue near the bottom */
                ),
        }

        input,
        button {
            border: none;
            background: none;
        }

        .cont {
            overflow: hidden;
            position: relative;
            width: 900px;
            height: 550px;
            background: white;
            box-shadow: 0 19px 38px rgba(0, 0, 0, 0.30), 0 15px 12px rgba(0, 0, 0, 0.22);
            border-radius: 15px;
        }

        .form {
            position: relative;
            width: 640px;
            height: 100%;
            padding: 50px 30px;
            -webkit-transition: -webkit-transform 1.2s ease-in-out;
            transition: -webkit-transform 1.2s ease-in-out;
            transition: transform 1.2s ease-in-out;
            transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
        }

        h2 {
            width: 100%;
            font-size: 30px;
            text-align: center;
            color: #3577F1;
        }

        label {
            display: block;
            width: 260px;
            margin: 25px auto 0;
            text-align: center;
        }

        label span {
            font-size: 14px;
            font-weight: 600;
            color: #505f75;
            text-transform: uppercase;
        }

        input {
            display: block;
            width: 100%;
            margin-top: 5px;
            font-size: 12px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(109, 93, 93, 0.4);
            text-align: center;
            font-family: 'Nunito', sans-serif;
        }

        input.login {
            display: block;
            width: 100%;
            margin-top: 5px;
            font-size: 16px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(109, 93, 93, 0.4);
            text-align: center;
            font-family: 'Nunito', sans-serif;
        }

        button {
            display: block;
            margin: 0 auto;
            width: 260px;
            height: 36px;
            border-radius: 30px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .submit {
            margin-top: 30px;
            margin-bottom: 30px;
            text-transform: uppercase;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
            background: #3577F1;
            transition: .5s;
        }

        .submit:hover {
            transition: .5s;
            background: #2857A0;
        }

        .forgot-pass {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #0c0101;
            cursor: pointer;
        }

        .forgot-pass:hover {
            color: red;
        }

        .social-media {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .social-media ul {
            list-style: none;
        }

        .social-media ul li {
            display: inline-block;
            cursor: pointer;
            margin: 25px 10px;
        }

        .social-media img {
            width: 20px;
            height: 20px;
        }

        .sub-cont {
            overflow: hidden;
            position: absolute;
            left: 640px;
            top: 0;
            width: 900px;
            height: 100%;
            padding-left: 260px;
            background: #fff;
            -webkit-transition: -webkit-transform 1.2s ease-in-out;
            transition: -webkit-transform 1.2s ease-in-out;
            transition: transform 1.2s ease-in-out;
        }

        .cont.s-signup .sub-cont {
            -webkit-transform: translate3d(-640px, 0, 0);
            transform: translate3d(-640px, 0, 0);
        }

        .img {
            overflow: hidden;
            z-index: 2;
            position: absolute;
            left: 0;
            top: 0;
            width: 260px;
            height: 100%;
            padding-top: 360px;
            /* background-color: #F28C28; */
        }

        .img:before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 900px;
            height: 100%;
            /* background-image: url(images/bg.jpg); */
            background-size: cover;
            transition: -webkit-transform 1.2s ease-in-out;
            transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
        }

        .img:after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #F7F7F2;
        }

        .cont.s-signup .img:before {
            -webkit-transform: translate3d(640px, 0, 0);
            transform: translate3d(640px, 0, 0);
        }

        .img-text {
            z-index: 2;
            position: absolute;
            left: 0;
            top: 50px;
            width: 100%;
            padding: 0 20px;
            text-align: center;
            color: #fff;
            -webkit-transition: -webkit-transform 1.2s ease-in-out;
            transition: -webkit-transform 1.2s ease-in-out;
            transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
            
        }

        .img-text h2 {
            margin-bottom: 10px;
            font-weight: normal;
        }

        .img-text h1 {
            color: #04045b;
        }

        .img-text p {
            font-size: 14px;
            line-height: 1.5;
            margin-top: 10px;
            color: #0d160b;
        }

        .cont.s-signup .img-text.m-up {
            -webkit-transform: translateX(520px);
            transform: translateX(520px);
        }

        .img-text.m-in {
            -webkit-transform: translateX(-520px);
            transform: translateX(-520px);
        }

        .cont.s-signup .img-text.m-in {
            -webkit-transform: translateX(0);
            transform: translateX(0);
        }


        .sign-in {
            padding-top: 65px;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }

        .cont.s-signup .sign-in {
            -webkit-transition-timing-function: ease-in-out;
            transition-timing-function: ease-in-out;
            -webkit-transition-duration: 1.2s;
            transition-duration: 1.2s;
            -webkit-transform: translate3d(640px, 0, 0);
            transform: translate3d(640px, 0, 0);
        }

        .img-btn {
            overflow: hidden;
            z-index: 2;
            position: relative;
            width: 100px;
            height: 36px;
            margin: 0 auto;
            background: transparent;
            color: #0D160B;
            text-transform: uppercase;
            font-size: 15px;
            cursor: pointer;
        }

        .img-btn:after {
            content: '';
            z-index: 2;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border: 2px solid #04045b;
            border-radius: 30px;
        }

        .img-btn span {
            position: absolute;
            left: 0;
            top: 0;
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: center;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            -webkit-transition: -webkit-transform 1.2s;
            transition: -webkit-transform 1.2s;
            transition: transform 1.2s;
            transition: transform 1.2s, -webkit-transform 1.2s;
            ;
        }

        .img-btn span.m-in {
            -webkit-transform: translateY(-72px);
            transform: translateY(-72px);
        }

        .cont.s-signup .img-btn span.m-in {
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }

        .cont.s-signup .img-btn span.m-up {
            -webkit-transform: translateY(72px);
            transform: translateY(72px);
        }

        .sign-up {
            -webkit-transform: translate3d(-900px, 0, 0);
            transform: translate3d(-900px, 0, 0);
        }

        .cont.s-signup .sign-up {
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        .dropdown {
            display: none;
            /* Hidden by default */
            position: absolute;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-height: 150px;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown li {
            padding: 7px;
            cursor: pointer;
            font-size: 14px;
            color: rgba(0, 0, 0, 0.7);
        }

        .dropdown li:hover {
            background-color: #f1f1f1;
        }

        #sectorDisplay {
            cursor: pointer;
        }

        #scopeDisplay {
            cursor: pointer;
        }

        .form.sign-up {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .form-holder {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
        }

        .form-holder label {
            display: flex;
            flex-direction: column;
            width: 48%;
            /* Adjust width to make two columns */
        }

        .form-holder .sector-selection {
            position: relative;
            width: 48%;
            text-align: center;
            font-family: 'Nunito', sans-serif;
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #505f75;
            /* Same as above for consistency */
        }

        .form-holder .sector-selection .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            display: none;
            z-index: 10;
        }

        .form-holder .sector-selection .dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .form-holder .sector-selection .dropdown ul li {
            padding: 10px;
            cursor: pointer;
        }

        .form-holder .sector-selection .dropdown ul li:hover {
            background-color: #f0f0f0;
        }

        .form-holder input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .img-text {
            text-align: center;
            margin-bottom: 20px;
        }

        .picture {
            width: 90px;
            /* Adjust as needed */
            height: auto;
            margin-bottom: 10px;
            /* Space between the image and text */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        
    </style>
</head>

<body>
    <div class="cont">
        <div class="form sign-in">
            <h2>Sign In</h2>
            <form id="logincont" action="controller/logincont.php" method="POST">

                <label>
                    <span>Email Address</span>
                    <input type="email" name="email" class="input login" placeholder="Email" required />
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" class="input login" placeholder="Password" required />
                </label>

                <button type="submit" class="submit">Login</button>
            </form>
        </div>

        <div class="sub-cont">
            <div class="img">
                <div class="img-text m-up">
                    <img src="images/logo3.png" alt="HeiTech" class="picture">
                    <h1>SOLUTION PORTAL</h1>
                    <p>New here? Sign up!</p>
                </div>
                <div class="img-text m-in">
                    <img src="images/logo3.png" alt="HeiTech" class="picture">
                    <h1>SOLUTION PORTAL</h1>
                    <p>Already sign up? Lets dive in!</p>
                </div>
                <div class="img-btn">
                    <span class="m-up">Sign Up</span>
                    <span class="m-in">Sign In</span>
                </div>
            </div>

            <div class="form sign-up">
                <h2>Sign Up</h2>
                <form id="signupcont" action="controller/signupcont.php" method="POST">
                    <div class="form-holder">
                        <div class="sector-selection">
                            <span>SECTOR</span>
                            <input type="text" name="sector" class="input" id="sectorDisplay" placeholder="Sector" readonly required />
                            <div class="dropdown">
                                <ul>
                                    <li onclick="setsector('AwanHeiTech')" data-value="AwanHeiTech">AwanHeiTech</li>
                                    <li onclick="setsector('PaduNet')" data-value="PaduNet">PaduNet</li>
                                    <li onclick="setsector('Secure-X')" data-value="Secure-X">Secure-X</li>
                                    <li onclick="setsector('i-Sentrix')" data-value="i-Sentrix">i-Sentrix</li>
                                </ul>
                            </div>
                        </div>
                        <div class="sector-selection">
                            <span>SCOPE</span>
                            <input type="text" name="scope" class="input" id="scopeDisplay" placeholder="Scope" readonly required />
                            <div class="dropdown">
                                <ul>
                                    <li onclick="setsector('Developer')" data-value="Developer">Developer</li>
                                    <li onclick="setsector('Senior Developer')" data-value="Senior Developer">Senior Developer</li>
                                    <li onclick="setsector('Tester')" data-value="Tester">Tester</li>
                                    <li onclick="setsector('Manager')" data-value="Manager">Manager</li>
                                </ul>
                            </div>
                        </div>
                        <label>
                            <span>Staff ID</span>
                            <input type="text" name="staff_id" class="input" placeholder="Staff ID" required />
                        </label>
                        <label>
                            <span>Name</span>
                            <input type="text" name="name" class="input" placeholder="Name" required />
                        </label>

                        <label>
                            <span>Email</span>
                            <input type="email" name="email" class="input" placeholder="Email" required />
                        </label>
                        <label>
                            <span>Phone Number</span>
                            <input
                                type="tel"
                                name="phone"
                                class="input"
                                placeholder="Phone Number"
                                required
                                pattern="0\d{9,11}"
                                title="Phone number must start with '0' followed by 9 to 11 digits." />
                        </label>
                        <label>
                            <span>Password</span>
                            <input type="password" name="password" class="input" placeholder="Password" required />
                        </label>
                        <label>
                            <span>Confirm Password</span>
                            <input type="password" name="confirmpassword" class="input" placeholder="Confirm Password" required />
                        </label>

                    </div>
                    <button type="submit" class="submit">Sign Up</button>
                    <p id="error" style="color: red; display: none;"></p>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.querySelector('.img-btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s-signup')
        });

        function setupDropdown(inputId, dropdownClass) {
            const inputField = document.getElementById(inputId);
            const dropdown = inputField.closest(`.${dropdownClass}`).querySelector('.dropdown');
            const items = dropdown.querySelectorAll('li');

            // Toggle dropdown visibility when input is clicked
            inputField.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', () => {
                dropdown.style.display = 'none';
            });

            // Update input value when selecting an item
            items.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.stopPropagation();
                    inputField.value = item.textContent; // Set input to the selected item
                    dropdown.style.display = 'none'; // Close the dropdown
                });
            });
        }

        // Setup dropdown functionality for both sector and scope
        setupDropdown('sectorDisplay', 'sector-selection');
        setupDropdown('scopeDisplay', 'sector-selection');
    </script>
</body>

</html>