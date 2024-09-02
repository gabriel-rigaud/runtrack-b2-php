<?php
function my_fizz_buzz($length) {
    // Initialiser un tableau vide pour stocker les résultats
    $result = [];

    // Boucler de 1 jusqu'à la longueur spécifiée
    for ($i = 1; $i <= $length; $i++) {
        // Vérifier les conditions Fizz, Buzz et FizzBuzz
        if ($i % 3 == 0 && $i % 5 == 0) {
            $result[] = 'FizzBuzz';
        } elseif ($i % 3 == 0) {
            $result[] = 'Fizz';
        } elseif ($i % 5 == 0) {
            $result[] = 'Buzz';
        } else {
            $result[] = $i; // Sinon, ajouter l'entier
        }
    }

    // Retourner le tableau résultant
    return $result;
}

// Exemple d'utilisation de la fonction
$length = 15;
print_r(my_fizz_buzz($length));
?>