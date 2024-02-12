const car = document.querySelector('.car');
const immaginiCarosello = car.querySelectorAll(".immaginecarosello");

const player = document.querySelector('.playercarosello');
const dots = player.querySelectorAll(".indicecarosello");

const btnIndietro = document.getElementById("btnindietro");
const btnAvanti = document.getElementById("btnavanti");
let currentIndex = 0;


function aggiornaIndice(index) {
    dots.forEach((item, i) => {
        if (i === index) {
            item.classList.add('indiceattivocar');
        } else {
         item.classList.remove('indiceattivocar');
    }
  });
}

function mostraImmagine(index) {
    immaginiCarosello.forEach((item, j) => {
        item.classList.add('nascosto');
        if (j === index) {
            item.classList.add('visibile');
            item.classList.remove('nascosto');
        } else {
         item.classList.remove('visibile');
    }
  });
  aggiornaIndice(index);
}

function addPrintClass() {
  const images = document.querySelectorAll('.immaginecarosello');
  images.forEach(image => {
      image.style.display = 'none';
  });

  //   print dialog
  window.print();

   
  images.forEach(image => {
      image.style.display = '';
  });
}

// aggiunta eventlisterner per la stampa
window.addEventListener('beforeprint', addPrintClass);

function dotClicked(dot){
    currentIndex=dot.currentTarget.index;
    mostraImmagine(dot.currentTarget.index);
}

function prossimaImmagine() {
  currentIndex++;
  if (currentIndex >= immaginiCarosello.length) {
    currentIndex = 0;
  }
  mostraImmagine(currentIndex);
}

function immaginePrecedente() {
  currentIndex--;
  if (currentIndex < 0) {
    currentIndex = immaginiCarosello.length - 1;
  }
  mostraImmagine(currentIndex);
}

mostraImmagine(currentIndex);
btnAvanti.addEventListener('click', prossimaImmagine);
btnIndietro.addEventListener('click', immaginePrecedente); 
dots.forEach((item, i) => {
    item.index=i;
    item.addEventListener('click', dotClicked)
 });


