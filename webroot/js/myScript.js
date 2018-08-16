$('select#type-file').on('change', function() {
  if (this.value == 1){ // Si le type de fichier est Catalogue et bon de commande
    $("div#tarif-file").css("display", "block");
    $("div#user-file").css("display", "none");
  } else if (this.value == 2) {
    $("div#user-file").css("display", "block");
    $("div#tarif-file").css("display", "none");
  }
  else {
    $("div#tarif-file").css("display", "none");
    $("div#user-file").css("display", "none");
  }

});
