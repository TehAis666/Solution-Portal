<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up</title>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Fira+Sans");

        
                /* Base Styles */
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(26, 35, 126, 0.9), rgba(100, 181, 246, 0.8)), 
                        url('https://media.macphun.com/img/uploads/macphun/blog/2414/1_IlluminatingtheUrbanJungleAnIntrotoCityscapePhotographyISkylum.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            color: #ffffff;
        }

        /* Subtle texture overlay */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.1),
                rgba(255, 255, 255, 0.1) 10px,
                rgba(0, 0, 0, 0) 10px,
                rgba(0, 0, 0, 0) 20px
            );
            opacity: 0.2;
            pointer-events: none;
        }

        /* Wave Design */
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .wave-container svg {
            width: 100%;
            height: auto;
        }
        .form-structor {
            background-color: #222;
            /* Dark gray background for the form */
            border-radius: 15px;
            /* Rounded corners */
            height: 550px;
            /* Form height */
            width: 90%;
            /* Reduce width on smaller screens */
            max-width: 370px;
            /* Ensure it doesn't exceed the intended width */
            position: absolute;
            /* Position the form relative to the page */
            top: 50%;
            /* Move the form 50% down from the top */
            left: 50%;
            /* Move the form 50% from the left */
            transform: translate(-50%, -50%);
            /* Offset the position to center it */
            overflow: hidden;
            /* Hide overflow content */
        }


        .form-structor::after {
            content: '';
            opacity: .8;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-repeat: no-repeat;
            background-position: left bottom;
            background-size: 755px;
            /* background-image: url('https://apicms.thestar.com.my/uploads/images/2023/12/06/2425813.jpg'); */
            background-image: url('images/menara.jpg');
        }

        .login {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65%;
            z-index: 5;
            transition: all .3s ease;
        }

        .login.slide-up {
            top: 5%;
            transform: translate(-50%, 0%);
            transition: all .3s ease;
        }

        .login.slide-up .form-holder,
        .login.slide-up .submit-btn {
            opacity: 0;
            visibility: hidden;
        }

        .login .form-title {
            color: #fff;
            font-size: 1.8em;
            /* Initial font size (smaller) */
            text-align: center;
            cursor: pointer;
            transition: all 0.5s ease;
            /* Smooth transition */
        }

        .login .form-title span {
            color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
        }

        /* When the slide-up class is active */
        .login.slide-up .form-title {
            margin-right: 5px;
            font-size: 1em;
            /* Smaller font size when slide-up is active */
            position: absolute;
            /* Keep it positioned on top */
            top: 20px;
            /* Adjust the position */
            left: 50%;
            transform: translateX(-50%);
            /* Center horizontally */
            z-index: 10;
            /* Ensure it's clickable and on top */
            opacity: 1;
            /* Keep it visible */
            cursor: pointer;
            /* Ensure it's clickable */
            color: #000;
            /* Change color to black during transition */
        }

        .login.slide-up .form-title span {
            margin-right: 5px;
            opacity: 1;
            visibility: visible;
            /* Make the 'or' text visible again */
        }

        /* Optional styling for hover effect */
        .login .form-title:hover {
            opacity: 0.8;
        }



        .login .form-holder {
            border-radius: 15px;
            background-color: #fff;
            overflow: hidden;
            margin-top: 5px;
            opacity: 1;
            visibility: visible;
            transition: all .3s ease;
        }

        .login .input {
            border: 0;
            outline: none;
            box-shadow: none;
            display: block;
            height: 30px;
            line-height: 30px;
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
            width: 100%;
            font-size: 12px;
        }

        .login .input:last-child {
            border-bottom: 0;
        }

        .login .input::-webkit-input-placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        .login .submit-btn {
            background-color: rgba(0, 0, 0, 0.4);
            color: rgba(256, 256, 256, 0.7);
            border: 0;
            border-radius: 15px;
            display: block;
            margin: 15px auto;
            padding: 15px 45px;
            width: 100%;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            opacity: 1;
            visibility: visible;
            transition: all .3s ease;
        }

        .login .submit-btn:hover {
            transition: all .3s ease;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .singup {
            position: absolute;
            top: 20%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            z-index: 5;
            transition: all .3s ease;
        }

        .singup::before {
            content: '';
            position: absolute;
            left: 50%;
            top: -20px;
            transform: translate(-50%, 0);
            background-color: white;
            width: 200%;
            height: 250px;
            border-radius: 50%;
            z-index: 4;
            transition: all .3s ease;
        }



        .singup .center {
            position: absolute;
            top: calc(60% - 10%);
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65%;
            z-index: 5;
            transition: all .3s ease;
        }

        .singup .form-title::before {
            text-align: center;
        }

        .singup .form-title {
            color: #000;
            font-size: 1.7em;
            text-align: center;
            /* Center text */
        }

        .singup .form-title span {
            color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: all .3s ease;
        }

        .singup .form-holder {
            border-radius: 15px;
            background-color: #5edbf15e;
            border: 3px solid #eeeeee90;
            overflow: hidden;
            margin-top: 20px;
            opacity: 1;
            visibility: visible;
            transition: all .3s ease;
        }

        .singup .input {
            border: 0;
            outline: none;
            box-shadow: none;
            display: block;
            height: 30px;
            line-height: 30px;
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
            width: 100%;
            font-size: 12px;
        }

        .singup .input:last-child {
            border-bottom: 0;
        }

        .singup .input::-webkit-input-placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        .singup .submit-btn {
            background-color: #6B92A4;
            color: white;
            border: 0;
            border-radius: 15px;
            display: block;
            margin: 15px auto;
            padding: 15px 45px;
            width: 100%;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            opacity: 1;
            visibility: visible;
            transition: all .3s ease;
        }

        .singup .submit-btn:hover {
            transition: all .3s ease;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .singup.slide-up {
            top: 90%;
            transition: all .3s ease;
        }

        .singup.slide-up .center {
            top: 10%;
            transform: translate(-50%, 0%);
            transition: all .3s ease;
        }

        .singup.slide-up .form-holder,
        .singup.slide-up .submit-btn {
            opacity: 0;
            visibility: hidden;
            transition: all .3s ease;
        }

        .singup.slide-up .form-title {
            font-size: 1em;
            margin: 0;
            padding: 0;
            cursor: pointer;
            transition: all .3s ease;
        }

        .singup.slide-up .form-title span {
            margin-right: 5px;
            opacity: 1;
            visibility: visible;
            transition: all .3s ease;
        }

        /* Regular logo-container styling */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1em;
            margin-bottom: -1em;
            transition: all 0.5s ease;
            /* Smooth transition */
        }

        .logo {
            width: 80px;
            /* Adjust the logo size */
            height: auto;
            transition: all 0.5s ease;
            /* Smooth transition */
        }

        .logo-text {
            font-size: 2.3em;
            /* Adjust text size */
            color: hsl(233deg 36% 38%);
            font-weight: 600;
            transition: all 0.5s ease;
            /* Smooth transition */
        }

        /* Styling when the slide-up class is active */
        .login.slide-up .logo-container {
            flex-direction: row;
            /* Ensure the logo and text are in one line */
            justify-content: center;
            /* Center them */
        }

        .login.slide-up .logo {
            width: 40px;
            /* Shrink the logo */
        }

        .login.slide-up .logo-text {
            font-size: 1.2em;
            /* Shrink the text */
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

        
    </style>
</head>

<body>
    <img src="images/logo6.png" alt="HeiTech" class="picture">


    <div class="form-structor">
        <div class="login">
            <div class="logo-container">
                <img src="images/logo3.png" alt="Logo 2" class="logo" />
                <span class="logo-text"> Solution Portal</span>
            </div>
            <h2 class="form-title" id="login"><span>or</span>Log In</h2>
            <form id="logincont" action="controller/logincont.php" method="POST">
                <div class="form-holder">
                    <input type="email" name="email" class="input" placeholder="Email" required />
                    <input type="password" name="password" class="input" placeholder="Password" required />
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
        </div>
        <div class="singup slide-up">
            <div class="center">
                <h2 class="form-title" id="singup"><span>or</span>Sign Up</h2>
                <form id="signupcont" action="controller/signupcont.php" method="POST">
                    <div class="form-holder">
                        <input type="text" name="staff_id" class="input" placeholder="Staff ID" required />
                        <div class="sector-selection">
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
                        <input type="text" name="name" class="input" placeholder="Name" required />
                        <input type="email" name="email" class="input" placeholder="Email" required />
                        <input type="password" name="password" class="input" placeholder="Password" required />
                        <input type="password" name="confirmpassword" class="input" placeholder="Confirm Password" required />
                        <input
                            type="tel"
                            name="phone"
                            class="input"
                            placeholder="Phone Number"
                            required
                            pattern="0\d{9,11}"
                            title="Phone number must start with '0' followed by 9 to 11 digits." />
                    </div>
                    <button type="submit" class="submit-btn">Sign Up</button>
                    <p id="error" style="color: red; display: none;"></p>
                </form>

            </div>
        </div>
    </div>
</body>


<script>
    console.clear();

    const sectorDisplay = document.getElementById('sectorDisplay');
    const dropdown = document.querySelector('.dropdown');
    const sectorItems = dropdown.querySelectorAll('li');

    // Toggle dropdown visibility when input is clicked
    sectorDisplay.addEventListener('click', () => {
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && e.target !== sectorDisplay) {
            dropdown.style.display = 'none';
        }
    });

    // Update input value when selecting a sector
    sectorItems.forEach(item => {
        item.addEventListener('click', () => {
            sectorDisplay.value = item.textContent; // Set input to the selected sector
            dropdown.style.display = 'none'; // Close the dropdown
        });
    });

    const singupBtn = document.getElementById('singup');
    const loginBtn = document.getElementById('login');

    singupBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode.parentNode;
        Array.from(e.target.parentNode.parentNode.classList).find((element) => {
            if (element !== "slide-up") {
                parent.classList.add('slide-up')
            } else {
                loginBtn.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });

    loginBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode;
        Array.from(e.target.parentNode.classList).find((element) => {
            if (element !== "slide-up") {
                parent.classList.add('slide-up')
            } else {
                singupBtn.parentNode.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });
</script>



</html>