<?php
function my_closest_to_zero($numbers) {
    // Vérifier que le tableau n'est pas vide
    if (empty($numbers)) {
        return null; // Retourner null si le tableau est vide
    }

    // Initialiser le nombre le plus proche de zéro avec le premier élément du tableau
    $closest = $numbers[0];

    // Parcourir chaque nombre du tableau
    foreach ($numbers as $number) {
        // Si le nombre actuel est plus proche de zéro ou si la distance est égale mais que le nombre actuel est positif
        if (abs($number) < abs($closest) || (abs($number) == abs($closest) && $number > 0)) {
            $closest = $number;
        }
    }

    // Retourner le nombre le plus proche de zéro
    return $closest;
}

// Exemple d'utilisation de la fonction
$numbers = [-10, -3, 2, 4, -2, 5];
echo "Le nombre le plus proche de zéro est : " . my_closest_to_zero($numbers);
?>