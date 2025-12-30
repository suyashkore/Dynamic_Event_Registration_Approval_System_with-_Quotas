<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approver Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            padding: 50px 0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        .page-header {
            text-align: center;
            margin-bottom: 30px;
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
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 6px;
            background: linear-gradient(135deg, #6f42c1, #9d5ee5);
            border-radius: 3px;
        }
        .intro-text {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            max-width: 800px;
            margin: 0 auto 60px auto;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .event-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .event-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(111, 66, 193, 0.2);
        }
        .card-body {
            padding: 30px;
            flex-grow: 1;
        }
        .event-card h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 15px;
        }
        .event-card p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        .event-card .dates {
            font-weight: 600;
            color: #6f42c1;
            margin-top: 10px;
        }
        .event-card .dates i {
            margin-right: 8px;
        }
        .empty-state {
            text-align: center;
            padding: 100px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 5rem;
            margin-bottom: 25px;
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
        <h2><i class="fas fa-check-double me-3 text-purple"></i>Approver Dashboard</h2>
    </div>

    <p class="intro-text">
        Select an event to view and manage pending registrations awaiting your approval.
    </p>

    <?php if (empty($events)): ?>
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>No Events Assigned</h3>
            <p>You currently have no events requiring your approval. Check back later!</p>
        </div>
    <?php else: ?>
        <div class="events-grid">
            <?php foreach($events as $e): ?>
                <a href="<?=site_url('approver/event/'.$e['id'])?>" class="card-link">
                    <div class="event-card">
                        <div class="card-body">
                            <h3><?=html_escape($e['name'])?></h3>
                            <p class="dates">
                                <i class="fas fa-calendar-alt"></i>
                                <?=date('M j, Y', strtotime($e['start_date']))?> 
                                <span class="text-muted">to</span> 
                                <?=date('M j, Y', strtotime($e['end_date']))?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>