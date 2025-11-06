<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);

?>

<header class="main-header">
    <!-- logo -->
    <a href="<?= getBaseUrl(); ?>/index.php">
        <img src="<?= getBaseUrl(); ?>/assets/images/logo_memory.png" alt="logo" class="logohead">
    </a>

      <?php if (isset($_SESSION['pseudo'])): ?>
         <div class="user-info">
            <span class="user-pseudo"><?= htmlspecialchars($_SESSION['pseudo']) ?></span>
            <span class="status-dot"></span>
         </div>
      <?php endif; ?>

    <!-- navigation -->
    <nav class="nav-container" role="navigation" aria-label="Main navigation">
        <a href="<?= getBaseUrl(); ?>/index.php" 
           class="spaceh <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>

        <a href="<?= getBaseUrl(); ?>/games/memory/scores.php"
           class="spaceh <?= $currentPage === 'scores.php' ? 'active' : '' ?>">Scores</a>

        <!-- My Account sans le rouge -->
        <a href="<?= getBaseUrl(); ?>/myAccount.php"
           class="spaceh <?= $currentPage === 'myAccount.php' ? 'active' : '' ?>">My Account</a>

        <a href="<?= getBaseUrl(); ?>/contact.php"
           class="spaceh button-like <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact us</a>
    </nav>
</header>
<!-- My Account sans le rouge -->
