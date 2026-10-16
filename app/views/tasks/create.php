
<?php
require_once '../app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$formData = $formData ?? array();
$errors = $errors ?? array();

function taskFormValue($field, $formData) {
    return View::escape((string)($formData[$field] ?? ''));
}
?>

<div class="page-header">
    <h1>Create New Task</h1>

    <a href="<?php echo BASE_URL; ?>/tasks/index"
       class="btn btn-secondary">
        Back to Tasks
    </a>
</div>

<div class="dashboard-section" style="max-width: 850px;">

    <form method="POST"
          action="<?php echo BASE_URL; ?>/tasks/create">

        <input type="hidden"
               name="csrf_token"
               value="<?php echo View::escape($csrfToken); ?>">

        <h2>Task Information</h2>

        <div class="form-group">
            <label for="title">Task Title *</label>

            <input type="text"
                   id="title"
                   name="title"
                   class="form-control"
                   placeholder="Enter task title"
                   value="<?php echo taskFormValue('title', $formData); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>

            <textarea id="description"
                      name="description"
                      class="form-control"
                      rows="4"
                      placeholder="Describe the task"><?php echo taskFormValue('description', $formData); ?></textarea>
        </div>

        <div class="form-group">
            <label for="assigned_to">Assigned Agent</label>

            <select id="assigned_to"
                    name="assigned_to"
                    class="form-control">

                <option value="">Unassigned</option>

                <?php foreach (($agents ?? array()) as $agent): ?>
                    <option value="<?php echo (int)$agent['id']; ?>"
                        <?php echo (string)($formData['assigned_to'] ?? '') === (string)$agent['id'] ? 'selected' : ''; ?>>

                        <?php echo View::escape(
                            trim(
                                ($agent['first_name'] ?? '') . ' ' .
                                ($agent['last_name'] ?? '')
                            )
                        ); ?>

                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>

            <input type="date"
                   id="due_date"
                   name="due_date"
                   class="form-control"
                   value="<?php echo taskFormValue('due_date', $formData); ?>">
        </div>

        <div class="form-group">
            <label for="priority">Priority</label>

            <select id="priority"
                    name="priority"
                    class="form-control">

                <?php
                $priorities = array(
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High'
                );

                $selectedPriority = $formData['priority'] ?? 'medium';
                ?>

                <?php foreach ($priorities as $value => $label): ?>
                    <option value="<?php echo $value; ?>"
                        <?php echo $selectedPriority === $value ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p>
                        <?php echo View::escape((string)$error); ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="margin-top: 25px;">
            <button type="submit" class="btn btn-primary">
                Save Task
            </button>

            <a href="<?php echo BASE_URL; ?>/tasks/index"
               class="btn btn-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
