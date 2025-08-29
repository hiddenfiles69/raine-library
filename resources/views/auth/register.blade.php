<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
     <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>

    <section id="signup">
        <div class="left-panel">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <p> Already a Member? Sign In Now. </p>
            <a href="{{ route('login') }}">SIGN IN</a>
        </div>

        <div class="right-panel">
    <h1>Create An Account</h1>
    <form action="{{ route('register.user') }}" method="POST">
        @csrf
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder=""required>
        
            
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            
                <label for="contactnum">Contact Number</label>
                <input type="tel" id="contact" name="contactnum" placeholder="" required>
            
                <label for="name">Username</label>
                <input type="text" id="name" name="name" placeholder="" required>

                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
           
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
        <button type="submit">SIGN UP</button>
    </form>
</div>
    </section>

</body>
</html>