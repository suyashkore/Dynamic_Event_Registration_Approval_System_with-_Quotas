<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotas: <?=html_escape($event['name'])?></title>

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
            background: linear-gradient(135deg, #007bff, #0dcaf0);
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
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1.1rem;
            text-align: center;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .quota-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .quota-item {
            background: #ffffff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .quota-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .quota-item label {
            display: block;
            margin-bottom: 12px;
            font-size: 1.3rem;
            color: #212529;
        }
        .btn-submit {
            background: linear-gradient(135deg, #007bff, #0dcaf0);
            border: none;
            border-radius: 50px;
            padding: 16px 50px;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
        }
        .btn-submit:disabled {
            opacity: 0.8;
            cursor: not-allowed;
        }
        .note {
            font-size: 0.95rem;
            color: #6c757d;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-chart-pie me-3"></i>Quotas: <?=html_escape($event['name'])?></h2>
    </div>

    <!-- Quotas Card -->
    <div class="card">
        <div class="card-body p-5">
            <?php if(!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?=$success?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php
            $map = [];
            foreach($quotas as $q){ $map[$q['role']] = $q['max_participants']; }
            ?>

            <form method="post" novalidate>
                <div class="quota-grid">
                    <?php foreach(['employee','external','manager','director'] as $r): ?>
                        <?php 
                        $label = strtoupper($r);
                        $value = isset($map[$r]) ? (int)$map[$r] : '';
                        ?>
                        <div class="quota-item">
                            <label for="quota_<?=$r?>"><?=$label?> Quota</label>
                            <input type="number" 
                                   name="quota_<?=$r?>" 
                                   id="quota_<?=$r?>"
                                   class="form-control form-control-lg" 
                                   min="0" 
                                   value="<?=$value?>" 
                                   placeholder="Unlimited">
                            <small class="note">Leave blank or 0 for no limit</small>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-submit shadow-lg">
                        <i class="fas fa-save me-2"></i> <span>Save Quotas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = this.querySelector('.btn-submit');
    
    if (this.checkValidity()) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
    }
});
</script>

</body>
</html>