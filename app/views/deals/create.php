
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$formData = $formData ?? array();
$errors = $errors ?? array();

function dealFormValue($field, $formData) {
    return View::escape((string)($formData[$field] ?? ''));
}

function dealFormSelected($field, $value, $formData) {
    return (string)($formData[$field] ?? '') === (string)$value
        ? 'selected' : '';
}
?>

<div class="page-header">
    <h1>Create New Deal</h1>
    <a href="<?php echo BASE_URL; ?>/deals/index"
       class="btn btn-secondary">
        Back to Deals
    </a>
</div>

<div class="dashboard-section" style="max-width: 850px;">

    <form method="POST"
          action="<?php echo BASE_URL; ?>/deals/create">

        <input type="hidden"
               name="csrf_token"
               value="<?php echo View::escape($csrfToken); ?>">

        <h2>Deal Information</h2>

        <div class="form-group">
            <label>Deal Title *</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="<?php echo dealFormValue('title', $formData); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Client</label>
            <select name="client_id" class="form-control">
                <option value="">No Client Selected</option>

                <?php foreach (($clients ?? array()) as $client): ?>
                    <option value="<?php echo (int)$client['id']; ?>"
                        <?php echo dealFormSelected('client_id', $client['id'], $formData); ?>>
                        <?php echo View::escape(
                            trim(($client['first_name'] ?? '') . ' ' .
                                 ($client['last_name'] ?? ''))
                        ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Property</label>
            <select name="property_id" class="form-control">
                <option value="">No Property Selected</option>

                <?php foreach (($properties ?? array()) as $property): ?>
                    <option value="<?php echo (int)$property['id']; ?>"
                        <?php echo dealFormSelected('property_id', $property['id'], $formData); ?>>
                        <?php echo View::escape($property['title'] ?? ''); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Assigned Agent</label>
            <select name="assigned_to" class="form-control">
                <option value="">Unassigned</option>

                <?php foreach (($agents ?? array()) as $agent): ?>
                    <option value="<?php echo (int)$agent['id']; ?>"
                        <?php echo dealFormSelected('assigned_to', $agent['id'], $formData); ?>>
                        <?php echo View::escape(
                            trim(($agent['first_name'] ?? '') . ' ' .
                                 ($agent['last_name'] ?? ''))
                        ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <h2>Financial Information</h2>

        <div class="form-group">
            <label>Deal Value</label>
            <input type="number"
                   name="deal_value"
                   class="form-control"
                   min="0"
                   step="0.01"
                   value="<?php echo dealFormValue('deal_value', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Commission</label>
            <input type="number"
                   name="commission"
                   class="form-control"
                   min="0"
                   step="0.01"
                   value="<?php echo dealFormValue('commission', $formData); ?>">
        </div>

        <h2>Deal Progress</h2>

        <div class="form-group">
            <label>Deal Stage</label>
            <select name="stage" class="form-control">
                <?php foreach (array(
                    'lead' => 'Lead',
                    'meeting' => 'Meeting',
                    'proposal' => 'Proposal',
                    'negotiation' => 'Negotiation',
                    'closed_won' => 'Closed Won',
                    'closed_lost' => 'Closed Lost'
                ) as $value => $label): ?>
                    <option value="<?php echo $value; ?>"
                        <?php echo dealFormSelected('stage', $value, $formData); ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Probability (%)</label>
            <input type="number"
                   name="probability"
                   class="form-control"
                   min="0"
                   max="100"
                   value="<?php echo dealFormValue('probability', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Expected Close Date</label>
            <input type="date"
                   name="expected_close_date"
                   class="form-control"
                   value="<?php echo dealFormValue('expected_close_date', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes"
                      class="form-control"
                      rows="4"><?php echo dealFormValue('notes', $formData); ?></textarea>
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
                Save Deal
            </button>

            <a href="<?php echo BASE_URL; ?>/deals/index"
               class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
