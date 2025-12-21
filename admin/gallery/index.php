<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';

// Ensure status column exists
$conn->query("ALTER TABLE gallery ADD COLUMN IF NOT EXISTS status ENUM('visible', 'hidden') DEFAULT 'visible'");

// Handle Image Upload
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gallery_image'])) {
    $target_dir = "../../assets/uploads/gallery/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES["gallery_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    // Check if image file is actual image
    $check = getimagesize($_FILES["gallery_image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_file)) {
            // Save to DB (Relative Path)
            $db_path = "assets/uploads/gallery/" . $new_filename;
            $caption = $_POST['caption'] ?? '';

            $stmt = $conn->prepare("INSERT INTO gallery (image_path, caption, status) VALUES (?, ?, 'visible')");
            $stmt->bind_param("ss", $db_path, $caption);
            $stmt->execute();
            header("Location: index.php?upload=success");
            exit;
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "File is not an image.";
    }
}

// Handle Status Toggle
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $status = ($_GET['action'] == 'show') ? 'visible' : 'hidden';

    $stmt = $conn->prepare("UPDATE gallery SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Handle Delete
if (isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    // Get path to delete file
    $res = $conn->query("SELECT image_path FROM gallery WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        $file_path = "../../" . $row['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    $conn->query("DELETE FROM gallery WHERE id = $id");
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
                    <h1 class="m-0">Gallery Manager</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="row">
                <!-- Upload Form -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Upload New Photo</h3>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="gallery_image">Select Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gallery_image"
                                            name="gallery_image" required accept="image/*">
                                        <label class="custom-file-label" for="gallery_image">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="caption">Caption (Optional)</label>
                                    <input type="text" class="form-control" id="caption" name="caption"
                                        placeholder="e.g. Our First Date">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block"><i
                                        class="fas fa-cloud-upload-alt mr-1"></i> Upload</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Existing Photos -->
                <div class="col-md-8">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Gallery Items</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $gallery = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
                                if ($gallery->num_rows > 0):
                                    while ($img = $gallery->fetch_assoc()):
                                        ?>
                                        <div class="col-sm-4 mb-4">
                                            <div
                                                class="position-relative border rounded overflow-hidden shadow-sm <?php echo ($img['status'] == 'hidden') ? 'opacity-50' : ''; ?>">
                                                <div class="status-badge"
                                                    style="position: absolute; top: 5px; right: 5px; z-index: 10;">
                                                    <?php if ($img['status'] == 'visible'): ?>
                                                        <span class="badge badge-success">Visible</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Hidden</span>
                                                    <?php endif; ?>
                                                </div>
                                                <img src="<?php echo BASE_URL . $img['image_path']; ?>" class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <?php if ($img['status'] == 'visible'): ?>
                                                            <a href="?action=hide&id=<?php echo $img['id']; ?>"
                                                                class="btn btn-xs btn-warning" title="Hide image"><i
                                                                    class="fas fa-eye-slash"></i></a>
                                                        <?php else: ?>
                                                            <a href="?action=show&id=<?php echo $img['id']; ?>"
                                                                class="btn btn-xs btn-success" title="Show image"><i
                                                                    class="fas fa-eye"></i></a>
                                                        <?php endif; ?>
                                                        <button type="button" onclick="confirmDelete(<?php echo $img['id']; ?>)"
                                                            class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                    <small class="text-muted text-truncate ml-2"
                                                        style="max-width: 60%;"><?php echo htmlspecialchars($img['caption'] ?: 'No Caption'); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; else: ?>
                                    <div class="col-12 text-center text-muted py-5">
                                        <i class="fas fa-images fa-3x mb-3"></i>
                                        <p>No photos uploaded yet.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Custom File Input Label Fix
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
                            'Your image has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        })
    }

    // Success Alert for upload
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('upload')) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Image uploaded successfully.',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>