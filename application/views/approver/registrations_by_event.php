<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals: <?=html_escape($event['name'])?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
            padding: 50px 0;
            font-family: 'Segoe UI', sans-serif;
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
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 6px;
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
            border-radius: 3px;
        }
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 1300px;
            margin: 0 auto;
        }
        .table thead {
            background: linear-gradient(135deg, #6f42c1, #8b5cf6);
            color: white;
            font-weight: 600;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .user-info small {
            color: #6b7280;
        }
        .toggle-details {
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.9rem;
        }
        .details-row {
            background-color: #f9fafb;
        }
        .registration-details {
            padding: 25px;
            background: white;
            border-radius: 12px;
            margin: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .registration-details h4 {
            margin-bottom: 20px;
            color: #5b21b6;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .registration-details div {
            margin-bottom: 12px;
            font-size: 1.05rem;
        }
        .registration-details strong {
            color: #374151;
            min-width: 160px;
            display: inline-block;
        }
        .approver-action-form {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .approver-action-form select,
        .approver-action-form input {
            flex: 1;
            min-width: 120px;
        }
        .approver-action-form button {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
        }
        .no-pending {
            text-align: center;
            padding: 80px 20px;
            font-size: 1.3rem;
        }
        .no-pending i {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        @media (max-width: 992px) {
            .approver-action-form {
                flex-direction: column;
            }
            .approver-action-form select,
            .approver-action-form input,
            .approver-action-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-clipboard-check me-3 text-purple"></i>Pending Approvals: <?=html_escape($event['name'])?></h2>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <?php if(empty($rows)): ?>
                <div class="no-pending">
                    <i class="fas fa-check-circle"></i>
                    <h3>No Pending Approvals</h3>
                    <p>No registrations are currently pending for your approval in this event.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="20%">User</th>
                                <th width="15%">Role</th>
                                <th width="18%">Submitted</th>
                                <th width="12%">Details</th>
                                <th width="35%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $r): ?>
                                <?php 
                                $formData = !empty($r['form_data']) ? json_decode($r['form_data'], true) : [];
                                ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <b><?=html_escape($r['user_name'])?></b><br>
                                            <small><?=html_escape($r['email'])?></small>
                                        </div>
                                    </td>
                                    <td class="text-capitalize fw-semibold"><?=html_escape($r['user_role'])?></td>
                                    <td>
                                        <i class="fas fa-clock me-2 text-muted"></i>
                                        <?=date('M j, Y, g:i a', strtotime($r['registered_at']))?>
                                    </td>
                                    <td>
                                        <?php if (!empty($formData)): ?>
                                            <button type="button" class="btn btn-outline-secondary btn-sm toggle-details">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="post" action="<?=site_url('approver/decision/'.$r['id'])?>" class="approver-action-form">
                                            <select name="decision" class="form-select form-select-sm" required>
                                                <option value="">-- Select Action --</option>
                                                <option value="approved">Approve</option>
                                                <option value="rejected">Reject</option>
                                            </select>
                                            <input type="text" name="remarks" class="form-control form-control-sm" 
                                                   placeholder="Remarks (optional)">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-paper-plane"></i> Submit
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <?php if (!empty($formData)): ?>
                                <tr class="details-row" style="display:none;">
                                    <td colspan="5">
                                        <div class="registration-details">
                                            <h4><i class="fas fa-file-alt me-2"></i>Submitted Form Data</h4>
                                            <?php foreach ($formData as $key => $value): ?>
                                                <div>
                                                    <strong><?= html_escape(ucfirst(str_replace('_', ' ', $key))) ?>:</strong> 
                                                    <?= html_escape($value) ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
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

<script>
$(document).ready(function(){
    $('.toggle-details').on('click', function(){
        var $row = $(this).closest('tr').next('.details-row');
        $row.fadeToggle('fast');
        
        var $icon = $(this).find('i');
        var text = $(this).text().trim();
        if (text.includes('View')) {
            $(this).html('<i class="fas fa-eye-slash me-1"></i> Hide');
        } else {
            $(this).html('<i class="fas fa-eye me-1"></i> View');
        }
    });
});
</script>

</body>
</html>