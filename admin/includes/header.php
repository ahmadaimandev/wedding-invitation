<?php
require_once __DIR__ . '/../../auth/auth-check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  require_once __DIR__ . '/../../config/database.php';
  require_once __DIR__ . '/../../config/functions.php';
  $site_settings = getSettings($conn);
  $site_title = ($site_settings['couple_names'] ?? 'Wedding') . ' Admin';
  ?>
  <title><?php echo $site_title; ?></title>

  <!-- Favicon -->
  <?php if (!empty($site_settings['favicon_path'])): ?>
    <link rel="icon" href="<?php echo BASE_URL . $site_settings['favicon_path']; ?>">
  <?php endif; ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Custom Admin Style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/assets/css/admin-style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Dark Mode Toggle -->
        <li class="nav-item">
          <a class="nav-link" href="#" id="darkModeToggle" role="button">
            <i class="fas fa-moon"></i>
          </a>
        </li>

        <!-- Messages/Wishes Notification Dropdown -->
        <?php
        $pending_res = $conn->query("SELECT COUNT(*) as total FROM rsvp WHERE status = 'pending' AND message IS NOT NULL AND message != ''");
        $pending_count = $pending_res->fetch_assoc()['total'];

        $latest_pending = $conn->query("SELECT id, name, message FROM rsvp WHERE status = 'pending' AND message IS NOT NULL AND message != '' ORDER BY submitted_at DESC LIMIT 3");
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <?php if ($pending_count > 0): ?>
              <span class="badge badge-danger navbar-badge"><?php echo $pending_count; ?></span>
            <?php endif; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><?php echo $pending_count; ?> Pending Wishes</span>
            <div class="dropdown-divider"></div>
            <?php while ($pwish = $latest_pending->fetch_assoc()): ?>
              <a href="<?php echo BASE_URL; ?>admin/wishes/index.php" class="dropdown-item">
                <div class="media">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      <?php echo htmlspecialchars($pwish['name']); ?>
                    </h3>
                    <p class="text-sm text-muted text-truncate" style="max-width: 200px;">
                      <?php echo htmlspecialchars($pwish['message']); ?>
                    </p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            <?php endwhile; ?>
            <a href="<?php echo BASE_URL; ?>admin/wishes/index.php" class="dropdown-item dropdown-footer">See All
              Wishes</a>
          </div>
        </li>

        <!-- Admins Notification Dropdown -->
        <?php
        $admin_res = $conn->query("SELECT * FROM users WHERE status = 'active' ORDER BY full_name ASC");
        $admin_count = $admin_res->num_rows;
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-users-cog"></i>
            <span class="badge badge-info navbar-badge"><?php echo $admin_count; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><?php echo $admin_count; ?> Active Admins</span>
            <div class="dropdown-divider"></div>
            <?php while ($u = $admin_res->fetch_assoc()): ?>
              <a href="<?php echo BASE_URL; ?>admin/users/index.php" class="dropdown-item">
                <i class="fas fa-user-circle mr-2"></i> <?php echo htmlspecialchars($u['full_name']); ?>
                <span class="float-right text-muted text-sm"><?php echo htmlspecialchars($u['username']); ?></span>
              </a>
            <?php endwhile; ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo BASE_URL; ?>admin/users/index.php" class="dropdown-item dropdown-footer">Manage
              Admins</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0);" onclick="confirmLogout()" role="button">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->