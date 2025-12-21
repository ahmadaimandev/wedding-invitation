<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">RSVP Guest List</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline shadow">
            <div class="card-header">
              <h3 class="card-title">All Guest RSVPs</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="rsvpTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Guest Info</th>
                    <th>Relationship</th>
                    <th>Attendance</th>
                    <th>Pax / Diet</th>
                    <th>Message</th>
                    <th>Submitted</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Attempt to select all columns; if errors occur due to missing columns, this page might fail until update_schema.php is run
                  $res = $conn->query("SELECT * FROM rsvp ORDER BY submitted_at DESC");
                  $i = 1;
                  if ($res):
                    while ($row = $res->fetch_assoc()):
                      ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                          <strong><?php echo $row['name']; ?></strong><br>
                          <small class="text-muted"><i class="fas fa-phone mr-1"></i> <?php echo $row['phone']; ?></small>
                          <?php if (!empty($row['email'])): ?>
                            <br><small class="text-muted"><i class="fas fa-envelope mr-1"></i>
                              <?php echo $row['email']; ?></small>
                          <?php endif; ?>
                        </td>
                        <td>
                          <span class="badge badge-info"><?php echo $row['relationship'] ?? '-'; ?></span>
                        </td>
                        <td>
                          <span class="badge badge-<?php echo ($row['attendance'] == 'Yes') ? 'success' : 'danger'; ?>">
                            <?php echo $row['attendance']; ?>
                          </span>
                        </td>
                        <td>
                          <?php if ($row['attendance'] == 'Yes'): ?>
                            <strong><?php echo $row['pax']; ?> Pax</strong>
                            <?php if (!empty($row['dietary'])): ?>
                              <br><small class="text-danger"><i class="fas fa-utensils mr-1"></i>
                                <?php echo $row['dietary']; ?></small>
                            <?php else: ?>
                              <br><small class="text-success">No restrictions</small>
                            <?php endif; ?>
                          <?php else: ?>
                            -
                          <?php endif; ?>
                        </td>
                        <td><?php echo $row['message'] ?: '-'; ?></td>
                        <td><?php echo formatDate($row['submitted_at']); ?></td>
                      </tr>
                    <?php endwhile; endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<?php require_once '../includes/footer.php'; ?>

<script>
  $(function () {
    $("#rsvpTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#rsvpTable_wrapper .col-md-6:eq(0)');
  });
</script>