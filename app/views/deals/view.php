
<?php
require_once '../app/views/layouts/header.php';

$deal = $deal ?? array();

function dealDetailValue($value) {
    if ($value === null || $value === '') {
        return 'Not specified';
    }
    return View::escape((string)$value);
}

$stages = array(
    'lead' => 'Lead',
    'meeting' => 'Meeting',
    'proposal' => 'Proposal',
    'negotiation' => 'Negotiation',
    'closed_won' => 'Closed Won',
    'closed_lost' => 'Closed Lost'
);
?>

<div class="page-header">
    <h1>Deal Details</h1>

    <div class="header-actions">
        <a href="<?php echo BASE_URL; ?>/deals/edit/<?php echo (int)($deal['id'] ?? 0); ?>"
           class="btn btn-primary">
            Edit Deal
        </a>

        <a href="<?php echo BASE_URL; ?>/deals/index"
           class="btn btn-secondary">
            Back to Deals
        </a>
    </div>
</div>

<div class="dashboard-section">

    <h2>
        <?php echo dealDetailValue($deal['title'] ?? null); ?>
    </h2>

    <h3>Deal Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Deal ID</th>
                <td><?php echo dealDetailValue($deal['id'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Deal Value</th>
                <td><?php echo dealDetailValue($deal['deal_value'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Commission</th>
                <td><?php echo dealDetailValue($deal['commission'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Stage</th>
                <td>
                    <?php
                    $stage = $deal['stage'] ?? '';
                    echo dealDetailValue($stages[$stage] ?? $stage);
                    ?>
                </td>
            </tr>

            <tr>
                <th>Probability</th>
                <td>
                    <?php echo dealDetailValue($deal['probability'] ?? null); ?>%
                </td>
            </tr>

            <tr>
                <th>Expected Close Date</th>
                <td><?php echo dealDetailValue($deal['expected_close_date'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Related Records</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Client ID</th>
                <td><?php echo dealDetailValue($deal['client_id'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Property ID</th>
                <td><?php echo dealDetailValue($deal['property_id'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Assigned Agent ID</th>
                <td><?php echo dealDetailValue($deal['assigned_to'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Notes</h3>

    <p>
        <?php echo nl2br(dealDetailValue($deal['notes'] ?? null)); ?>
    </p>

    <h3>Record Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Created At</th>
                <td><?php echo dealDetailValue($deal['created_at'] ?? null); ?></td>
            </tr>

            <tr>
                <th>Last Updated</th>
                <td><?php echo dealDetailValue($deal['updated_at'] ?? null); ?></td>
            </tr>
        </tbody>
    </table>

</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
