<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px 0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        .page-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .page-header h2 {
            font-size: 3rem;
            font-weight: 700;
            color: #212529;
            position: relative;
            display: inline-block;
        }
        .page-header h2::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(135deg, #007bff, #00d4ff);
            border-radius: 3px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .event-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
        }
        .event-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .card-body {
            padding: 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .event-card h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 15px;
        }
        .event-card p {
            color: #555;
            line-height: 1.7;
            flex-grow: 1;
            margin-bottom: 25px;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .dates {
            font-weight: 600;
            color: #007bff;
        }
        .dates i {
            margin-right: 8px;
        }
        .register-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            color: white;
        }
        .register-btn i {
            margin-left: 8px;
        }
        .empty-state {
            text-align: center;
            padding: 100px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.4;
        }
        .empty-state h3 {
            font-size: 2rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-calendar-alt me-3 text-primary"></i>Upcoming Events</h2>
    </div>

    <?php if (empty($events)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>No Upcoming Events</h3>
            <p>Stay tuned! New events will be announced soon.</p>
        </div>
    <?php else: ?>
        <div class="events-grid">
            <?php foreach($events as $e): ?>
                <div class="event-card">
                    <div class="card-body">
                        <h3><?=html_escape($e['name'])?></h3>
                        <p><?=nl2br(html_escape($e['description']))?></p>
                    </div>
                    <div class="card-footer">
                        <div class="dates">
                            <i class="fas fa-calendar"></i>
                            <?=date('M j, Y', strtotime($e['start_date']))?> 
                            <span class="text-muted">to</span> 
                            <?=date('M j, Y', strtotime($e['end_date']))?>
                        </div>
                        <a href="<?=site_url('events/register/'.$e['id'])?>" class="register-btn">
                            Register Now <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>