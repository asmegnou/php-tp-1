<?php
// Création du tableau [..., "D" => ["Prix" => 22.71,"Taux" => 0.05], ...]

//creation de tableau ["A","B",..."K"]
$tabL= range('A','K');
$tab_taux= [0.05,0.10,0.20];

 


/**
 * renvoie un tableau au format ["Prix" => 22.71,"Taux" => 0.05]
 * où le prix est tiré aléatoirement dans [1,100]
 * et le taux est tiré aléatoirement dans le tableau de taux $tab_taux
 * 
 * NB. $tab_taux est passé en paramètre plutôt qu'utilisé comme une variable globale.
 * Ce qui permet d'utiliser indirectement cette fonction nommée comme fonction de rappel
 * dans les fonctions de type array_*.
 * 
 * return array
 **/
function creer_prix_articles($tab_taux)
{
    global $tabL;
    $result = array_fill_keys($tabL, []);
    return array_map(function ($keys) use($tab_taux){
        return [
            'Prix' => rand(0,100) + (rand(0,10)/100),
            'Taux' => $tab_taux[array_rand($tab_taux)]
        ];
    } , $result);

}

// initialisation de $prix_taux
//$prix_taux = null;
$prix_taux=creer_prix_articles($tab_taux);
//print_r($prix_taux);
?>