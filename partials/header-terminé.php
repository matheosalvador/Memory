<?php $currentPage = basename($_SERVER['PHP_SELF']); // detects the page where we are
?>

<!-- header start (start at the top)-->
<header>
    <img src="<?= getBaseUrl(); ?>/assets/images/logo_memory.png" alt="logo" class="logohead">
        <div class="nav-container">
            <table>
                <thead>
                    <th><a class="spaceh" <?= $currentPage == 'index.php' ? 'active' : '' ?> href="<?= getBaseUrl(); ?>../index.php"> Home</a></th> <!-- redirection to home page-->
                    <th><a class="spaceh" <?= $currentPage == 'scores.php' ? 'active' : '' ?> href="<?= getBaseUrl(); ?>../games\memory\scores.php"> Scores</a></th> <!-- redirection to scores page-->
                    <th><button> <?= $currentPage == 'contact.php' ? 'active' : '' ?> <a href="<?= getBaseUrl(); ?>../contact.php">Contact us</a></button></th> <!-- redirection to contact page-->
                </thead>
            </table>
        </div>
</header>
<!-- header end -->

<?php
// --- Détection de la page actuelle ---
$currentPage = basename($_SERVER['SCRIPT_NAME']); // renvoie "index.php", "contact.php", etc.
?>

<!-- === HEADER START === -->
<header class="main-header">
    <!-- Logo -->
    <a href="<?= getBaseUrl(); ?>index.php">
        <img src="<?= getBaseUrl(); ?>assets/images/logo_memory.png" alt="Memory logo" class="logohead">
    </a>

    <!-- Navigation -->
    <nav class="nav-container" role="navigation" aria-label="Main navigation">
        <a href="<?= getBaseUrl(); ?>index.php"
           class="spaceh <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>

        <a href="<?= getBaseUrl(); ?>games/memory/scores.php"
           class="spaceh <?= $currentPage === 'scores.php' ? 'active' : '' ?>">Scores</a>

        <a href="<?= getBaseUrl(); ?>contact.php"
           class="spaceh button-like <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact us</a>
    </nav>
</header>
<!-- === HEADER END === -->