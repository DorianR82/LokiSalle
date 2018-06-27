<?php require_once('inc/header.inc.php');?>


<?php

if($_POST){
        if (mail('chapalain@hotmail.com', $_POST['sujet'], $_POST['message'], $_POST['expediteur'])) {
        echo "<div class='alert alert-success mt-5'>Votre email a bien été envoyé !</div>";
    }
    else {
        echo "<div class='alert alert-warning mt-5''>Une erreur s'est produite. Votre email n'a pas été envoyé!</div>";
    }
}

?>

  <h3 class="mt-5">NOUS CONTACTER</h3>
    <div class="row mt-3 mb-4">
    <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
    </div>

  <form method="post">

    <div class="form-group col-md-12">
        <label for="expediteur">Votre adresse email</label><br>
        <input type="text" class="form-control" name="expediteur" id="expediteur" value="">
    </div>

    <div class="form-group col-md-12">
          <label for="sujet">Sujet</label><br>
          <input type="text" class="form-control" name="sujet" id="sujet" value="">
    </div>

    <div class="form-group col-md-12">
          <label for="message">Message</label><br>
          <textarea name="message" class="form-control" id="message"></textarea><br>
    </div>

    <div class="form-group col-md-2">
          <input type="submit" class="form-control">
    </div>

  </form>

<?php require_once('inc/footer.inc.php');?>
