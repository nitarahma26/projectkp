<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCS Service - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Gradien */
        body {
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            /* Warna gradasi */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .login-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .login-body {
            padding: 30px;
            background-color: white;
        }

        .form-control {
            border-radius: 8px;
        }

        .login-btn {
            border-radius: 8px;
            padding: 10px;
        }

        .login-footer {
            padding: 20px 0;
            text-align: center;
        }

        .login-footer a {
            text-decoration: none;
            color: #007bff;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="card login-card">

                    <!-- Header -->
                    <div class="login-header">
                        <h4>Kodok - Login</h4>
                        <p class="mb-0">Silakan masuk dengan email dan password</p>
                    </div>

                    <!-- Form Body -->
                    <div class="login-body">
                        <form action="{{ url('/loginuser') }}" method="POST">
                            @csrf
                            <!-- Tampilkan Error -->
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Input Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Masukkan email" required>
                            </div>

                            <!-- Input Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Masukkan password" required>
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary login-btn">Login</button>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="login-footer">
                        <p class="small">Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
