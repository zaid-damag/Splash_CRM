
<?php
require_once '../app/views/layouts/header.php';

$client = $client ?? array();

function clientDetailValue($value) {
    if ($value === null || $value === '') {
        return 'Not specified';
    }
    return View::escape((string)$value);
}

$clientId = (int)($client['id'] ?? 0);

$clientTypes = array(
    'buyer' => 'Buyer',
    'seller' => 'Seller',
    'landlord' => 'Landlord',
    'tenant' => 'Tenant'
);

$clientType = $client['client_type'] ?? '';
?>

<div class="page-header">
    <h1>Client Details</h1>

    <div class="header-actions">
        <a href="<?php echo BASE_URL; ?>/clients/edit/<?php echo $clientId; ?>"
           class="btn btn-primary">
            Edit Client
        </a>

        <a href="<?php echo BASE_URL; ?>/clients/index"
           class="btn btn-secondary">
            Back to Clients
        </a>
    </div>
</div>

<div class="dashboard-section">

    <h2>
        <?php echo View::escape(trim(
            ($client['first_name'] ?? '') . ' ' .
            ($client['last_name'] ?? '')
        )); ?>
    </h2>

    <h3>Personal Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Client ID</th>
                <td><?php echo $clientId; ?></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?php echo clientDetailValue($client['first_name'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?php echo clientDetailValue($client['last_name'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Client Type</th>
                <td><?php echo clientDetailValue($clientTypes[$clientType] ?? $clientType); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo clientDetailValue($client['status'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Contact Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Email</th>
                <td><?php echo clientDetailValue($client['email'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo clientDetailValue($client['phone'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Secondary Phone</th>
                <td><?php echo clientDetailValue($client['phone_secondary'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Address Information</h3>

    <table class="table">
        <tbody>
            <?php
            $addressFields = array(
                'Address' => $client['address'] ?? null,
                'City' => $client['city'] ?? null,
                'State / Governorate' => $client['state'] ?? null,
                'ZIP / Postal Code' => $client['zip'] ?? null
            );
            ?>

            <?php foreach ($addressFields as $label => $value): ?>
                <tr>
                    <th><?php echo View::escape($label); ?></th>
                    <td><?php echo clientDetailValue($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Notes</h3>

    <p>
        <?php echo nl2br(clientDetailValue($client['notes'] ?? null)); ?>
    </p>

    <h3>Record Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Created At</th>
                <td><?php echo clientDetailValue($client['created_at'] ?? null); ?></td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td><?php echo clientDetailValue($client['updated_at'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
