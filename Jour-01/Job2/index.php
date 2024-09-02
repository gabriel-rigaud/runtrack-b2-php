<?php
function my_str_reverse($string) {
    // Initialiser une variable pour stocker la chaîne inversée
    $reversed = '';

    // Parcourir la chaîne de caractères à l'envers
    for ($i = strlen($string) - 1; $i >= 0; $i--) {
        // Ajouter chaque caractère à la chaîne inversée
        $reversed .= $string[$i];
    }

    // Retourner la chaîne inversée
    return $reversed;
}

// Exemple d'utilisation de la fonction
$string = 'hello';
echo "La chaîne inversée de '$string' est : " . my_str_reverse($string);
?>