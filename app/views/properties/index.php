
<?php
require_once '../app/views/layouts/header.php';
?>

<div class="page-header">
    <h1>Properties Management</h1>
    <a href="<?php echo BASE_URL; ?>/properties/create"
       class="btn btn-primary">
        Add Property
    </a>
</div>

<div class="filters">
    <form method="GET"
          action="<?php echo BASE_URL; ?>/properties/index"
          class="filter-form">

        <input type="text"
               name="search"
               placeholder="Search properties..."
               class="form-control"
               value="<?php echo View::escape($filters['search'] ?? ''); ?>">

        <select name="listing_type" class="form-control">
            <option value="">All Listings</option>
            <option value="sale" <?php echo ($filters['listing_type'] ?? '') === 'sale' ? 'selected' : ''; ?>>For Sale</option>
            <option value="rent" <?php echo ($filters['listing_type'] ?? '') === 'rent' ? 'selected' : ''; ?>>For Rent</option>
        </select>

        <select name="status" class="form-control">
            <option value="">All Statuses</option>
            <option value="available" <?php echo ($filters['status'] ?? '') === 'available' ? 'selected' : ''; ?>>Available</option>
            <option value="sold" <?php echo ($filters['status'] ?? '') === 'sold' ? 'selected' : ''; ?>>Sold</option>
            <option value="rented" <?php echo ($filters['status'] ?? '') === 'rented' ? 'selected' : ''; ?>>Rented</option>
        </select>

        <button type="submit" class="btn btn-secondary">
            Filter
        </button>

        <a href="<?php echo BASE_URL; ?>/properties/index"
           class="btn btn-link">
            Clear
        </a>
    </form>
</div>

<?php if (!empty($properties)): ?>

<table class="table">
    <thead>
        <tr>
            <th>Property</th>
            <th>Type</th>
            <th>Listing</th>
            <th>City</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($properties as $property): ?>
        <tr>
            <td>
                <?php echo View::escape($property['title'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($property['property_type'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($property['listing_type'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($property['city'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($property['price'] ?? ''); ?>
            </td>

            <td>
                <?php echo View::escape($property['status'] ?? ''); ?>
            </td>

            <td>
                <a class="btn btn-sm"
                   href="<?php echo BASE_URL; ?>/properties/show/<?php echo (int)$property['id']; ?>">
                    View
                </a>

                <a class="btn btn-sm"
                   href="<?php echo BASE_URL; ?>/properties/edit/<?php echo (int)$property['id']; ?>">
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
    BASE_URL . '/properties/index'
); ?>

<?php else: ?>

<p>No properties found.</p>

<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>
