<?php
// --- 1. DATABASE CONNECTION ---
// Make sure this path is correct!
include '../Database/db_connect.php'; 

$message = ''; // For user feedback

// --- 2. HELPER FUNCTION FOR FILE UPLOADS ---
function handleFileUpload($file, $subfolder) {
    if (empty($file['name'])) {
        return ['success' => false, 'error' => 'No image file was uploaded.'];
    }
    $base_upload_dir = "../photos/";
    $target_dir = $base_upload_dir . $subfolder . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_name = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $file_name;
    $db_path = "../photos/" . $subfolder . "/" . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ['success' => false, 'error' => 'File is not an image.'];
    }
    if ($file["size"] > 5000000) {
        return ['success' => false, 'error' => 'Sorry, your file is too large.'];
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
        return ['success' => false, 'error' => 'Sorry, only JPG, JPEG, PNG & WEBP files are allowed.'];
    }
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ['success' => true, 'path' => $db_path];
    } else {
        return ['success' => false, 'error' => 'Sorry, there was an error uploading your file.'];
    }
}

// --- 3. HANDLE DELETE REQUESTS ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    $table_map = [
        'gallery' => ['table' => 'gallery', 'id_col' => 'image_id', 'img_col' => 'image_path'],
        'blog'    => ['table' => 'blogs', 'id_col' => 'post_id', 'img_col' => 'image_path'],
        'award'   => ['table' => 'awards', 'id_col' => 'award_id', 'img_col' => 'image_path'],
        'project' => ['table' => 'upcoming', 'id_col' => 'project_id', 'img_col' => 'image_path']
    ];
    if (array_key_exists($type, $table_map)) {
        $map = $table_map[$type];
        $stmt = $conn->prepare("SELECT {$map['img_col']} FROM {$map['table']} WHERE {$map['id_col']} = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_to_delete = $row[$map['img_col']];
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
        }
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM {$map['table']} WHERE {$map['id_col']} = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">Item deleted successfully.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error deleting record: ' . $conn->error . '
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        $stmt->close();
    }
}

