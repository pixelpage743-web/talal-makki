<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "portfolio";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connect Error: " . $conn->connect_error);
}

function redirect($to) {
    header("Location: $to");
    exit;
}

// Admin Login Handling
if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u === 'admin' && $p === '1234') {
        $_SESSION['admin'] = true;
        $_SESSION['message'] = "Logged in successfully!";
        redirect('admin.php');
    } else {
        $_SESSION['error'] = "Invalid credentials.";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    redirect('admin.php');
}

// Delete Skill
if (isset($_GET['delete_skill']) && isset($_SESSION['admin'])) {
    $id = intval($_GET['delete_skill']);
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Skill deleted.";
    redirect('admin.php');
}

// Delete Project
if (isset($_GET['delete_project']) && isset($_SESSION['admin'])) {
    $id = intval($_GET['delete_project']);

    // Delete image file from uploads
    $res = $conn->query("SELECT image FROM projects WHERE id = $id");
    if ($res && $res->num_rows) {
        $row = $res->fetch_assoc();
        $imgPath = "uploads/" . $row['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Project deleted.";
    redirect('admin.php');
}

// Delete Message
if (isset($_GET['delete_message']) && isset($_SESSION['admin'])) {
    $id = intval($_GET['delete_message']);
    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Message deleted.";
    redirect('admin.php');
}

// Add Skill
if (isset($_POST['add_skill']) && isset($_SESSION['admin'])) {
    $n = $_POST['skill_name'];
    $l = $_POST['skill_level'];
    $stmt = $conn->prepare("INSERT INTO skills (name, level) VALUES (?, ?)");
    $stmt->bind_param("ss", $n, $l);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Skill added.";
    redirect('admin.php');
}

// Add Project (With file upload and link)
if (isset($_POST['add_project']) && isset($_SESSION['admin'])) {
    $t = $_POST['proj_title'];
    $link = $_POST['proj_link'];

    if (isset($_FILES['proj_image']) && $_FILES['proj_image']['error'] === 0) {
        $imgName = basename($_FILES['proj_image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . time() . "_" . $imgName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowed)) {
            $_SESSION['error'] = "Only JPG, PNG, GIF files allowed.";
            redirect('admin.php');
        }

        if (move_uploaded_file($_FILES['proj_image']['tmp_name'], $targetFile)) {
            $filename = basename($targetFile);
            $stmt = $conn->prepare("INSERT INTO projects (title, image, link) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $t, $filename, $link);
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "Project added.";
            redirect('admin.php');
        } else {
            $_SESSION['error'] = "Failed to upload image.";
        }
    } else {
        $_SESSION['error'] = "Image not uploaded.";
    }
}

// Fetch data
$skills = $conn->query("SELECT * FROM skills");
$projects = $conn->query("SELECT * FROM projects");
$messages = $conn->query("SELECT * FROM contact ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - Talal Makki Portfolio</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <style>
        .project-image {
            max-width: 200px;
            height: auto;
            display: block;
            margin-top: 5px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
        input.contact__input {
            margin-bottom: 10px;
        }
        ul.messages-list {
            list-style: none;
            padding: 0;
        }
        ul.messages-list li {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        ul.messages-list li strong {
            font-size: 1.1em;
        }
        ul.messages-list li a {
            margin-right: 15px;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<header class="l-header">
    <nav class="nav bd-grid">
        <div><a href="index.php" class="nav__logo">Talal Makki</a></div>
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item"><a href="index.php#home" class="nav__link">Home</a></li>
                <?php if (isset($_SESSION['admin'])): ?>
                    <li class="nav__item"><a href="admin.php?logout=1" class="nav__link">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="nav__toggle" id="nav-toggle"><i class='bx bx-menu'></i></div>
    </nav>
</header>

<main class="l-main" style="padding: 2rem; max-width: 700px; margin: auto;">

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['admin'])): ?>
        <h2 class="section-title">Admin Login</h2>
        <form method="POST" style="max-width:300px; margin:auto;">
            <input type="text" name="username" placeholder="Username" class="contact__input" required>
            <input type="password" name="password" placeholder="Password" class="contact__input" required>
            <input type="submit" name="login" value="Login" class="contact__button button">
        </form>
    <?php else: ?>
        <h2 class="section-title">Admin Panel</h2>

        <h3>Add Skill</h3>
        <form method="POST">
            <input type="text" name="skill_name" placeholder="Skill Name" class="contact__input" required>
            <input type="text" name="skill_level" placeholder="Level (e.g., 85%)" class="contact__input" required>
            <input type="submit" name="add_skill" value="Add Skill" class="contact__button button">
        </form>

        <h3>Add Project</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="proj_title" placeholder="Project Title" class="contact__input" required>
            <input type="url" name="proj_link" placeholder="Project Link (https://example.com)" class="contact__input" required>
            <input type="file" name="proj_image" accept="image/*" class="contact__input" required>
            <input type="submit" name="add_project" value="Add Project" class="contact__button button">
        </form>

        <h3>Current Skills</h3>
        <ul>
            <?php foreach ($skills as $r): ?>
                <li>
                    <?php echo htmlspecialchars($r['name']) . " (" . htmlspecialchars($r['level']) . ")"; ?>
                    <a href="?delete_skill=<?php echo $r['id']; ?>" style="color:red; margin-left:10px;" onclick="return confirm('Delete skill <?php echo htmlspecialchars($r['name']); ?>?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3>Current Projects</h3>
        <ul>
            <?php foreach ($projects as $r): ?>
                <li>
                    <strong><?php echo htmlspecialchars($r['title']); ?></strong><br>
                    <a href="<?php echo htmlspecialchars($r['link']); ?>" target="_blank" rel="noopener noreferrer">
                        <img src="uploads/<?php echo htmlspecialchars($r['image']); ?>" class="project-image" alt="Project Image">
                    </a>
                    <a href="?delete_project=<?php echo $r['id']; ?>" style="color:red;" onclick="return confirm('Delete project <?php echo htmlspecialchars($r['title']); ?>?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3>Contact Messages</h3>
        <?php if ($messages->num_rows > 0): ?>
            <ul class="messages-list">
                <?php while ($msg = $messages->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($msg['name']); ?> (<?php echo htmlspecialchars($msg['email']); ?>)</strong><br>
                        <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="contact__button button">Reply</a>
                        <a href="?delete_message=<?php echo $msg['id']; ?>" style="color:red;" onclick="return confirm('Delete this message?');">Delete</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>

    <?php endif; ?>

</main>

<footer class="footer" style="text-align:center; padding: 1rem;">
    <p class="footer__copy">&#169; All rights reserved</p>
</footer>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
