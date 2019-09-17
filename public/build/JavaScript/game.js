
// ********** Afficher les stats joueur ********************************
function onClickBtnStat(event) {
    event.preventDefault();
    const url = this.href;
    var afficheStat = document.getElementById("StatJoueur");
    document.getElementById("afficherCamp").classList.replace("backgroundCamp","hide");

    axios.get(url).then(function (response) {
        document.getElementById("playDay").classList.replace("playDayClass","hide");
        var life = response.data.joueur[0]
        var moral = response.data.joueur[1]
        var nourriture = response.data.joueur[2]
        afficheStat.classList.replace("hide" , "visible")
        afficheStat.innerHTML = "Vie : " + life + "<br>Moral : " + moral + "<br> Nourriture en stock : " + nourriture
    })
}

// ********* Afficher le camp *****************
function onClickBtnCamp(event) {
    event.preventDefault();
    document.getElementById("StatJoueur").classList.replace("visible" , "hide");
    document.getElementById("playDay").classList.replace("playDayClass","hide");
    document.getElementById("afficherCamp").classList.replace("hide","backgroundCamp");


}

// ****************** Afficher une batiment *******************
function onClickBtnBat(event) {
    event.preventDefault();
    const url = this.href;

    axios.get(url).then(function (response) {
        console.log(response)
        switch (response.data.idBatiment) {

            case 1 :
                document.getElementById("feu").classList.remove("hide");
                break

        }
    })
}

document.getElementById("js-statDuJoueur").addEventListener('click', onClickBtnStat);
document.getElementById("js-afficheCamp").addEventListener('click', onClickBtnCamp);
document.querySelectorAll('a.afficheBatiment').forEach(function (link) {
    link.addEventListener('click', onClickBtnBat)
});

