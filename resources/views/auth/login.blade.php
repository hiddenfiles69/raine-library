<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <section id="login">
    <div class="left-panel"> 
        <h1>Sign In</h1>
        <form action="{{ route('login.user') }}" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="loginemail" required>
            @error('email')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            <label for="password">Password</label>
            <input type="password" id="password" name="loginpassword" required>
            @error('loginpassword')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <button type="submit">SIGN IN</button>
        </form>
    </div>

    <div class="right-panel">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <p> Not a Member Yet? Sign Up Now. </p>
        <a href="{{ route('register') }}">SIGN UP</a>
    </div>
</section>

</body>
</html>