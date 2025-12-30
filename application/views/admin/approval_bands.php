<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Bands: <?=html_escape($event['name'])?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
            padding: 40px 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #6f42c1, #9d5ee5);
            color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.2);
            margin-bottom: 40px;
        }
        .page-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 2rem;
        }
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }
        .btn-remove {
            min-width: 44px;
        }
        .actions-row {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #6f42c1, #9d5ee5);
            border: none;
            border-radius: 50px;
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
        }
        @media (max-width: 768px) {
            .actions-row {
                flex-direction: column;
            }
            .actions-row .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-layer-group me-3"></i>Approval Bands: <?=html_escape($event['name'])?></h2>
    </div>

    <!-- Bands Card -->
    <div class="card">
        <div class="card-body p-5">
            <?php if(!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?=$success?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" id="bandsForm">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="bandsTable">
                        <thead>
                            <tr>
                                <th width="20%">Order</th>
                                <th width="60%">Approver Role</th>
                                <th width="20%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($bands as $b): ?>
                            <tr>
                                <input type="hidden" name="band_id[]" value="<?=$b['id']?>">
                                <td>
                                    <input type="number" name="band_order[]" class="form-control" 
                                           value="<?=$b['band_order']?>" min="1" required placeholder="e.g. 1">
                                </td>
                                <td>
                                    <select name="role[]" class="form-select">
                                        <option value="manager" <?=$b['role']==='manager'?'selected':''?>>Manager</option>
                                        <option value="director" <?=$b['role']==='director'?'selected':''?>>Director</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove removeBand" title="Remove band">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <!-- Template Row (hidden) -->
                            <tr class="tpl" style="display:none;">
                                <input type="hidden" name="band_id[]" value="">
                                <td>
                                    <input type="number" name="band_order[]" class="form-control" min="1" placeholder="e.g. 1">
                                </td>
                                <td>
                                    <select name="role[]" class="form-select">
                                        <option value="manager">Manager</option>
                                        <option value="director">Director</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove removeBand" title="Remove band">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="actions-row">
                    <button type="button" class="btn btn-success btn-lg" id="addBand">
                        <i class="fas fa-plus me-2"></i> Add New Band
                    </button>

                    <button type="submit" class="btn btn-primary btn-lg btn-submit shadow-lg">
                        <i class="fas fa-save me-2"></i> Save Bands
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#addBand').on('click', function(){
        var newRow = $('#bandsTable .tpl').clone();
        newRow.removeClass('tpl').show();
        $('#bandsTable tbody').append(newRow);
    });

    $(document).on('click', '.removeBand', function(){
        if ($('#bandsTable tbody tr:visible').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('At least one approval band is required!');
        }
    });

    // Submit button loading state
    $('#bandsForm').on('submit', function() {
        const btn = $(this).find('.btn-submit');
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');
    });
});
</script>

</body>
</html>