// --- 4. HANDLE ADD/POST REQUESTS ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
    // Shared success/error message templates
    $success_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">New %s added!
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $error_db_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Database error: ' . $conn->error . '
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $error_upload_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">%s
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

    switch ($action) {
        case 'add_gallery':
            $upload = handleFileUpload($_FILES['image'], 'gallery');
            if ($upload['success']) {
                $stmt = $conn->prepare("INSERT INTO gallery (image_path, image_alt, category) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $upload['path'], $_POST['image_alt'], $_POST['category']);
                $message = $stmt->execute() ? sprintf($success_msg, "gallery image") : $error_db_msg;
                $stmt->close();
            } else {
                $message = sprintf($error_upload_msg, $upload['error']);
            }
            break;
        case 'add_blog':
            $upload = handleFileUpload($_FILES['image'], 'blogs');
            if ($upload['success']) {
                $stmt = $conn->prepare("INSERT INTO blogs (image_path, image_alt, title, post_date, summary, read_more_link) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $upload['path'], $_POST['image_alt'], $_POST['title'], $_POST['post_date'], $_POST['summary'], '#');
                $message = $stmt->execute() ? sprintf($success_msg, "blog post") : $error_db_msg;
                $stmt->close();
            } else {
                $message = sprintf($error_upload_msg, $upload['error']);
            }
            break;
        case 'add_award':
            $upload = handleFileUpload($_FILES['image'], 'awards');
            if ($upload['success']) {
                $stmt = $conn->prepare("INSERT INTO awards (image_path, title, year_received, description) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $upload['path'], $_POST['title'], $_POST['year_received'], $_POST['description']);
                $message = $stmt->execute() ? sprintf($success_msg, "award") : $error_db_msg;
                $stmt->close();
            } else {
                $message = sprintf($error_upload_msg, $upload['error']);
            }
            break;
        case 'add_project':
            $upload = handleFileUpload($_FILES['image'], 'upcoming');
            if ($upload['success']) {
                $stmt = $conn->prepare("INSERT INTO upcoming (status, image_path, image_alt, title, description, est_completion, modal_target) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $_POST['status'], $upload['path'], $_POST['image_alt'], $_POST['title'], $_POST['description'], $_POST['est_completion'], '#');
                $message = $stmt->execute() ? sprintf($success_msg, "project") : $error_db_msg;
                $stmt->close();
            } else {
                $message = sprintf($error_upload_msg, $upload['error']);
            }
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Content Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        /* Based on your screenshots */
        :root {
            --brand-font: 'Playfair Display', serif;
            --body-font: 'Poppins', sans-serif;
            --brand-gold: #D4AF37; /* A more subtle gold/brown */
            --brand-dark: #8B4513;
            --brand-light: #f9f9f9;
            --brand-white: #ffffff;
        }
        body {
            background-color: var(--brand-light);
            font-family: var(--body-font);
        }
        /* --- Header/Navbar --- */
        .admin-navbar {
            background-color: var(--brand-white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 0.75rem 1.5rem;
        }
        .admin-navbar .navbar-brand {
            font-family: var(--brand-font);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--brand-dark);
        }
        .admin-navbar .navbar-brand span {
            color: var(--brand-gold);
            font-weight: 400;
        }
        .admin-navbar .form-control {
            border-radius: 20px;
            background-color: #f8f9fa;
        }
        .admin-navbar .nav-link {
            color: #6c757d;
            font-size: 1.25rem;
            padding: 0 0.75rem;
        }
        .admin-navbar .dropdown-toggle::after {
            display: none;
        }
        .admin-navbar .admin-name {
            font-size: 0.9rem;
            color: var(--brand-dark);
        }
        .admin-navbar .badge {
            font-size: 0.6rem;
            position: absolute;
            top: 10px;
            right: 5px;
        }

        /* --- Page Title --- */
        .page-title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .page-title {
            font-family: var(--brand-font);
            font-size: 2.5rem;
            color: var(--brand-dark);
            margin: 0;
        }
        .page-title-underline {
            width: 70px;
            height: 4px;
            background-color: var(--brand-gold);
            margin-top: 8px;
        }
        .btn-brand {
            background-color: var(--brand-dark);
            border-color: var(--brand-gold);
            color: var(--brand-white);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 0.25rem;
        }
        .btn-brand:hover {
            background-color: #9a7450;
            border-color: #9a7450;
            color: var(--brand-white);
        }

        /* --- Tabs & Content --- */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            font-family: var(--body-font);
            font-weight: 500;
            color: #6c757d;
            border: 0;
            border-bottom: 3px solid transparent;
            padding: 0.75rem 1.25rem;
        }
        .nav-tabs .nav-link.active {
            color: var(--brand-dark);
            border-bottom: 3px solid var(--brand-gold);
            background-color: transparent;
        }
        .tab-pane {
            background: var(--brand-white);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-top: 1.5rem;
        }

        /* --- Table Style --- */
        .table-preview-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: .375rem;
        }
        .table {
            vertical-align: middle;
        }
        .table thead th {
            font-weight: 500;
            color: #495057;
        }
        
        /* --- Gallery Card Grid Style --- */
        .gallery-grid-admin .card {
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            height: 100%;
            transition: all 0.3s ease;
        }
        .gallery-grid-admin .card:hover {
             box-shadow: 0 5px 15px rgba(0,0,0,0.07);
        }
        .gallery-grid-admin .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .gallery-grid-admin .card-body {
            display: flex;
            flex-direction: column;
        }
        .gallery-grid-admin .card-title {
            font-weight: 600;
        }
        .gallery-grid-admin .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .gallery-grid-admin .mt-auto {
            margin-top: 1rem !important;
        }

        /* --- Modal Style --- */
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        .modal-title {
            font-family: var(--brand-font);
            font-weight: 700;
        }
    </style>
</head>
<body>

<nav class="admin-navbar navbar navbar-expand navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            Royal <span>Star</span> Resort
        </a>

        <form class="d-none d-md-flex input-group w-auto my-auto">
            <input autocomplete="off" type="search" class="form-control" placeholder="Search..." />
            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
        </form>

        <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="badge rounded-pill badge-notification bg-danger">3</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-2"></i>
                    <span class="admin-name d-none d-sm-block">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">My profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid mt-4 px-4">
    
    <div class="page-title-container">
        <div>
            <h2 class="page-title">Website Content Management</h2>
            <div class="page-title-underline"></div>
        </div>
        <div class="action-buttons">
            <button class="btn btn-brand" id="addGalleryButton" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                <i class="fas fa-plus me-1"></i> Add New Image
            </button>
            <button class="btn btn-brand" id="addBlogButton" data-bs-toggle="modal" data-bs-target="#addBlogModal" style="display: none;">
                <i class="fas fa-plus me-1"></i> Add New Post
            </button>
            <button class="btn btn-brand" id="addAwardButton" data-bs-toggle="modal" data-bs-target="#addAwardModal" style="display: none;">
                <i class="fas fa-plus me-1"></i> Add New Award
            </button>
            <button class="btn btn-brand" id="addProjectButton" data-bs-toggle="modal" data-bs-target="#addProjectModal" style="display: none;">
                <i class="fas fa-plus me-1"></i> Add New Project
            </button>
        </div>
    </div>
    
    <?php echo $message; ?>

    <ul class="nav nav-tabs" id="manageTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="true"><i class="fas fa-images me-2"></i>Gallery</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog" type="button" role="tab" aria-controls="blog" aria-selected="false"><i class="fas fa-blog me-2"></i>Blog</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="awards-tab" data-bs-toggle="tab" data-bs-target="#awards" type="button" role="tab" aria-controls="awards" aria-selected="false"><i class="fas fa-award me-2"></i>Awards</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="false"><i class="fas fa-tasks me-2"></i>Upcoming Projects</button>
        </li>
    </ul>

    <div class="tab-content" id="manageTabsContent">
        
        <div class="tab-pane fade show active" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
            <div class="row gallery-grid-admin g-4">
                <?php
                $result = $conn->query("SELECT * FROM gallery ORDER BY image_id DESC");
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()):
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['image_alt']); ?>">
                        <div class="card-body">
                            <h6 class="card-title"><?php echo htmlspecialchars($row['image_alt']); ?></h6>
                            <p class="card-text">
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span>
                            </p>
                            <a href="?action=delete&type=gallery&id=<?php echo $row['image_id']; ?>" class="btn btn-outline-danger btn-sm mt-auto" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                    echo '<p class="text-center">No images found in the gallery. Click "Add New Image" to get started.</p>';
                endif;
                ?>
            </div>
        </div>

        <div class="tab-pane fade" id="blog" role="tabpanel" aria-labelledby="blog-tab">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Summary</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM blogs ORDER BY post_id DESC");
                        if ($result->num_rows > 0):
                            while($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="table-preview-img" alt="<?php echo htmlspecialchars($row['image_alt']); ?>"></td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><?php echo substr(htmlspecialchars($row['summary']), 0, 100); ?>...</td>
                            <td><?php echo date("M j, Y", strtotime($row['post_date'])); ?></td>
                            <td class="text-end">
                                <a href="?action=delete&type=blog&id=<?php echo $row['post_id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                            echo '<tr><td colspan="5" class="text-center">No blog posts found. Click "Add New Post" to get started.</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="awards" role="tabpanel" aria-labelledby="awards-tab">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Year</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM awards ORDER BY award_id DESC");
                        if ($result->num_rows > 0):
                            while($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="table-preview-img" alt="<?php echo htmlspecialchars($row['title']); ?>"></td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><span class="badge bg-dark"><?php echo htmlspecialchars($row['year_received']); ?></span></td>
                            <td><?php echo substr(htmlspecialchars($row['description']), 0, 100); ?>...</td>
                            <td class="text-end">
                                <a href="?action=delete&type=award&id=<?php echo $row['award_id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                            echo '<tr><td colspan="5" class="text-center">No awards found. Click "Add New Award" to get started.</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
           <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Est. Completion</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM upcoming ORDER BY project_id DESC");
                        if ($result->num_rows > 0):
                            while($row = $result->fetch_assoc()):
                                $status_class = 'bg-secondary';
                                if($row['status'] == 'in-progress') $status_class = 'bg-info text-dark';
                                if($row['status'] == 'opening-soon') $status_class = 'bg-success';
                        ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="table-preview-img" alt="<?php echo htmlspecialchars($row['image_alt']); ?>"></td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['est_completion']); ?></td>
                            <td class="text-end">
                                <a href="?action=delete&type=project&id=<?php echo $row['project_id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                             echo '<tr><td colspan="5" class="text-center">No projects found. Click "Add New Project" to get started.</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> </div> <div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addGalleryModalLabel">Add New Gallery Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
                <input type="hidden" name="action_type" value="add_gallery">
                <div class="mb-3">
                    <label for="g-category" class="form-label">Category</label>
                    <select class="form-select" id="g-category" name="category" required>
                        <option value="rooms">Rooms</option>
                        <option value="dining">Dining</option>
                        <option value="spa">Spa</option>
                        <option value="pool">Pool / Kids Park</option>
                        <option value="events">Events</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="g-alt" class="form-label">Alt Text (Description)</label>
                    <input type="text" class="form-control" id="g-alt" name="image_alt" required>
                </div>
                <div class="mb-3">
                    <label for="g-image" class="form-label">Image File</label>
                    <input class="form-control" type="file" id="g-image" name="image" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-brand">Add to Gallery</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBlogModalLabel">Add New Blog Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
                <input type="hidden" name="action_type" value="add_blog">
                <div class="mb-3">
                    <label for="b-title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="b-title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="b-date" class="form-label">Post Date</label>
                    <input type="date" class="form-control" id="b-date" name="post_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="b-summary" class="form-label">Summary</label>
                    <textarea class="form-control" id="b-summary" name="summary" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="b-alt" class="form-label">Image Alt Text</label>
                    <input type="text" class="form-control" id="b-alt" name="image_alt" required>
                </div>
                <div class="mb-3">
                    <label for="b-image" class="form-label">Image File</label>
                    <input class="form-control" type="file" id="b-image" name="image" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-brand">Add Blog Post</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addAwardModal" tabindex="-1" aria-labelledby="addAwardModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAwardModalLabel">Add New Award</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
                <input type="hidden" name="action_type" value="add_award">
                <div class="mb-3">
                    <label for="a-title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="a-title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="a-year" class="form-label">Year Received</label>
                    <input type="text" class="form-control" id="a-year" name="year_received" placeholder="e.g., 2025 or 2024-2025" required>
                </div>
                <div class="mb-3">
                    <label for="a-desc" class="form-label">Description</label>
                    <textarea class="form-control" id="a-desc" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="a-image" class="form-label">Image File</label>
                    <input class="form-control" type="file" id="a-image" name="image" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-brand">Add Award</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProjectModalLabel">Add Upcoming Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
                <input type="hidden" name="action_type" value="add_project">
                <div class="mb-3">
                    <label for="p-title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="p-title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="p-status" class="form-label">Status</label>
                    <select class="form-select" id="p-status" name="status" required>
                        <option value="planning">Planning</option>
                        <option value="in-progress">In Progress</option>
                        <option value="opening-soon">Opening Soon</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="p-desc" class="form-label">Description</label>
                    <textarea class="form-control" id="p-desc" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="p-comp" class="form-label">Est. Completion</label>
                    <input type="text" class="form-control" id="p-comp" name="est_completion" placeholder="e.g., Q4 2025" required>
                </div>
                <div class="mb-3">
                    <label for="p-alt" class="form-label">Image Alt Text</label>
                    <input type="text" class="form-control" id="p-alt" name="image_alt" required>
                </div>
                <div class="mb-3">
                    <label for="p-image" class="form-label">Image File</label>
                    <input class="form-control" type="file" id="p-image" name="image" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-brand">Add Project</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('#manageTabs .nav-link');
    const actionButtons = {
        'gallery-tab': document.getElementById('addGalleryButton'),
        'blog-tab': document.getElementById('addBlogButton'),
        'awards-tab': document.getElementById('addAwardButton'),
        'projects-tab': document.getElementById('addProjectButton')
    };

    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            // Hide all buttons
            Object.values(actionButtons).forEach(btn => btn.style.display = 'none');
            
            // Show the specific button for the active tab
            const activeTabId = event.target.id;
            if (actionButtons[activeTabId]) {
                actionButtons[activeTabId].style.display = 'inline-block';
            }
        });
    });
});
</script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>