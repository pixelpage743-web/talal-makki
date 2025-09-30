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

// Contact Form
if (isset($_POST['contact_submit'])) {
    $n = htmlspecialchars(trim($_POST['name']));
    $e = htmlspecialchars(trim($_POST['email']));
    $m = htmlspecialchars(trim($_POST['message']));
    if ($n && $e && $m) {
        $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $n, $e, $m);
        $stmt->execute();
        $stmt->close();
        $contact_success = "Thank you! Message submitted.";
    } else {
        $contact_error = "Please fill all fields.";
    }
}

// Fetch skills and projects for display
$skills = $conn->query("SELECT * FROM skills");
$projects = $conn->query("SELECT * FROM projects");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Portfolio Website - Talal Makki</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>

    <!-- HEADER -->
    <header class="l-header" id="home">
        <nav class="nav bd-grid">
            <div><a href="#home" class="nav__logo">Talal Makki</a></div>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="#home" class="nav__link active-link">Home</a></li>
                    <li class="nav__item"><a href="#about" class="nav__link">About</a></li>
                    <li class="nav__item"><a href="#skills" class="nav__link">Skills</a></li>
                    <li class="nav__item"><a href="#work" class="nav__link">Work</a></li>
                    <li class="nav__item"><a href="#contact" class="nav__link">Contact</a></li>
                    <li class="nav__item"><a href="admin.php" class="nav__link">Admin Login</a></li>
                </ul>
            </div>
            <div class="nav__toggle" id="nav-toggle"><i class='bx bx-menu'></i></div>
        </nav>
    </header>

    <!-- MAIN -->
    <main class="l-main">

        <!-- HOME SECTION -->
        <section class="home bd-grid" id="home">
            <div class="home__data">
                <h1 class="home__title">Hi,<br>I'm <span class="home__title-color">Talal Makki</span><br>Web Designer</h1>
                <a href="#contact" class="button">Contact</a>
            </div>
            <div class="home__img">
                <!-- Optional SVG or image -->
            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section class="about section" id="about">
            <h2 class="section-title">About</h2>
            <div class="about__container bd-grid">
                <div class="about__img"><img src="pic.webp" alt="Talal Makki"></div>
                <div>
                    <h2 class="about__subtitle">I'm Talal Makki</h2>
                    <p class="about__text">I’m Muhammad Talal Makki, a passionate web designer focused on delivering creative and professional digital solutions. I specialize in crafting elegant and user-friendly websites tailored to client needs.</p>
                </div>
            </div>
        </section>

        <!-- SKILLS SECTION -->
        <section class="skills section" id="skills">
            <h2 class="section-title">Skills</h2>
            <div class="skills__container bd-grid">
                <div>
                    <h2 class="skills__subtitle">Professional Skills</h2>
                    <p class="skills__text">I specialize in crafting modern, responsive web designs using the latest technologies.</p>
                    <?php while ($row = $skills->fetch_assoc()): ?>
                        <div class="skills__data">
                            <div class="skills__names">
                                <i class='bx bxs-paint skills__icon'></i>
                                <span class="skills__name"><?php echo htmlspecialchars($row['name']); ?></span>
                            </div>
                            <div class="skills__bar skills__custom" style="width: <?php echo htmlspecialchars($row['level']); ?>;"></div>
                            <div><span class="skills__percentage"><?php echo htmlspecialchars($row['level']); ?></span></div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div><img src="assets/img/work3.jpg" alt="Work Image" class="skills__img"></div>
            </div>
        </section>

        <!-- WORK SECTION -->
        <section class="work section" id="work">
            <h2 class="section-title">Work</h2>
            <div class="work__container bd-grid">
                <?php while ($row = $projects->fetch_assoc()): ?>
                    <?php 
                        $link = isset($row['link']) ? trim($row['link']) : '';
                        $image = isset($row['image']) ? trim($row['image']) : '';
                        $title = isset($row['title']) ? trim($row['title']) : '';

                        if (!empty($image) && !empty($title)):
                            $imgPath = "uploads/" . $image;
                    ?>
                        <?php if (filter_var($link, FILTER_VALIDATE_URL)): ?>
                            <a href="<?php echo htmlspecialchars($link); ?>" class="work__img" target="_blank" rel="noopener noreferrer" title="<?php echo htmlspecialchars($title); ?>">
                                <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                            </a>
                        <?php else: ?>
                            <div class="work__img" title="<?php echo htmlspecialchars($title); ?>">
                                <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- RESUME SECTION -->
        <section class="resume section" id="resume">
            <h2 class="section-title">Resume</h2>
            <div class="resume__container bd-grid">
                <div class="resume__img">
                    <img src="img.jpeg" alt="Talal Makki Resume" style="max-width: 100%; height: auto;">
                </div>
                <div class="resume__download">
                    <a href="cv.pdf" download class="button">Download Resume (PDF)</a>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION -->
        <section class="contact section" id="contact">
            <h2 class="section-title">Contact</h2>
            <div class="contact__container bd-grid">
                <?php if (!empty($contact_success)): ?>
                    <p style="color:green;"><?php echo $contact_success; ?></p>
                <?php elseif (!empty($contact_error)): ?>
                    <p style="color:red;"><?php echo $contact_error; ?></p>
                <?php endif; ?>
                <form method="POST" class="contact__form">
                    <input type="text" name="name" placeholder="Name" class="contact__input" required>
                    <input type="email" name="email" placeholder="Email" class="contact__input" required>
                    <textarea name="message" placeholder="Message" class="contact__input" rows="5" required></textarea>
                    <input type="submit" name="contact_submit" value="Submit" class="contact__button button">
                </form>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p class="footer__title">Talal Makki</p>
        <div class="footer__social">
            <a href="#" class="footer__icon"><i class='bx bxl-facebook'></i></a>
            <a href="#" class="footer__icon"><i class='bx bxl-instagram'></i></a>
            <a href="#" class="footer__icon"><i class='bx bxl-twitter'></i></a>
        </div>
        <p class="footer__copy">&#169; All rights reserved</p>
    </footer>

    <!-- JS -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
