
const collection = document.getElementsByClassName("remove-favourite-button");

Array.prototype.forEach.call(collection, function(button) {
    button.addEventListener('click', function(event) {
        // previene l'invio del modulo
        event.preventDefault();
      
        // mostra un messaggio di conferma
        var confirmDelete = window.confirm("Sei sicuro di voler rimuovere il preferito? Questa azione non può essere annullata.");
      
        // Se l'utente conferma, invia il modulo
        if (confirmDelete) {
          this.form.submit();
        }
      }
    );
});
  