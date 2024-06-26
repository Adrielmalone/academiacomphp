<?php
  require "php/authenticate.php";
  require "php/database_functions.php";

  
  if (!$login) {
    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "./index.php"); 
    exit();
  }

  $error = false;
  $success = false;

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["diadasemana"])) {
        setcookie("diadasemana", $_GET["diadasemana"]);
    }
    if(isset($_GET["acao"]) && $_GET["acao"] == "remover"){
        $id = $_GET["id"];
        $sql = "DELETE FROM $table_atividades WHERE id=" . $id;

        $conn = connect_database();

        if (!mysqli_query($conn, $sql)) { 
            $error_msg = mysqli_error($conn);
            $error = true;
        } 

        $success = true;
        $current = "Treino removido";

        disconnect_database($conn);
    }
  } else {     
    if (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "segunda" || $_COOKIE["diadasemana"] == "terca" || $_COOKIE["diadasemana"] == "quarta" || $_COOKIE["diadasemana"] == "quinta" || $_COOKIE["diadasemana"] == "sexta")) {

        $dia_da_semana = $_COOKIE["diadasemana"];
        $atividade = $_POST["atividade"];
        $userid = $_SESSION["user_id"];

        $conn = connect_database();

        $sql = "INSERT INTO $table_atividades (name, dia_da_semana, userid) VALUES ('$atividade', '$dia_da_semana', '$userid');";

        if (mysqli_query($conn, $sql)) {
            $success = true;
            $current = "Treino agendado";
        } else {
            $error_msg = mysqli_error($conn);
            $error = true;
        }
        
        disconnect_database($conn);
    } else {
        $error_msg = "Selecione o dia da semana!";
        $error = true;
    }
  }

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Painel de atividades</title>
    <link type="text/css" rel="stylesheet" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="img/webfit.png">
  </head>


  <body>
    <?php require "php/menu.php"; ?>

    <div class="atividades">
        <form id="formulario_atividades" method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
            <div class="check-in">
                <h1 class="texto">Selecione o dia da semana:</h1>
                <div class="atividades">
                    
                    <a class="abotao" id="segunda" href="?diadasemana=segunda">
                        <?php if (($_SERVER["REQUEST_METHOD"] == "GET") && ((isset($_GET["diadasemana"]) && ($_GET["diadasemana"] == "segunda"))) || (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "segunda"))): ?>
                            <?php if (isset($_GET["diadasemana"]) && $_GET["diadasemana"] != "segunda"):?>
                                <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Segunda">
                            <?php else: ?>
                                <div class="selecionado">
                                    <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Segunda">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Segunda">
                        <?php endif; ?>
                    </a>

                    <a class="abotao" id="terca" href="?diadasemana=terca">
                        <?php if (($_SERVER["REQUEST_METHOD"] == "GET") && ((isset($_GET["diadasemana"]) && ($_GET["diadasemana"] == "terca"))) || (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "terca"))): ?>
                            <?php if (isset($_GET["diadasemana"]) && $_GET["diadasemana"] != "terca"):?>
                                <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Terça">
                            <?php else: ?>
                                <div class="selecionado">
                                    <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Terça">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Terça">
                        <?php endif; ?>
                    </a>

                    <a class="abotao" id="quarta" href="?diadasemana=quarta">
                        <?php if (($_SERVER["REQUEST_METHOD"] == "GET") && ((isset($_GET["diadasemana"]) && ($_GET["diadasemana"] == "quarta"))) || (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "quarta"))): ?>
                            <?php if (isset($_GET["diadasemana"]) && $_GET["diadasemana"] != "quarta"):?>
                                <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quarta">
                            <?php else: ?>
                                <div class="selecionado">
                                    <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quarta">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quarta">
                        <?php endif; ?>
                    </a>
        
                    <a class="abotao" id="quinta" href="?diadasemana=quinta">
                        <?php if (($_SERVER["REQUEST_METHOD"] == "GET") && ((isset($_GET["diadasemana"]) && ($_GET["diadasemana"] == "quinta"))) || (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "quinta"))): ?>
                            <?php if (isset($_GET["diadasemana"]) && $_GET["diadasemana"] != "quinta"):?>
                                <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quinta">
                            <?php else: ?>
                                <div class="selecionado">
                                    <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quinta">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Quinta">
                        <?php endif; ?>
                    </a>

                    <a class="abotao" id="sexta" href="?diadasemana=sexta">
                        <?php if (($_SERVER["REQUEST_METHOD"] == "GET") &&  ((isset($_GET["diadasemana"]) && ($_GET["diadasemana"] == "sexta"))) || (isset($_COOKIE["diadasemana"]) && ($_COOKIE["diadasemana"] == "sexta"))): ?>
                            <?php if (isset($_GET["diadasemana"]) && $_GET["diadasemana"] != "sexta"):?>
                                <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Sexta">
                            <?php else: ?>
                                <div class="selecionado">
                                    <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Sexta">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <input class="botao" type="button" class="fadeIn fourth" name="dia_da_semana" value="Sexta">
                        <?php endif; ?>
                    </a>

                </div>
        
            </div>


            <div class="atividades">
                <h1 class="texto">Adicione seu treino:</h1>
                <div class="atividades">
                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" value="Spinning">

                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" value="Fit Dance">

                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" value="Pilates">

                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" value="Yoga">

                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" value="Zumba">

                    <input class="botao" type="submit" class="fadeIn fourth" name="atividade" class="musculacao" value="Musculação">
                </div>
            </div>

        </form>

        <?php if ($error): ?>
            <h3 style="color:red;"><?= $error_msg; ?></h3>
        <?php endif; ?>

        <?php if ($success): ?>
          <h3 style="color:lightgreen;"><?= $current ?> com sucesso!</h3>
        <?php endif; ?>

    </div>

    <?php require "php/treino_semanal.php"; ?>

  </body>
</html>