<?php
function my_array_sort($array, $order) {
    // Vérifier le paramètre d'ordre
    if ($order === "ASC") {
        sort($array); // Tri croissant
    } elseif ($order === "DESC") {
        rsort($array); // Tri décroissant
    } else {
        return "Erreur : le deuxième paramètre doit être 'ASC' ou 'DESC'.";
    }

    // Retourner le tableau trié
    return $array;
}

// Exemple d'utilisation de la fonction
$array = [3, 1, 4, 1, 5, 9, 2, 6, 5];
$order = "ASC"; // Changer en "DESC" pour un tri décroissant
$sorted_array = my_array_sort($array, $order);
print_r($sorted_array);
?>