<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EventSystem</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), 
                        url('https://thumbs.dreamstime.com/b/group-professionals-attending-corporate-networking-event-modern-venue-warm-lighting-blurred-background-high-418461976.jpg') center/cover no-repeat fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(15px);
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
            padding: 5px 30px;
            text-align: center;
            margin-top: -40px;
        }

        .logo-top {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 3px 8px rgba(0,0,0,0.5);
            position: absolute;
            top: 35px;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo-top i {
            margin-right: 10px;
        }

        .login-wrapper h2 {
            font-size: 2.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .login-wrapper > p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 28px;
        }

        .form-label {
            display: block;
            text-align: left;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 13px 17px;
            font-size: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.2);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 50px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.4);
        }

        .demo-box {
            margin-top: 0px;
            padding: 22px;
            background: #f1f5f9;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .demo-box strong {
            display: block;
            font-size: 1.05rem;
            color: #1e293b;
            margin-bottom: 14px;
        }

        .demo-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .demo-box li {
            padding: 11px 15px;
            background: white;
            margin-bottom: 8px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: monospace;
            font-size: 0.92rem;
            color: #4f46e5;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            border: 1px solid #e0e7ff;
        }

        .demo-box li:hover {
            background: #eef2ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.12);
            color: var(--primary);
        }

        .demo-box small {
            display: block;
            margin-top: 10px;
            color: #94a3b8;
            font-size: 0.82rem;
        }
    </style>
</head>
<body>

    <!-- <div class="logo-top">
        <i class="fas fa-calendar-check"></i> EventSystem
    </div> -->

    <div class="login-wrapper">
        <h2>Welcome</h2>
        <p>Sign in to your EventSystem account</p>

        <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?=$error?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" 
                       placeholder="Enter your email" value="<?=set_value('email')?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login" style="margin-top: -9px;">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
        </form>

        <div class="demo-box">
            <ul>
                <li onclick="document.querySelector('[name=email]').value=this.innerText">admin@example.com</li>
                <li onclick="document.querySelector('[name=email]').value=this.innerText">emp1@example.com</li>
                <li onclick="document.querySelector('[name=email]').value=this.innerText">manager@example.com</li>
                <li onclick="document.querySelector('[name=email]').value=this.innerText">director@example.com</li>
                <li onclick="document.querySelector('[name=email]').value=this.innerText">guest@example.com</li>
            </ul>
            <small>(Click any email to auto-fill)</small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.querySelector('form').addEventListener('submit', function() {
        const btn = this.querySelector('.btn-login');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Logging in...';
    });
    </script>

</body>
</html>