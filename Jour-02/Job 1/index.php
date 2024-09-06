<?php
// Connexion à la base de données
function connect_db() {
    // Informations de connexion (à adapter selon votre environnement)
    $host = 'localhost';
    $dbname = 'lp_official';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // S'assurer que PDO renvoie des erreurs en cas de problème
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

// Fonction pour récupérer tous les étudiants
function find_all_students() {
    $pdo = connect_db(); // Connexion à la base
    $sql = "SELECT * FROM student"; // Requête SQL pour récupérer tous les étudiants
    $stmt = $pdo->query($sql);

    // Récupérer toutes les lignes sous forme de tableau associatif
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $students; // Retourner le tableau d'étudiants
}

// Récupérer tous les étudiants
$students = find_all_students();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Liste des étudiants</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Grade ID</th>
        <th>Email</th>
        <th>Nom complet</th>
        <th>Date de naissance</th>
        <th>Genre</th>
        <!-- Ajouter d'autres colonnes selon la structure de la table 'student' -->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['grade_id']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['fullname']) ?></td>
            <td><?= htmlspecialchars($student['birthdate']) ?></td>
            <td><?= htmlspecialchars($student['gender']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
