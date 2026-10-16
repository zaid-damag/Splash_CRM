
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$property = $property ?? array();
$errors = $errors ?? array();

function editPropertyValue($field, $property) {
    return View::escape((string)($property[$field] ?? ''));
}

function editPropertySelected($field, $value, $property) {
    return (string)($property[$field] ?? '') === (string)$value
        ? 'selected' : '';
}
?>

<div class="page-header">
    <h1>Edit Property</h1>
    <a href="<?php echo BASE_URL; ?>/properties/show/<?php echo (int)$property['id']; ?>"
       class="btn btn-secondary">
        Back to Details
    </a>
</div>

<div class="dashboard-section" style="max-width: 900px;">

<form method="POST"
      action="<?php echo BASE_URL; ?>/properties/edit/<?php echo (int)$property['id']; ?>">

    <input type="hidden" name="csrf_token"
           value="<?php echo View::escape($csrfToken); ?>">

    <h2>Basic Information</h2>

    <div class="form-group">
        <label>Property Title *</label>
        <input type="text" name="title" class="form-control"
               value="<?php echo editPropertyValue('title', $property); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4"
                  class="form-control"><?php echo editPropertyValue('description', $property); ?></textarea>
    </div>

    <div class="form-group">
        <label>Property Type *</label>
        <select name="property_type" class="form-control" required>
            <?php foreach (array(
                'residential' => 'Residential',
                'commercial' => 'Commercial',
                'land' => 'Land',
                'industrial' => 'Industrial'
            ) as $value => $label): ?>
                <option value="<?php echo $value; ?>"
                    <?php echo editPropertySelected('property_type', $value, $property); ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Property Subtype</label>
        <input type="text" name="sub_type" class="form-control"
               value="<?php echo editPropertyValue('sub_type', $property); ?>">
    </div>

    <div class="form-group">
        <label>Listing Type *</label>
        <select name="listing_type" class="form-control" required>
            <option value="sale"
                <?php echo editPropertySelected('listing_type', 'sale', $property); ?>>
                For Sale
            </option>
            <option value="rent"
                <?php echo editPropertySelected('listing_type', 'rent', $property); ?>>
                For Rent
            </option>
        </select>
    </div>

    <div class="form-group">
        <label>Price *</label>
        <input type="number" name="price" min="0" step="0.01"
               class="form-control"
               value="<?php echo editPropertyValue('price', $property); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Property Status</label>
        <select name="status" class="form-control">
            <?php foreach (array(
                'available' => 'Available',
                'pending' => 'Pending',
                'sold' => 'Sold',
                'rented' => 'Rented'
            ) as $value => $label): ?>
                <option value="<?php echo $value; ?>"
                    <?php echo editPropertySelected('status', $value, $property); ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <h2>Specifications</h2>

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
                   value="<?php echo editPropertyValue($field, $property); ?>">
        </div>
    <?php endforeach; ?>

    <h2>Location</h2>

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
                   value="<?php echo editPropertyValue($field, $property); ?>"
                   required>
        </div>
    <?php endforeach; ?>

    <h2>Owner and Agent</h2>

    <div class="form-group">
        <label>Property Owner</label>
        <select name="owner_id" class="form-control">
            <option value="">No Owner Selected</option>

            <?php foreach (($clients ?? array()) as $client): ?>
                <option value="<?php echo (int)$client['id']; ?>"
                    <?php echo editPropertySelected('owner_id', $client['id'], $property); ?>>
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
            <option value="">No Agent Selected</option>

            <?php foreach (($agents ?? array()) as $agent): ?>
                <option value="<?php echo (int)$agent['id']; ?>"
                    <?php echo editPropertySelected('listing_agent_id', $agent['id'], $property); ?>>
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
                <p><?php echo View::escape((string)$error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="margin-top: 25px;">
        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>

        <a href="<?php echo BASE_URL; ?>/properties/show/<?php echo (int)$property['id']; ?>"
           class="btn btn-secondary">
            Cancel
        </a>
    </div>

</form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
