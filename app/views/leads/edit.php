
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$lead = $lead ?? array();
$agents = $agents ?? array();
$errors = $errors ?? array();

$leadId = (int)($lead['id'] ?? 0);

function editLeadValue($field, $lead) {
    return View::escape((string)($lead[$field] ?? ''));
}

function editLeadSelected($field, $value, $lead) {
    return (string)($lead[$field] ?? '') === (string)$value
        ? 'selected' : '';
}
?>

<div class="page-header">
    <h1>Edit Lead</h1>

    <a href="<?php echo BASE_URL; ?>/leads/index"
       class="btn btn-secondary">
        Back to Leads
    </a>
</div>

<div class="dashboard-section" style="max-width: 850px;">

<form method="POST"
      action="<?php echo BASE_URL; ?>/leads/edit/<?php echo $leadId; ?>">

    <input type="hidden"
           name="csrf_token"
           value="<?php echo View::escape($csrfToken); ?>">

    <h2>Personal Information</h2>

    <div class="form-group">
        <label>First Name *</label>
        <input type="text" name="first_name"
               class="form-control"
               value="<?php echo editLeadValue('first_name', $lead); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name"
               class="form-control"
               value="<?php echo editLeadValue('last_name', $lead); ?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               class="form-control"
               value="<?php echo editLeadValue('email', $lead); ?>">
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="tel" name="phone"
               class="form-control"
               value="<?php echo editLeadValue('phone', $lead); ?>">
    </div>

    <h2>Lead Classification</h2>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <?php foreach (array(
                'new' => 'New',
                'contacted' => 'Contacted',
                'qualified' => 'Qualified',
                'won' => 'Won',
                'lost' => 'Lost'
            ) as $value => $label): ?>
                <option value="<?php echo $value; ?>"
                    <?php echo editLeadSelected('status', $value, $lead); ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Source</label>
        <input type="text" name="source"
               class="form-control"
               value="<?php echo editLeadValue('source', $lead); ?>">
    </div>

    <div class="form-group">
        <label>Interest Type</label>
        <select name="interest_type" class="form-control">
            <?php foreach (array(
                '' => 'Not Specified',
                'buy' => 'Buy',
                'sell' => 'Sell',
                'rent' => 'Rent',
                'lease' => 'Lease'
            ) as $value => $label): ?>
                <option value="<?php echo $value; ?>"
                    <?php echo editLeadSelected('interest_type', $value, $lead); ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <h2>Budget</h2>

    <div class="form-group">
        <label>Minimum Budget</label>
        <input type="number" name="budget_min"
               class="form-control" min="0" step="0.01"
               value="<?php echo editLeadValue('budget_min', $lead); ?>">
    </div>

    <div class="form-group">
        <label>Maximum Budget</label>
        <input type="number" name="budget_max"
               class="form-control" min="0" step="0.01"
               value="<?php echo editLeadValue('budget_max', $lead); ?>">
    </div>

    <h2>Assignment and Notes</h2>

    <div class="form-group">
        <label>Assigned Agent</label>
        <select name="assigned_to" class="form-control">
            <option value="">Unassigned</option>

            <?php foreach ($agents as $agent): ?>
                <option value="<?php echo (int)$agent['id']; ?>"
                    <?php echo editLeadSelected('assigned_to', $agent['id'], $lead); ?>>
                    <?php echo View::escape(
                        trim(($agent['first_name'] ?? '') . ' ' .
                             ($agent['last_name'] ?? ''))
                    ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes"
                  class="form-control"
                  rows="4"><?php echo editLeadValue('notes', $lead); ?></textarea>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo View::escape((string)$error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="margin-top: 25px;">
        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>

        <a href="<?php echo BASE_URL; ?>/leads/index"
           class="btn btn-secondary">
            Cancel
        </a>
    </div>

</form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
