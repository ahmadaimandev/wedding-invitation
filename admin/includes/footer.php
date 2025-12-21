<!-- Main Footer -->
<footer class="main-footer">
  <strong>Copyright &copy; 2025 <a href="#">Wedding Invitation</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<!-- Global JS Functions -->
<script>
  function confirmLogout() {
    Swal.fire({
      title: 'Ready to Leave?',
      text: "You will need to login again to access the admin panel.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#bfa181',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'No, stay'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?php echo BASE_URL; ?>admin/logout.php';
      }
    });
  }

  // Dark Mode Toggle Logic
  const darkModeToggle = document.getElementById('darkModeToggle');
  const body = document.body;
  const icon = darkModeToggle.querySelector('i');

  // Check for saved preference
  if (localStorage.getItem('dark-mode') === 'enabled') {
    body.classList.add('dark-mode');
    icon.classList.replace('fa-moon', 'fa-sun');
  }

  darkModeToggle.addEventListener('click', (e) => {
    e.preventDefault();
    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
      localStorage.setItem('dark-mode', 'enabled');
      icon.classList.replace('fa-moon', 'fa-sun');
    } else {
      localStorage.setItem('dark-mode', 'disabled');
      icon.classList.replace('fa-sun', 'fa-moon');
    }
  });
</script>

<!-- Session Alerts -->
<?php if (isset($_SESSION['success'])): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: '<?php echo $_SESSION['success']; ?>',
      timer: 3000,
      showConfirmButton: false
    });
  </script>
  <?php unset($_SESSION['success']);
endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: '<?php echo $_SESSION['error']; ?>',
    });
  </script>
  <?php unset($_SESSION['error']);
endif; ?>

</body>

</html>