<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';

// Handle Actions
if (isset($_GET['ajax_action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $status = '';

    if ($_GET['ajax_action'] == 'approve')
        $status = 'approved';
    if ($_GET['ajax_action'] == 'hide')
        $status = 'hidden';

    if ($status) {
        $stmt = $conn->prepare("UPDATE rsvp SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        echo json_encode(['status' => 'success']);
        exit;
    }
}

// Handle Delete
if (isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    // We only clear the message, not the whole RSVP record, to keep guest data
    $stmt = $conn->prepare("UPDATE rsvp SET message = NULL, status = 'hidden' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Wishes Moderation</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Pending / All Wishes</h3>
                </div>
                <div class="card-body">
                    <table id="wishesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest Name</th>
                                <th>Message</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $wishes = $conn->query("SELECT * FROM rsvp WHERE message IS NOT NULL AND message != '' ORDER BY submitted_at DESC");
                            while ($row = $wishes->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                        <small class="text-muted"><?php echo formatDate($row['submitted_at']); ?></small>
                                    </td>
                                    <td>
                                        <p class="mb-0">"<?php echo htmlspecialchars($row['message']); ?>"</p>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'approved'): ?>
                                            <span class="badge badge-success">Visible</span>
                                        <?php elseif ($row['status'] == 'hidden'): ?>
                                            <span class="badge badge-secondary">Hidden</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center action-icons">
                                        <div class="btn-group">
                                            <?php if ($row['status'] != 'approved'): ?>
                                                <button class="btn btn-success"
                                                    onclick="handleAction('approve', <?php echo $row['id']; ?>)"
                                                    title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($row['status'] != 'hidden'): ?>
                                                <button class="btn btn-warning"
                                                    onclick="handleAction('hide', <?php echo $row['id']; ?>)" title="Hide">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php endif; ?>

                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Remove Message">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        $("#wishesTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "order": [[0, "desc"]]
        });
    });

    function handleAction(action, id) {
        let title = action === 'approve' ? 'Approve Wish?' : 'Hide Wish?';
        let text = action === 'approve' ? 'This message will be visible on the landing page.' : 'This message will be hidden from the landing page.';
        let icon = action === 'approve' ? 'question' : 'warning';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#ffc107',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'index.php',
                    type: 'GET',
                    data: { ajax_action: action, id: id },
                    success: function (response) {
                        Swal.fire(
                            action === 'approve' ? 'Approved!' : 'Hidden!',
                            'The status has been updated.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Message?',
            text: "The guest info stays, but the text message will be gone forever!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: { delete_id: id },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'The message has been removed.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        })
    }
</script>