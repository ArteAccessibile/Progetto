const btnIndietro = document.querySelector('.bottoneindietro');

function tornaIndietro() {
    window.history.go(-1)
}

btnIndietro.addEventListener('click', tornaIndietro);
