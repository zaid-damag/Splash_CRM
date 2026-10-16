
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$formData = $formData ?? array();
$errors = $errors ?? array();

function propertyFormValue($field, $formData) {
    return View::escape($formData[$field] ?? '');
}
?>

<div class="page-header">
    <h1>Add New Property</h1>
    <a href="<?php echo BASE_URL; ?>/properties/index"
       class="btn btn-secondary">
        Back to Properties
    </a>
</div>

<div class="dashboard-section" style="max-width: 900px;">

    <form method="POST"
          action="<?php echo BASE_URL; ?>/properties/create">

        <input type="hidden"
               name="csrf_token"
               value="<?php echo View::escape($csrfToken); ?>">

        <h2>Basic Information</h2>

        <div class="form-group">
            <label>Property Title *</label>
            <input type="text" name="title" class="form-control"
                   value="<?php echo propertyFormValue('title', $formData); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"
                      class="form-control"><?php echo propertyFormValue('description', $formData); ?></textarea>
        </div>

        <div class="form-group">
            <label>Property Type *</label>
            <select name="property_type" class="form-control" required>
                <option value="">Select Property Type</option>
                <?php foreach (array(
                    'residential' => 'Residential',
                    'commercial' => 'Commercial',
                    'land' => 'Land',
                    'industrial' => 'Industrial'
                ) as $value => $label): ?>
                    <option value="<?php echo $value; ?>"
                        <?php echo ($formData['property_type'] ?? '') === $value ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Property Subtype</label>
            <input type="text" name="sub_type" class="form-control"
                   placeholder="Apartment, Villa, Office..."
                   value="<?php echo propertyFormValue('sub_type', $formData); ?>">
        </div>

        <div class="form-group">
            <label>Listing Type *</label>
            <select name="listing_type" class="form-control" required>
                <option value="">Select Listing Type</option>
                <option value="sale"
                    <?php echo ($formData['listing_type'] ?? '') === 'sale' ? 'selected' : ''; ?>>
                    For Sale
                </option>
                <option value="rent"
                    <?php echo ($formData['listing_type'] ?? '') === 'rent' ? 'selected' : ''; ?>>
                    For Rent
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Price *</label>
            <input type="number" name="price" class="form-control"
                   min="0" step="0.01"
                   value="<?php echo propertyFormValue('price', $formData); ?>"
                   required>
        </div>

        <h2>Property Specifications</h2>

        <?php
        $numberFields = array(
            'bedrooms' => 'Bedrooms',
            'bathrooms' => 'Bathrooms',
            'square_feet' => 'Area (Square Feet)',
            'lot_size' => 'Lot Size',
            'year_built' => 'Year Built'
        );
        ?>

        <?php foreach ($numberFields as $field => $label): ?>
            <div class="form-group">
                <label><?php echo $label; ?></label>
                <input type="number"
                       name="<?php echo $field; ?>"
                       class="form-control"
                       min="0"
                       step="<?php echo in_array($field, array('square_feet', 'lot_size')) ? '0.01' : '1'; ?>"
                       value="<?php echo propertyFormValue($field, $formData); ?>">
            </div>
        <?php endforeach; ?>

        <h2>Location Information</h2>

        <?php
        $locationFields = array(
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State / Governorate',
            'zip' => 'ZIP / Postal Code'
        );
        ?>

        <?php foreach ($locationFields as $field => $label): ?>
            <div class="form-group">
                <label><?php echo $label; ?> *</label>
                <input type="text"
                       name="<?php echo $field; ?>"
                       class="form-control"
                       value="<?php echo propertyFormValue($field, $formData); ?>"
                       required>
            </div>
        <?php endforeach; ?>

        <h2>Owner and Agent</h2>

        <div class="form-group">
            <label>Property Owner</label>
            <select name="owner_id" class="form-control">
                <option value="">Select Owner (Optional)</option>

                <?php foreach (($clients ?? array()) as $client): ?>
                    <option value="<?php echo (int)$client['id']; ?>"
                        <?php echo (string)($formData['owner_id'] ?? '') === (string)$client['id'] ? 'selected' : ''; ?>>
                        <?php echo View::escape(
                            ($client['first_name'] ?? '') . ' ' .
                            ($client['last_name'] ?? '')
                        ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Listing Agent</label>
            <select name="listing_agent_id" class="form-control">
                <option value="">Select Agent (Optional)</option>

                <?php foreach (($agents ?? array()) as $agent): ?>
                    <option value="<?php echo (int)$agent['id']; ?>"
                        <?php echo (string)($formData['listing_agent_id'] ?? '') === (string)$agent['id'] ? 'selected' : ''; ?>>
                        <?php echo View::escape(
                            ($agent['first_name'] ?? '') . ' ' .
                            ($agent['last_name'] ?? '')
                        ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo View::escape($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="margin-top: 25px;">
            <button type="submit" class="btn btn-primary">
                Save Property
            </button>

            <a href="<?php echo BASE_URL; ?>/properties/index"
               class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
