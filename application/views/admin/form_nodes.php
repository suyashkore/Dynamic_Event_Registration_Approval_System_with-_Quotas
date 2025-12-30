<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Nodes: <?=html_escape($event['name'])?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 30px 0;
        }
        .page-header {
            margin-bottom: 30px;
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .page-header h2 {
            margin: 0;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f5f5f5;
        }
        .btn-remove {
            min-width: 40px;
        }
        .actions-row {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width: 768px) {
            .actions-row {
                flex-direction: column;
                gap: 15px;
            }
            .actions-row .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h2><i class="fas fa-cogs me-3"></i>Dynamic Form Nodes: <?=html_escape($event['name'])?></h2>
    </div>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?=$success?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" id="nodesForm">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="nodesTable">
                        <thead>
                            <tr>
                                <th width="20%">Label</th>
                                <th width="20%">Field Name</th>
                                <th width="15%">Type</th>
                                <th width="25%">Options (CSV)</th>
                                <th width="10%" class="text-center">Required</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($nodes as $n): ?>
                            <tr>
                                <td><input type="text" name="label[]" class="form-control" value="<?=html_escape($n['label'])?>" required></td>
                                <td><input type="text" name="field_name[]" class="form-control" value="<?=html_escape($n['field_name'])?>" required></td>
                                <td>
                                    <select name="field_type[]" class="form-select">
                                        <?php foreach(['text','email','number','dropdown'] as $t): ?>
                                            <option value="<?=$t?>" <?=($n['field_type']===$t?'selected':'')?>><?=ucfirst($t)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" name="field_options[]" class="form-control" value="<?=html_escape($n['field_options'])?>" placeholder="e.g. Option1,Option2,Option3"></td>
                                <td class="text-center">
                                    <input type="checkbox" name="required[]" <?=((int)$n['required']===1?'checked':'')?> class="form-check-input" style="transform: scale(1.3);">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove removeRow" title="Remove field">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <!-- Template row (hidden) -->
                            <tr class="tpl" style="display:none;">
                                <td><input type="text" name="label[]" class="form-control" value="" placeholder="Enter label"></td>
                                <td><input type="text" name="field_name[]" class="form-control" value="" placeholder="field_name"></td>
                                <td>
                                    <select name="field_type[]" class="form-select">
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="number">Number</option>
                                        <option value="dropdown">Dropdown</option>
                                    </select>
                                </td>
                                <td><input type="text" name="field_options[]" class="form-control" value="" placeholder="e.g. Yes,No,Maybe"></td>
                                <td class="text-center">
                                    <input type="checkbox" name="required[]" checked class="form-check-input" style="transform: scale(1.3);">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove removeRow" title="Remove field">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="actions-row">
                    <button type="button" class="btn btn-success btn-lg" id="addNode">
                        <i class="fas fa-plus me-2"></i> Add New Field
                    </button>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Save Nodes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (for your existing script) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#addNode').on('click', function(){
            var newRow = $('#nodesTable .tpl').clone();
            newRow.removeClass('tpl').show();
            $('#nodesTable tbody').append(newRow);
        });

        $(document).on('click', '.removeRow', function(){
            // Prevent removing the last visible row if needed (optional)
            if ($('#nodesTable tbody tr:visible').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert('At least one field is required!');
            }
        });
    });
</script>

</body>
</html>