<?php
//=====================================================================================
// FONCTION DE DEBUG

function debug($arg, $mode = 1)
{
        echo '<div style="background: #fda500; padding: 5px; z-index: 1000;">';
        $trace = debug_backtrace();
        echo 'Debug demandé dans le fichier '.$trace[0]['file'].' à la ligne '.$trace[0]['line'] ;
        if($mode == 1){
                echo '<pre>';
                        print_r($arg);
                echo '</pre>';
        }else{
                var_dump($arg);
        }
        echo '</div>';
}

//=====================================================================================
// FUNCTION EXECUTE_REQUETE

function execute_requete($req){
    global $pdo;
    $resultat = $pdo->query($req);
    return $resultat;
}

//=====================================================================================
// FONCTION USERCONNECT(): si l'internaute est connecté:

function userConnect(){
        //si la session membre n'existe pas, on retorurne false
        if( !isset($_SESSION['membre']) ){
                return false;
        }
        else{
                return true;
        }
}

//=====================================================================================
// FONCTION ADMINCONNECT(): si l'internaute est connecté ET qu'il est administrateur:

function adminConnect(){

        if( userConnect() && $_SESSION['membre']['statut'] ==1){
                return true;
        }
        else{
                return false;
        }
}

//=====================================================================================
?>