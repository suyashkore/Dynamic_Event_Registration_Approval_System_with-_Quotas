<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for: <?=html_escape($event['name'])?></title>

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
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 6px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 3px;
        }
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .card-body {
            padding: 50px;
        }
        .form-label {
            font-weight: 600;
            color: #343a40;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        .required-star {
            color: #ef4444;
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1.1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        .waitlist-box {
            background-color: #e9f7ef;
            border: 2px solid #28a745;
            border-radius: 12px;
            padding: 20px;
            margin: 40px 0;
            text-align: center;
        }
        .waitlist-box label {
            font-size: 1.15rem;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
        }
        .waitlist-box input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 12px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 50px;
            padding: 16px 50px;
            font-size: 1.3rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }
        .btn-submit:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4);
        }
        .btn-submit:disabled {
            opacity: 0.8;
            cursor: not-allowed;
            transform: none;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-user-plus me-3 text-success"></i>Register for: <?=html_escape($event['name'])?></h2>
    </div>

    <!-- Registration Card -->
    <div class="card">
        <div class="card-body">
            <?php if(!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?=$success?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?=validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>')?>

            <form method="post" id="regForm" novalidate>
                <?php foreach($nodes as $n): ?>
                    <div class="mb-4">
                        <label class="form-label">
                            <?=html_escape($n['label'])?>
                            <?=((int)$n['required']===1 ? '<span class="required-star">*</span>' : '')?>
                        </label>

                        <?php if($n['field_type']==='dropdown'): ?>
                            <?php $opts = array_map('trim', explode(',', (string)$n['field_options'])); ?>
                            <select name="<?=html_escape($n['field_name'])?>" 
                                    class="form-select form-select-lg" 
                                    <?=((int)$n['required']===1?'required':'')?>>
                                <option value="">-- Select an option --</option>
                                <?php foreach($opts as $o): ?>
                                    <option value="<?=html_escape($o)?>" 
                                            <?= set_value($n['field_name']) == $o ? 'selected' : '' ?>>
                                        <?=html_escape($o)?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input
                                type="<?=($n['field_type']==='email'?'email':($n['field_type']==='number'?'number':'text'))?>"
                                name="<?=html_escape($n['field_name'])?>"
                                class="form-control form-control-lg"
                                value="<?=html_escape(set_value($n['field_name']))?>"
                                placeholder="Enter <?=html_escape(strtolower($n['label']))?>..."
                                <?=((int)$n['required']===1?'required':'')?>>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div class="waitlist-box">
                    <label>
                        <input type="checkbox" name="waitlist" value="1" class="me-3">
                        Add me to the waitlist if the quota is full
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-submit shadow-lg">
                        <i class="fas fa-paper-plane me-2"></i> <span>Submit Registration</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('regForm').addEventListener('submit', function(e) {
    const btn = this.querySelector('.btn-submit');
    const span = btn.querySelector('span');
    
    if (this.checkValidity()) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
    }
});
</script>

</body>
</html>