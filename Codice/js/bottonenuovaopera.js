const btn = document.getElementById('btnnewopera');


function goToUpload() {
    window.location.href = "../php/newOpera.php";
}

btn.addEventListener('click', goToUpload);
