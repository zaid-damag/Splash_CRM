
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$formData = $formData ?? array();
$errors = $errors ?? array();

function clientFormValue($field, $data) {
    return View::escape((string)($data[$field] ?? ''));
}
?>

<div class="page-header">
    <h1>Create New Client</h1>

    <a href="<?php echo BASE_URL; ?>/clients/index"
       class="btn btn-secondary">
        Back to Clients
    </a>
</div>

<div class="dashboard-section" style="max-width: 850px;">

    <form method="POST"
          action="<?php echo BASE_URL; ?>/clients/create">

        <input type="hidden"
               name="csrf_token"
               value="<?php echo View::escape($csrfToken); ?>">

        <h2>Personal Information</h2>

        <div class="form-group">
            <label>First Name *</label>
            <input type="text"
                   name="first_name"
                   class="form-control"
                   value="<?php echo clientFormValue('first_name', $formData); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text"
                   name="last_name"
                   class="form-control"
                   value="<?php echo clientFormValue('last_name', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="<?php echo clientFormValue('email', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="tel"
                   name="phone"
                   class="form-control"
                   value="<?php echo clientFormValue('phone', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Secondary Phone</label>
            <input type="tel"
                   name="phone_secondary"
                   class="form-control"
                   value="<?php echo clientFormValue('phone_secondary', $formData); ?>">
        </div>

        <h2>Address Information</h2>

        <?php
        $addressFields = array(
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State / Governorate',
            'zip' => 'ZIP / Postal Code'
        );
        ?>

        <?php foreach ($addressFields as $field => $label): ?>
            <div class="form-group">
                <label><?php echo View::escape($label); ?></label>
                <input type="text"
                       name="<?php echo $field; ?>"
                       class="form-control"
                       value="<?php echo clientFormValue($field, $formData); ?>">
            </div>
        <?php endforeach; ?>

        <h2>Client Classification</h2>

        <div class="form-group">
            <label>Client Type *</label>
            <select name="client_type" class="form-control" required>
                <option value="">Select Client Type</option>

                <?php foreach (array(
                    'buyer' => 'Buyer',
                    'seller' => 'Seller',
                    'landlord' => 'Landlord',
                    'tenant' => 'Tenant'
                ) as $value => $label): ?>

                    <option value="<?php echo $value; ?>"
                        <?php echo ($formData['client_type'] ?? '') === $value ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>

                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes"
                      class="form-control"
                      rows="4"><?php echo clientFormValue('notes', $formData); ?></textarea>
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
                Save Client
            </button>

            <a href="<?php echo BASE_URL; ?>/clients/index"
               class="btn btn-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
