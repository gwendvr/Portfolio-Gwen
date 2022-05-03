function goalAddClass() {
    var element = document.getElementById("form-valide");
    if (element.classList.contains(goalRestant)) {
        element.classList.remove(goalRestant)
    } else {
        element.classList.add(goalValide)
    }
}

function shopAddClass() {
    var element = document.getElementById("form-valide");
    if (element.classList.contains(shopRestant)) {
        element.classList.remove(shopRestant)
    } else {
        element.classList.add(shopValide)
    }
}