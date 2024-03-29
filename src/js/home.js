$(document).ready(function () {
    $("#pkmJoueurSelect").change(function () {
        updateOptions();
    });

    $("#pkmOrdiSelect").change(function () {
        updateOptions();
    });

    $("#homeBodyForm").submit(function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Bloquer l'envoi du formulaire
            alert("Veuillez sélectionner deux Pokémons.");
        }
    });

    function validateForm() {
        let joueurSelectValue = $("#pkmJoueurSelect").val();
        let ordiSelectValue = $("#pkmOrdiSelect").val();

        // Vérifier si les deux sélections sont valides
        return joueurSelectValue !== "" && ordiSelectValue !== "" && joueurSelectValue !== ordiSelectValue;
    }
});

function updateOptions() {
    let selectedValue = $("#pkmJoueurSelect").val();

    $("#pkmOrdiSelect option").prop("disabled", false);
    $("#pkmOrdiSelect option[value='" + selectedValue + "']").prop("disabled", true);

    selectedValue = $("#pkmOrdiSelect").val();

    $("#pkmJoueurSelect option").prop("disabled", false);
    $("#pkmJoueurSelect option[value='" + selectedValue + "']").prop("disabled", true);
}

function togglePause() {
    let audio = document.getElementById('backgroundMusic');

    if (audio.paused) {
        audio.play();
        $("#bgMusicImg").attr("src", "./img/sound.svg");
    } else {
        audio.pause();
        $("#bgMusicImg").attr("src", "./img/mute.svg");
    }
}

