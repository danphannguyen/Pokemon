// fonction pour confirmer la fuite
function confirmRun() {

    // Afficher une boîte de dialogue de confirmation
    var confirmation = confirm("Are you sure you want to flee? You'll lose all your progress in this battle !");

    // Retourner vrai (true) si l'utilisateur clique sur OK, sinon faux (false)
    return confirmation;

}

function togglePause() {
    var audio = document.getElementById('backgroundMusic');

    if (audio.paused) {
        audio.play();
        $("#bgMusicImg").attr("src", "./img/sound.svg");
    } else {
        audio.pause();
        $("#bgMusicImg").attr("src", "./img/mute.svg");
    }
}

