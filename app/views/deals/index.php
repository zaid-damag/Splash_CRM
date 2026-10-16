
<?php
require_once '../app/views/layouts/header.php';
?>

<div class="page-header">
    <h1>Deals Management</h1>
    <a href="<?php echo BASE_URL; ?>/deals/create"
       class="btn btn-primary">
       Create Deal
    </a>
</div>

<?php if (!empty($deals)): ?>
<table class="table">
    <thead>
        <tr>
            <th>Deal</th>
            <th>Value</th>
            <th>Commission</th>
            <th>Stage</th>
            <th>Probability</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deals as $deal): ?>
        <tr>
            <td><?php echo View::escape($deal['title'] ?? ''); ?></td>
            <td><?php echo View::escape($deal['deal_value'] ?? ''); ?></td>
            <td><?php echo View::escape($deal['commission'] ?? ''); ?></td>
            <td><?php echo View::escape($deal['stage'] ?? ''); ?></td>
            <td><?php echo View::escape($deal['probability'] ?? ''); ?>%</td>
            <td>
                <a class="btn btn-sm"
                   href="<?php echo BASE_URL; ?>/deals/show/<?php echo (int)$deal['id']; ?>">
                   View
                </a>
                <a class="btn btn-sm"
                   href="<?php echo BASE_URL; ?>/deals/edit/<?php echo (int)$deal['id']; ?>">
                   Edit
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php echo View::pagination(
    $currentPage,
    $totalPages,
    BASE_URL . '/deals/index'
); ?>

<?php else: ?>
<p>No deals found.</p>
<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>
