
<?php
require_once '../app/views/layouts/header.php';
?>

<div class="page-header">
    <h1>Tasks Management</h1>
    <a href="<?php echo BASE_URL; ?>/tasks/create"
       class="btn btn-primary">
        Create Task
    </a>
</div>

<div class="filters">
    <form method="GET"
          action="<?php echo BASE_URL; ?>/tasks/index"
          class="filter-form">

        <select name="status" class="form-control">
            <option value="">All Statuses</option>
            <option value="pending" <?php echo ($filters['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="in_progress" <?php echo ($filters['status'] ?? '') === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="completed" <?php echo ($filters['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>

        <select name="priority" class="form-control">
            <option value="">All Priorities</option>
            <option value="low" <?php echo ($filters['priority'] ?? '') === 'low' ? 'selected' : ''; ?>>Low</option>
            <option value="medium" <?php echo ($filters['priority'] ?? '') === 'medium' ? 'selected' : ''; ?>>Medium</option>
            <option value="high" <?php echo ($filters['priority'] ?? '') === 'high' ? 'selected' : ''; ?>>High</option>
        </select>

        <button type="submit" class="btn btn-secondary">
            Filter
        </button>

        <a href="<?php echo BASE_URL; ?>/tasks/index"
           class="btn btn-link">
            Clear
        </a>
    </form>
</div>

<?php if (!empty($tasks)): ?>

<table class="table">
    <thead>
        <tr>
            <th>Task</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($tasks as $task): ?>
        <tr>
            <td>
                <?php echo View::escape($task['title'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($task['priority'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($task['status'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($task['due_date'] ?? ''); ?>
            </td>

            <td>
                <a class="btn btn-sm"
                   href="<?php echo BASE_URL; ?>/tasks/show/<?php echo (int)$task['id']; ?>">
                    View
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php echo View::pagination(
    $currentPage,
    $totalPages,
    BASE_URL . '/tasks/index'
); ?>

<?php else: ?>

<p>No tasks found.</p>

<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>
