<?php
function my_is_prime($number) {
    // Les nombres inférieurs à 2 ne sont pas premiers
    if ($number < 2) {
        return false;
    }

    // Vérifier les divisibilités à partir de 2 jusqu'à la racine carrée du nombre
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false; // Si divisible par un nombre autre que lui-même, ce n'est pas un nombre premier
        }
    }

    // Si aucune division entière n'a été trouvée, le nombre est premier
    return true;
}

// Exemple d'utilisation de la fonction
$number = 29;
if (my_is_prime($number)) {
    echo "$number est un nombre premier.";
} else {
    echo "$number n'est pas un nombre premier.";
}
?>
