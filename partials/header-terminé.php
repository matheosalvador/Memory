<header class="main-header">
    <a href="<?= getBaseUrl(); ?>/index.php">
        <img src="<?= getBaseUrl(); ?>/assets/images/logo_memory.png" alt="logo" class="logohead">
    </a>

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

    <nav class="nav-container" role="navigation" aria-label="Main navigation">
        <a href="<?= getBaseUrl(); ?>/index.php" 
           class="spaceh <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>

        <a href="<?= getBaseUrl(); ?>/games/memory/scores.php"
           class="spaceh <?= $currentPage === 'scores.php' ? 'active' : '' ?>">Scores</a>

        <a href="<?= getBaseUrl(); ?>/myAccount.php"
           class="spaceh <?= $currentPage === 'myAccount.php' ? 'active' : '' ?>">My Account</a>

        <a href="<?= getBaseUrl(); ?>/contact.php"
           class="spaceh button-like <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact us</a>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-container');

    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        nav.classList.toggle('mobile-active');
    });
});
</script>
