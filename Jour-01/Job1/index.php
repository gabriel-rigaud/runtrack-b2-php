<?php
function my_str_search($letter, $string) {
    // Initialiser un compteur à 0
    $count = 0;

    // Parcourir chaque caractère de la chaîne de caractères
    for ($i = 0; $i < strlen($string); $i++) {
        // Comparer chaque caractère à la lettre recherchée
        if ($string[$i] === $letter) {
            $count++; // Incrémenter le compteur si la lettre est trouvée
        }
    }

    // Retourner le nombre d'occurrences
    return $count;
}

// Exemple d'utilisation de la fonction
$letter = 'a';
$string = 'La Plateforme';
echo "Le nombre d'occurrences de la lettre '$letter' dans la chaîne '$string' est : " . my_str_search($letter, $string);
?>