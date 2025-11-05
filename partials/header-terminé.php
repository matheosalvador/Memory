<!-- header start (start at the top) -->
 
<?php
//  detects the page where you are 
$currentPage = basename($_SERVER['SCRIPT_NAME']); // request the give you back index, contact, ...
?>

<header class="main-header">
    <!-- logo -->
    <a>
        <img src="<?= getBaseUrl(); ?>/assets/images/logo_memory.png" alt="logo" class="logohead">
    </a>

    <!-- player session's name -->


    <!-- navigation -->
    <nav class="nav-container" role="navigation" aria-label="Main navigation">
        <a href="<?= getBaseUrl(); ?>..\index.php" class="spaceh <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a> <!-- redirection to home page-->

        <a href="<?= getBaseUrl(); ?>..\games\memory\scores.php" class="spaceh <?= $currentPage === 'scores.php' ? 'active' : '' ?>">Scores</a> <!-- redirection to scores page-->

        <a href="<?= getBaseUrl(); ?>../contact.php" class="spaceh button-like <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact us</a> <!-- redirection to contact page-->
    </nav>
</header>
<!-- header end -->