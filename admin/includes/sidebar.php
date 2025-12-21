<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo BASE_URL; ?>admin/dashboard.php" class="brand-link text-center py-4">
    <i class="fas fa-heart text-primary"></i>
    <span class="brand-text">Wedding Suite</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user-circle fa-2x text-primary"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block text-dark font-weight-bold"
          style="line-height: 1;">@<?php echo $_SESSION['admin_username']; ?></a>
        <span class="badge badge-success px-2 py-0" style="font-size: 0.65rem; text-transform: uppercase;">Active</span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/dashboard.php"
            class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/rsvp/index.php"
            class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], '/rsvp/') !== false) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>RSVP List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/wishes/index.php"
            class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], '/wishes/') !== false) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-comment-dots"></i>
            <p>Wishes Moderation</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/gallery/index.php"
            class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], '/gallery/') !== false) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-images"></i>
            <p>Gallery Manager</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/settings/index.php"
            class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], '/settings/') !== false) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Global Settings</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>admin/users/index.php"
            class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], '/users/') !== false) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Manage Admins</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>