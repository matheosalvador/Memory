document.addEventListener("DOMContentLoaded", () => {
    const playerCountSelect = document.getElementById("playerCount");
    const playersConfig = document.getElementById("playersConfig");

    // Génère les champs au chargement
    updatePlayersFields(playerCountSelect.value);

    // Met à jour les champs quand le nombre change
    playerCountSelect.addEventListener("change", () => {
        updatePlayersFields(playerCountSelect.value);
    });
});

function updatePlayersFields(count) {
    const playersConfig = document.getElementById("playersConfig");
    playersConfig.innerHTML = "";

    for (let i = 1; i <= count; i++) {
        playersConfig.innerHTML += `
            <div class="player-block">
                <label>Nom du joueur ${i} :</label>
                <input type="text" name="player${i}Name" placeholder="Joueur ${i}" required>
            </div>
        `;
    }
}
