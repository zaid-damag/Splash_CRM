
<?php
require_once '../app/views/layouts/header.php';

$property = $property ?? array();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
function displayPropertyValue($value) {
    if ($value === null || $value === '') {
        return 'Not specified';
    }
    return View::escape((string)$value);
}
?>

<div class="page-header">
    <h1>Property Details</h1>
    <div class="header-actions">
        <a href="<?php echo BASE_URL; ?>/properties/edit/<?php echo (int)$property['id']; ?>"
           class="btn btn-primary">
            Edit Property
            
<form method="POST"
      action="<?php echo BASE_URL; ?>/properties/delete/<?php echo (int)$property['id']; ?>"
      style="display: inline-block;"
      onsubmit="return confirm('Are you sure you want to permanently delete this property?');">

    <input type="hidden"
           name="csrf_token"
           value="<?php echo View::escape($_SESSION['csrf_token']); ?>">

    <button type="submit"
            class="btn btn-danger">
        Delete Property
    </button>
</form>

        </a>

        <a href="<?php echo BASE_URL; ?>/properties/index"
           class="btn btn-secondary">
            Back to Properties
        </a>
    </div>
</div>

<div class="dashboard-section">

    <h2><?php echo displayPropertyValue($property['title'] ?? null); ?></h2>

    <h3>Basic Information</h3>

    <table class="table">
        <tbody>
            <?php
            $basicInfo = array(
                'Property Type' => $property['property_type'] ?? null,
                'Subtype' => $property['sub_type'] ?? null,
                'Listing Type' => $property['listing_type'] ?? null,
                'Price' => $property['price'] ?? null,
                'Status' => $property['status'] ?? null
            );
            ?>

            <?php foreach ($basicInfo as $label => $value): ?>
                <tr>
                    <th><?php echo View::escape($label); ?></th>
                    <td><?php echo displayPropertyValue($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Description</h3>

    <p>
        <?php echo nl2br(
            displayPropertyValue($property['description'] ?? null)
        ); ?>
    </p>

    <h3>Property Specifications</h3>

    <table class="table">
        <tbody>
            <?php
            $specifications = array(
                'Bedrooms' => $property['bedrooms'] ?? null,
                'Bathrooms' => $property['bathrooms'] ?? null,
                'Area (Square Feet)' => $property['square_feet'] ?? null,
                'Lot Size' => $property['lot_size'] ?? null,
                'Year Built' => $property['year_built'] ?? null
            );
            ?>

            <?php foreach ($specifications as $label => $value): ?>
                <tr>
                    <th><?php echo View::escape($label); ?></th>
                    <td><?php echo displayPropertyValue($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Location</h3>

    <table class="table">
        <tbody>
            <?php
            $location = array(
                'Address' => $property['address'] ?? null,
                'City' => $property['city'] ?? null,
                'State / Governorate' => $property['state'] ?? null,
                'ZIP / Postal Code' => $property['zip'] ?? null
            );
            ?>

            <?php foreach ($location as $label => $value): ?>
                <tr>
                    <th><?php echo View::escape($label); ?></th>
                    <td><?php echo displayPropertyValue($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Additional Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Owner ID</th>
                <td><?php echo displayPropertyValue($property['owner_id'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Listing Agent ID</th>
                <td><?php echo displayPropertyValue($property['listing_agent_id'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?php echo displayPropertyValue($property['created_at'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if (!empty($attachments)): ?>
        <h3>Attachments</h3>

        <p>
            <?php echo count($attachments); ?>
            attachment(s) associated with this property.
        </p>
    <?php endif; ?>

</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
