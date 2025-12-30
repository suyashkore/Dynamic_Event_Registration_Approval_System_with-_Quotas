<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event System</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text-gray: #4b5563;
            --bg-light: #f8fafc;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Bar */
        .nav {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            margin-bottom: 40px;
        }

        .nav-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .logo i {
            margin-right: 8px;
        }

        .links {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .links a {
            text-decoration: none;
            color: var(--text-gray);
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .links a:hover {
            background-color: #eff6ff;
            color: var(--primary);
        }

        .links a.active {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }

        .links a.active:hover {
            background-color: var(--primary-dark);
        }

        .welcome-text {
            color: var(--text-gray);
            font-size: 0.95rem;
        }

        .welcome-text b {
            color: #1f2937;
        }

        .btn-logout {
            background: #dc2626;
            color: white;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Main Container */
        .container {
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 0 20px 60px 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                height: auto;
                padding: 15px 20px;
                gap: 15px;
            }

            .links {
                width: 100%;
                justify-content: center;
                gap: 12px;
            }

            .links a {
                padding: 8px 14px;
                font-size: 0.95rem;
            }

            .welcome-text {
                text-align: center;
                width: 100%;
                order: -1;
            }
        }

        @media (max-width: 480px) {
            .links {
                flex-direction: column;
                align-items: center;
            }

            .links a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div id="toaster" class="toaster"></div>

<script>
    // Toaster function to show messages
    function showToast(message, type = 'success', duration = 5000) {
        const toaster = document.getElementById('toaster');
        if (toaster) {
            toaster.textContent = message;
            toaster.className = 'toaster show ' + type;

            // Hide the toaster after the duration
            setTimeout(function() {
                toaster.className = toaster.className.replace('show', '');
            }, duration);
        }
    }

    // Check for a flash message from PHP session and display it
    <?php if ($this->session->flashdata('toast_message')): ?>
        showToast('<?= addslashes($this->session->flashdata('toast_message')); ?>', '<?= $this->session->flashdata('toast_type') ?: 'success'; ?>');
    <?php endif; ?>
</script>

<div class="nav">
    <div class="nav-content">
        <div class="logo">
            <i class="fas fa-calendar-check"></i> EventSystem
        </div>

        <div class="links">
            <?php $u = $this->session->userdata('user'); ?>
            <?php $class = $this->router->fetch_class(); ?>
            <?php $segment2 = $this->uri->segment(2); ?>

            <?php if($u): ?>
                <span class="welcome-text">
                    Welcome, <b><?=html_escape($u['name'])?></b>
                </span>

                <?php if($u['role'] === 'admin'): ?>
                    <a href="<?=site_url('admin')?>" class="<?= ($class === 'admin') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                <?php elseif(in_array($u['role'], ['manager', 'director'])): ?>
                    <a href="<?=site_url('approver')?>" class="<?= ($class === 'approver') ? 'active' : '' ?>">
                        <i class="fas fa-clipboard-check me-1"></i> Approver
                    </a>
                    <a href="<?=site_url('events')?>" class="<?= ($class === 'events' && $segment2 !== 'my') ? 'active' : '' ?>">
                        <i class="fas fa-calendar-alt me-1"></i> Events
                    </a>
                <?php else: ?>
                    <a href="<?=site_url('events')?>" class="<?= ($class === 'events' && $segment2 !== 'my') ? 'active' : '' ?>">
                        <i class="fas fa-calendar-alt me-1"></i> Events
                    </a>
                    <a href="<?=site_url('events/my')?>" class="<?= ($segment2 === 'my') ? 'active' : '' ?>">
                        <i class="fas fa-ticket-alt me-1"></i> My Registrations
                    </a>
                <?php endif; ?>

                <a href="<?=site_url('logout')?>" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <!-- Page content yeto ithe -->