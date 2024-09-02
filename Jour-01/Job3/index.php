<?php
/**
 * Cette fonction permet de déterminer si un nombre est un multiple d'un autre.
 *
 * @param int $number Le nombre que l'on veut vérifier.
 * @param int $multiple Le nombre par lequel on veut diviser.
 * @return bool Retourne true si $number est un multiple de $multiple, false sinon.
 */
function my_is_multiple(int $number, int $multiple): bool {
    if ($multiple === 0) {
        // Pour éviter la division par zéro, on retourne false si $multiple est zéro.
        return false;
    }

    // Vérifie si $number est un multiple de $multiple.
    return $number % $multiple === 0;
}

// Exemple d'utilisation de la fonction
$number = 10;
$multiple = 2;

if (my_is_multiple($number, $multiple)) {
    echo "$number est un multiple de $multiple.";
} else {
    echo "$number n'est pas un multiple de $multiple.";
}
?>
