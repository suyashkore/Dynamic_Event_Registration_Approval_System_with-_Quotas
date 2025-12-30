<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Registrations</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .page-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .page-header h2 {
            font-size: 2.8rem;
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
            width: 100px;
            height: 5px;
            background: linear-gradient(135deg, #fd7e14, #ffc107);
            border-radius: 3px;
        }
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 1100px;
            margin: 0 auto;
        }
        .table thead {
            background: linear-gradient(135deg, #343a40, #212529);
            color: white;
            font-weight: 600;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-waiting {
            background-color: #d1ecf1;
            color: #0c5460;
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

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-ticket-alt me-3 text-warning"></i>My Registrations</h2>
    </div>

    <?php if (empty($rows)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>No Registrations Yet</h3>
            <p>You haven't registered for any events. Check out the upcoming events and join one!</p>
            <a href="<?=site_url('events')?>" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-calendar-alt me-2"></i> View Upcoming Events
            </a>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="35%">Event</th>
                                <th width="25%">Dates</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="25%">Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $r): ?>
                            <tr>
                                <td class="fw-semibold"><?=html_escape($r['event_name'])?></td>
                                <td>
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    <?=date('M j, Y', strtotime($r['start_date']))?> 
                                    <span class="text-muted">to</span> 
                                    <?=date('M j, Y', strtotime($r['end_date']))?>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge status-<?=strtolower(html_escape($r['status']))?>">
                                        <?=html_escape(ucfirst($r['status']))?>
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-clock me-2 text-muted"></i>
                                    <?=date('M j, Y, g:i a', strtotime($r['registered_at']))?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>