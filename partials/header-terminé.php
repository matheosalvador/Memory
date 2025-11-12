<header class="main-header">
    <a href="<?= getBaseUrl(); ?>/index.php">
        <img src="<?= getBaseUrl(); ?>/assets/images/logo_memory.png" alt="logo" class="logohead">
    </a>

    <div class="header-right">
        <?php if (isset($_SESSION['pseudo'])): ?>
            <div class="user-info">
                <span class="user-pseudo"><?= htmlspecialchars($_SESSION['pseudo']) ?></span>
                <span class="status-dot"></span>
            </div>
        <?php endif; ?>

        <button class="burger" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div> <!-- test -->

    <nav class="nav-container" role="navigation" aria-label="Main navigation">
        <a href="<?= getBaseUrl(); ?>/index.php" 
           class="spaceh <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>

        <a href="<?= getBaseUrl(); ?>/games/memory/scores.php"
           class="spaceh <?= $currentPage === 'scores.php' ? 'active' : '' ?>">Scores</a>

        <a href="<?= getBaseUrl(); ?>/myAccount.php"
           class="spaceh <?= $currentPage === 'myAccount.php' ? 'active' : '' ?>">My Account</a>

        <a href="<?= getBaseUrl(); ?>/contact.php"
           class="spaceh button-like <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact us</a>

        <!-- pseudo et pastille intégrés aussi dans le menu mobile -->
        <?php if (isset($_SESSION['pseudo'])): ?>
            <div class="user-info-mobile">
                <span class="user-pseudo"><?= htmlspecialchars($_SESSION['pseudo']) ?></span>
                <span class="status-dot"></span>
            </div>
        <?php endif; ?>
    </nav>
</header>

