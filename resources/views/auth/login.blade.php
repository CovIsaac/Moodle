<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Login') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
                <div class="text-center">
                    <a href="{{ route('register') }}">{{ __('¿No tienes cuenta? Regístrate aquí') }}</a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    body {
    background-color: #f0f2f5;
    font-family: 'Arial', sans-serif;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.card {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 400px;
    width: 100%;
}

.card-header {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #4CAF50;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #dddddd;
    box-sizing: border-box;
}

.form-group input:focus {
    border-color: #4CAF50;
    outline: none;
}

.btn-primary {
    background-color: #4CAF50;
    color: #ffffff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    width: 100%;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #45a049;
}

.invalid-feedback {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 5px;
}

.text-center {
    text-align: center;
}

.text-center a {
    color: #4CAF50;
    text-decoration: none;
}

.text-center a:hover {
    text-decoration: underline;
}

</style>
</html>
