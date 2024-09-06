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

// Fonction pour récupérer les emails, noms complets et noms de promotions des étudiants
function find_all_students_grades() {
    $pdo = connect_db();

    // Requête SQL pour joindre les tables student et grade
    $sql = "SELECT student.email, student.fullname, grade.name AS grade_name 
            FROM student
            INNER JOIN grade ON student.grade_id = grade.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer toutes les lignes sous forme de tableau associatif
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $students;
}

// Récupérer tous les étudiants avec leurs informations de grade
$students = find_all_students_grades();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants et leurs promotions</title>
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
    </style>
</head>
<body>
<h1>Liste des étudiants et leurs promotions</h1>

<!-- Générer un tableau HTML pour afficher les étudiants -->
<table>
    <thead>
    <tr>
        <th>Email</th>
        <th>Nom complet</th>
        <th>Nom de la promotion</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['fullname']) ?></td>
            <td><?= htmlspecialchars($student['grade_name']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($students)): ?>
    <p>Aucun étudiant trouvé.</p>
<?php endif; ?>
</body>
</html>
