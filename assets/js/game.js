const statut = document.querySelector("h6")
let game = true
let playeurActif = "X"
let gameState = ["", "", "", "", "", "", "", "", ""]

// Conditions de victoire
const forVictory = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
]

// changement message
const win = () => `Le joueur ${playeurActif} a gagné`
const egalite = () => "Egalité"
const playerTurn = () => `C'est au tour du joueur ${playeurActif}`

// statut sur le joueur qui commence
statut.innerHTML = playerTurn()

document.querySelectorAll(".case").forEach(cell => cell.addEventListener("click", gestionClicCase))
document.querySelector("#replay").addEventListener("click", replay)


function gestionClicCase() {
    const indexCase = parseInt(this.dataset.index)

    // vérification de la case
    if (gameState[indexCase] !== "" || !game) {
        return
    }

    // ajout du O ou du X
    gameState[indexCase] = playeurActif
    this.innerHTML = playeurActif

    winVerif()
}


function winVerif() {
    let winner = false

    // Vérification conditions de victoire
    for (let condition of forVictory) {
        let val1 = gameState[condition[0]]
        let val2 = gameState[condition[1]]
        let val3 = gameState[condition[2]]

        if (val1 === "" || val2 === "" || val3 === "") {
            continue
        }

        if (val1 === val2 && val2 === val3) {
            winner = true
            break
        }
    }

    if (winner) {
        statut.innerHTML = win()
        game = false
        return
    }

    if (!gameState.includes("")) {
        statut.innerHTML = egalite()
        game = false
        return
    }

    // Changement de joueur
    playeurActif = playeurActif === "X" ? "O" : "X"
    statut.innerHTML = playerTurn()
}


function replay() {
    playeurActif = "X"
    game = true
    gameState = ["", "", "", "", "", "", "", "", ""]
    statut.innerHTML = playerTurn()
    document.querySelectorAll(".case").forEach(cell => cell.innerHTML = "")
}