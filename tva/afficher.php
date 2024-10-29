<?php
// Calcul et génération taxe et coût TTC par article sous forme de ligne de tableau HTML
// $value : valeur de type array d'un élément du tableau $prix_taux
// $key : clé de type string d'un élément du tableau $prix_taux
// $param : paramètre additionnel de type string (couleur de fond CSS)
//


function taxe($value, $key, $param)
{
    $taxe = $value['Prix']*$value['Taux'];
    $cout = $value['Prix']+ $taxe;
    $row = <<<HTML
    <tr>
        <td>$key</td>
        <td>{$value['Prix']}</td>
        <td>{$value['Taux']}</td> 
        <td>$taxe</td>
        <td style="background-color:$param" >$cout</td>
    </tr>
HTML;
    echo $row;
}


// Génération de tableau HTML
//

function generer_tableau($prix_taux)
{
    $enTete = <<<HTML
    <table>
        <thead>
    <tr>
        <th>Articl</th>
        <th>Prix</th>
        <th> <a href ="{$_SERVER['PHP_SELF']}" >T.V.A </a></th>
        <th>Taxe</th>
        <th>Coût TTC</th>  
    </tr>
    </thead>
HTML;
    echo $enTete;
    echo '<tbody>';
    array_walk($prix_taux, 'taxe' , "red" );
    echo '</tbody>';
    echo '</table>';
}

//tri du tableau
//utilisation de uasort permet de garder les cle si on met usort il vas les considerer comme un index 
uasort ($prix_taux , function($a,$b){
    if ($a['Taux']==$b['Taux']){
        return $b['Prix']<=>$a['Prix'];
    }
    else{
        return($a['Taux'] >$b['Taux'])? 1:-1;
    }
});
// Affichage du tableau
generer_tableau($prix_taux);
?>