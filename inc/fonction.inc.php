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
//fonction création panier

function creation_panier(){

        if ( !isset($_SESSION['panier']) ){//si la session n'existe pas

                $_SESSION['panier'] = array();
                $_SESSION['panier']['id_article'] = array();
                $_SESSION['panier']['quantite'] = array();
                $_SESSION['panier']['prix'] = array();
        }
}
//=====================================================================================
//fonction ajout panier

function ajout_panier($id_article, $quantite, $prix){

                creation_panier();

                $position_article =  array_search($id_article, $_SESSION['panier']['id_article']);

                if( $position_article !== false){ //si le produit existe, on entre dans le panier et on ajuste la quantite de $position_article
                        $_SESSION['panier']['quantite'][$position_article] += $quantite;
                }
                else{//si le produit n'exite pas
                        $_SESSION['panier']['id_article'][] = $id_article;
                        $_SESSION['panier']['quantite'][] = $quantite;
                        $_SESSION['panier']['prix'][] = $prix;
                }

}
//=====================================================================================
//fonction montant total

function montant_total(){

        $total = 0;
        for ($i=0; $i < count($_SESSION['panier']['id_article']); $i++) {

                $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
        }
        return round($total, 2);   //pour arrondir le resultat deux chiffres apres la virgule
}
//=====================================================================================
//fonction retrait article panier
function retrait_article_panier($id_article_a_supprimer){
        $position_article = array_search($id_article_a_supprimer, $_SESSION['panier']['id_article']);

        if( $position_article !== false){
                array_splice( $_SESSION['panier']['id_article'], $position_article, 1);
                array_splice( $_SESSION['panier']['quantite'], $position_article, 1);
                array_splice( $_SESSION['panier']['prix'], $position_article, 1);
                //la fonction array_splice set a effacer une portion d'un tableau
        }
        header('location:panier.php');
}
?>
