// index.js - Gestion du menu de sélection et redirection

document.addEventListener("DOMContentLoaded", () => {
    const startBtn = document.getElementById("startGameBtn");
    const playerCountSelect = document.getElementById("playerCount");
    const modeSelect = document.getElementById("gameMode");

    if (!startBtn) return;

    startBtn.addEventListener("click", () => {
        const playerCount = playerCountSelect.value;
        const mode = modeSelect.value;

        if (!playerCount || !mode) {
            alert("Veuillez choisir le nombre de joueurs et un mode de jeu.");
            return;
        }

        // Redirection vers la page du jeu
        window.location.href = `game.php?players=${playerCount}&mode=${mode}`;
    });
});