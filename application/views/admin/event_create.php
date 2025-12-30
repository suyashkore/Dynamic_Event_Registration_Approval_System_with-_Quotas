<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>

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
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.2);
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
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .btn-submit {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 50px;
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }
        .btn-submit:disabled {
            opacity: 0.8;
            cursor: not-allowed;
            transform: none;
        }
        .date-row {
            gap: 20px;
        }
        @media (max-width: 768px) {
            .date-row .col {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-calendar-plus me-3"></i>Create New Event</h2>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body p-5">
            <?=validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>')?>

            <form method="post" novalidate>
                <div class="mb-4">
                    <label for="name" class="form-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg" 
                           placeholder="Enter event name..." value="<?=set_value('name')?>" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" 
                              placeholder="Describe your event..."><?=set_value('description')?></textarea>
                </div>

                <div class="row date-row mb-5">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-lg" 
                               value="<?=set_value('start_date')?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-lg" 
                               value="<?=set_value('end_date')?>" required>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-submit shadow-lg">
                        <i class="fas fa-plus me-2"></i> <span>Create Event</span>
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
    const span = btn.querySelector('span');
    
    if (this.checkValidity()) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Creating...';
    }
});

document.querySelectorAll('input[type="date"]').forEach(input => {
    const today = new Date().toISOString().split('T')[0];
    input.setAttribute('min', today);
});

document.querySelector('input[name="start_date"]').addEventListener('change', function() {
    const endDateInput = document.querySelector('input[name="end_date"]');
    endDateInput.setAttribute('min', this.value);
    
    // Optional: clear end date if it's before start date
    if (endDateInput.value && endDateInput.value < this.value) {
        endDateInput.value = '';
    }
});
</script>

</body>
</html>