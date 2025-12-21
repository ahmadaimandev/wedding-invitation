<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Admins</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus"></i> Add New Admin
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Contact Info</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = $result->fetch_assoc()): ?>
                                <tr id="row-<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td class="full-name"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td class="username"><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td>
                                        <?php if (!empty($row['email']))
                                            echo '<i class="fas fa-envelope text-muted mr-1"></i> ' . htmlspecialchars($row['email']) . '<br>'; ?>
                                        <?php if (!empty($row['phone']))
                                            echo '<i class="fas fa-phone text-muted mr-1"></i> ' . htmlspecialchars($row['phone']); ?>
                                    </td>
                                    <td class="status-cell">
                                        <?php if ($row['status'] == 'active'): ?>
                                            <span class="badge badge-success px-3 py-2">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary px-3 py-2">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center action-icons">
                                        <div class="btn-group">
                                            <button class="btn btn-info"
                                                onclick="viewUser(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                                                title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-primary"
                                                onclick="editUser(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                                                title="Edit Admin">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <?php if ($row['username'] != 'admin'): ?>
                                                <?php if ($row['status'] == 'active'): ?>
                                                    <button class="btn btn-warning"
                                                        onclick="toggleStatus(<?php echo $row['id']; ?>, 'inactive')"
                                                        title="Set Inactive">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-success"
                                                        onclick="toggleStatus(<?php echo $row['id']; ?>, 'active')"
                                                        title="Set Active">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <button class="btn btn-danger" onclick="deleteAdmin(<?php echo $row['id']; ?>)"
                                                    title="Delete Admin">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
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

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-user-shield mr-2"></i> Admin Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-3x text-info"></i>
                    </div>
                    <h4 id="v-full_name" class="mb-1 fw-bold"></h4>
                    <span class="badge badge-pill badge-info px-3" id="v-role">Administrator</span>
                </div>
                <hr>
                <div class="row px-3">
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block font-weight-bold">Username</small>
                        <span id="v-username" class="font-weight-bold"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block font-weight-bold">IC Number</small>
                        <span id="v-ic_number" class="font-weight-bold"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block font-weight-bold">Email Address</small>
                        <span id="v-email" class="font-weight-bold"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block font-weight-bold">Phone Number</small>
                        <span id="v-phone" class="font-weight-bold"></span>
                    </div>
                    <div class="col-12 mb-3">
                        <small class="text-muted d-block font-weight-bold">Account Created</small>
                        <span id="v-created_at" class="font-weight-bold"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="adminForm" action="save_user.php" method="POST">
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-user-plus mr-2"></i> Add New Admin</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="f-username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="full_name" id="f-full_name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>IC Number</label>
                                <input type="text" class="form-control" name="ic_number" id="f-ic_number"
                                    placeholder="e.g. 900101-14-1234">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" id="f-email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="f-phone">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password <span id="passReq" class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="f-password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass()">
                                            <i class="fas fa-eye" id="passEye"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted" id="passHint">Password is required for new accounts.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Save Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        $("#usersTable").DataTable({
            "responsive": true, "autoWidth": false,
        });
    });

    function togglePass() {
        const p = $('#f-password');
        const e = $('#passEye');
        if (p.attr('type') === 'password') {
            p.attr('type', 'text');
            e.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            p.attr('type', 'password');
            e.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    function viewUser(u) {
        $('#v-full_name').text(u.full_name);
        $('#v-username').text(u.username);
        $('#v-ic_number').text(u.ic_number || '-');
        $('#v-email').text(u.email || '-');
        $('#v-phone').text(u.phone || '-');
        $('#v-created_at').text(u.created_at);
        $('#viewUserModal').modal('show');
    }

    function editUser(u) {
        $('#modalTitle').html('<i class="fas fa-user-edit mr-2"></i> Edit Admin Details');
        $('#edit-id').val(u.id);
        $('#f-username').val(u.username);
        $('#f-full_name').val(u.full_name);
        $('#f-ic_number').val(u.ic_number);
        $('#f-email').val(u.email);
        $('#f-phone').val(u.phone);
        $('#f-password').val('').removeAttr('required');
        $('#passReq').hide();
        $('#passHint').text('Leave blank to keep current password.');
        $('#btnSubmit').text('Update Admin');
        $('#addUserModal').modal('show');
    }

    // Reset modal for "Add"
    $('#addUserModal').on('hidden.bs.modal', function () {
        $('#modalTitle').html('<i class="fas fa-user-plus mr-2"></i> Add New Admin');
        $('#adminForm')[0].reset();
        $('#edit-id').val('');
        $('#f-password').attr('required', 'required');
        $('#passReq').show();
        $('#passHint').text('Password is required for new accounts.');
        $('#btnSubmit').text('Save Admin');
    });

    function toggleStatus(id, newStatus) {
        const title = newStatus === 'active' ? 'Activate Admin?' : 'Deactivate Admin?';
        const text = newStatus === 'active' ? 'This user will regain access to the admin panel.' : 'This user will be blocked from logging in.';
        const icon = newStatus === 'active' ? 'info' : 'warning';
        const confirmBtn = newStatus === 'active' ? '#28a745' : '#ffc107';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmBtn,
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'save_user.php',
                    type: 'POST',
                    data: { update_status: 1, id: id, status: newStatus },
                    success: function (res) {
                        Swal.fire('Updated!', 'Admin status has been changed.', 'success')
                            .then(() => location.reload());
                    }
                });
            }
        });
    }

    function deleteAdmin(id) {
        Swal.fire({
            title: 'Delete Permanently?',
            text: "This action cannot be undone! User data will be wiped.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, DELETE!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (res) {
                        Swal.fire('Deleted!', 'The user was removed from database.', 'success')
                            .then(() => location.reload());
                    }
                });
            }
        });
    }
</script>