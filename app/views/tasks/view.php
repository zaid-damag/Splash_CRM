
<?php
require_once '../app/views/layouts/header.php';

$task = $task ?? array();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function taskDetailValue($value) {
    if ($value === null || $value === '') {
        return 'Not specified';
    }
    return View::escape((string)$value);
}

$taskId = (int)($task['id'] ?? 0);

$statusLabels = array(
    'pending' => 'Pending',
    'in_progress' => 'In Progress',
    'completed' => 'Completed'
);

$priorityLabels = array(
    'low' => 'Low',
    'medium' => 'Medium',
    'high' => 'High'
);

$status = $task['status'] ?? '';
$priority = $task['priority'] ?? '';
?>

<div class="page-header">
    <h1>Task Details</h1>

    <a href="<?php echo BASE_URL; ?>/tasks/index"
       class="btn btn-secondary">
        Back to Tasks
    </a>
</div>

<div class="dashboard-section">

    <h2>
        <?php echo taskDetailValue($task['title'] ?? null); ?>
    </h2>

    <h3>Task Information</h3>

    <table class="table">
        <tbody>
            <tr>
                <th>Task ID</th>
                <td><?php echo $taskId; ?></td>
            </tr>

            <tr>
                <th>Description</th>
                <td>
                    <?php echo nl2br(taskDetailValue($task['description'] ?? null)); ?>
                </td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <?php echo taskDetailValue(
                        $statusLabels[$status] ?? $status
                    ); ?>
                </td>
            </tr>

            <tr>
                <th>Priority</th>
                <td>
                    <?php echo taskDetailValue(
                        $priorityLabels[$priority] ?? $priority
                    ); ?>
                </td>
            </tr>

            <tr>
                <th>Assigned Agent ID</th>
                <td>
                    <?php echo taskDetailValue($task['assigned_to'] ?? null); ?>
                </td>
            </tr>

            <tr>
                <th>Due Date</th>
                <td>
                    <?php echo taskDetailValue($task['due_date'] ?? null); ?>
                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>
                    <?php echo taskDetailValue($task['created_at'] ?? null); ?>
                </td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>
                    <?php echo taskDetailValue($task['updated_at'] ?? null); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <?php if ($status !== 'completed' && $taskId > 0): ?>

        <form method="POST"
              action="<?php echo BASE_URL; ?>/tasks/complete/<?php echo $taskId; ?>"
              onsubmit="return confirm('Mark this task as completed?');">

            <input type="hidden"
                   name="csrf_token"
                   value="<?php echo View::escape($_SESSION['csrf_token']); ?>">

            <button type="submit" class="btn btn-primary">
                Mark as Completed
            </button>
        </form>

    <?php else: ?>

        <p><strong>This task is completed.</strong></p>

    <?php endif; ?>

</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
