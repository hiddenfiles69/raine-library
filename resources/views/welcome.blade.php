<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>


    <section id="welcome">
       <img src="{{ asset('Images/logo.png') }}" alt="Logo">
       <div class="auth-links">
            <a href="{{ route('login') }}">SIGN IN</a> 
            <div class="line"></div>
            <a href="{{ route('register') }}"> SIGN UP</a>
       </div>
    </section>
</body>
</html>