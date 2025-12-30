<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Events</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            padding: 40px 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
            margin-bottom: 40px;
        }
        .page-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 2rem;
        }
        .page-header .btn {
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 500;
        }
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .table thead {
            background-color: #212529;
            color: #fff;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .btn-sm {
            border-radius: 8px;
            padding: 8px 14px;
            margin: 0 4px;
            transition: all 0.2s;
        }
        .btn-sm:hover {
            transform: translateY(-2px);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-calendar-alt me-3"></i>Admin Events</h2>
        <a class="btn btn-light btn-lg shadow-sm" href="<?=site_url('admin/events/create')?>">
            <i class="fas fa-plus me-2"></i> Create New Event
        </a>
    </div>

    <!-- Events Table Card -->
    <div class="card">
        <div class="card-body p-0">
            <?php if (empty($events)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h4>No Events Found</h4>
                    <p>Looks like there are no events yet. Create your first event to get started!</p>
                    <a href="<?=site_url('admin/events/create')?>" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-plus me-2"></i> Create First Event
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="40%">Event Name</th>
                                <th width="25%">Dates</th>
                                <th width="25%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($events as $e): ?>
                            <tr>
                                <td class="fw-bold">#<?=html_escape($e['id'])?></td>
                                <td>
                                    <div class="fw-semibold"><?=html_escape($e['name'])?></div>
                                </td>
                                <td>
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    <?=date('M d, Y', strtotime($e['start_date']))?> 
                                    <span class="text-muted">to</span> 
                                    <?=date('M d, Y', strtotime($e['end_date']))?>
                                </td>
                                <td class="text-center">
                                    <a href="<?=site_url('admin/events/edit/'.$e['id'])?>" 
                                       class="btn btn-warning btn-sm" title="Edit Event">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?=site_url('admin/events/form-nodes/'.$e['id'])?>" 
                                       class="btn btn-info btn-sm" title="Form Builder">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    <a href="<?=site_url('admin/events/quotas/'.$e['id'])?>" 
                                       class="btn btn-primary btn-sm" title="Manage Quotas">
                                        <i class="fas fa-chart-pie"></i>
                                    </a>
                                    <a href="<?=site_url('admin/events/approval-bands/'.$e['id'])?>" 
                                       class="btn btn-secondary btn-sm" title="Approval Bands">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>