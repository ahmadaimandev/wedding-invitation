<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Handle Text Settings
    $settings = [
        'couple_names' => $_POST['couple_names'],
        'wedding_date' => $_POST['wedding_date'],
        'venue_name' => $_POST['venue_name'],
        'venue_address' => $_POST['venue_address'],
        'map_link' => $_POST['map_link']
    ];

    foreach ($settings as $key => $val) {
        $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->bind_param("ss", $val, $key);
        $stmt->execute();
    }

    $error_occurred = false;

    // 2. Handle Favicon Upload
    if (!empty($_FILES['favicon']['name'])) {
        $target_dir = "../../assets/uploads/settings/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES["favicon"]["name"], PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg', 'ico', 'svg'];

        if (in_array($file_extension, $allowed)) {
            $new_filename = "favicon_" . time() . "." . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file)) {
                $db_path = "assets/uploads/settings/" . $new_filename;

                // Check if key exists
                $check = $conn->query("SELECT setting_key FROM site_settings WHERE setting_key = 'favicon_path'");
                if ($check->num_rows > 0) {
                    $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'favicon_path'");
                } else {
                    $stmt = $conn->prepare("INSERT INTO site_settings (setting_value, setting_key) VALUES (?, 'favicon_path')");
                }
                $stmt->bind_param("s", $db_path);
                $stmt->execute();
            }
        } else {
            $_SESSION['error'] = "Invalid file type for favicon. Only PNG, JPG, ICO, and SVG are allowed.";
            $error_occurred = true;
        }
    }

    if (!$error_occurred) {
        $_SESSION['success'] = "Global settings updated successfully!";
    }

    // Redirect to prevent form resubmission and show SweetAlert
    header("Location: index.php");
    exit();
}

// Fetch Current Settings
$current_settings = [];
$res = $conn->query("SELECT * FROM site_settings");
while ($row = $res->fetch_assoc()) {
    $current_settings[$row['setting_key']] = $row['setting_value'];
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Global Settings</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">General Information</h3>
                        </div>
                        <!-- Added enctype for file upload -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="couple_names">Couple Names (e.g. Romeo & Juliet)</label>
                                            <input type="text" class="form-control" id="couple_names"
                                                name="couple_names"
                                                value="<?php echo htmlspecialchars($current_settings['couple_names'] ?? ''); ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="wedding_date">Wedding Date & Time</label>
                                            <input type="datetime-local" class="form-control" id="wedding_date"
                                                name="wedding_date"
                                                value="<?php echo isset($current_settings['wedding_date']) ? date('Y-m-d\TH:i', strtotime($current_settings['wedding_date'])) : ''; ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="venue_name">Venue Name</label>
                                            <input type="text" class="form-control" id="venue_name" name="venue_name"
                                                value="<?php echo htmlspecialchars($current_settings['venue_name'] ?? ''); ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="venue_address">Venue Address</label>
                                            <input type="text" class="form-control" id="venue_address"
                                                name="venue_address"
                                                value="<?php echo htmlspecialchars($current_settings['venue_address'] ?? ''); ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="map_link">Google Maps Link</label>
                                            <input type="url" class="form-control" id="map_link" name="map_link"
                                                value="<?php echo htmlspecialchars($current_settings['map_link'] ?? ''); ?>"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label>Site Favicon</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="border rounded p-2 mr-3"
                                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                            <?php if (!empty($current_settings['favicon_path'])): ?>
                                                <img src="<?php echo BASE_URL . $current_settings['favicon_path']; ?>"
                                                    id="favicon-preview" style="max-width: 100%; max-height: 100%;">
                                            <?php else: ?>
                                                <i class="fas fa-image text-muted" id="favicon-placeholder"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="custom-file flex-grow-1">
                                            <input type="file" class="custom-file-input" id="favicon" name="favicon"
                                                accept="image/*">
                                            <label class="custom-file-label" for="favicon">Choose new favicon...</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Recommended size: 32x32 or 64x64 pixels. Formats: PNG,
                                        ICO, SVG.</small>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Help</h3>
                        </div>
                        <div class="card-body">
                            <p>These settings are used globally across the landing page.</p>
                            <ul>
                                <li><strong>Couple Names:</strong> Appears in Hero, Navbar, and Footer.</li>
                                <li><strong>Wedding Date:</strong> Updates the countdown timer automatically.</li>
                                <li><strong>Venue:</strong> Shown in the "Location" section.</li>
                                <li><strong>Favicon:</strong> The small icon shown in the browser tab.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
<script>
    // Custom File Input Label Fix
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

        // Preview
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#favicon-placeholder').hide();
                if ($('#favicon-preview').length) {
                    $('#favicon-preview').attr('src', e.target.result);
                } else {
                    $('.border.rounded.p-2.mr-3').html('<img src="' + e.target.result + '" id="favicon-preview" style="max-width: 100%; max-height: 100%;">');
                }
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>