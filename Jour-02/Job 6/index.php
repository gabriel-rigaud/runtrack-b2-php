<?php
// Connexion à la base de données
function connect_db() {
    $host = 'localhost';
    $dbname = 'lp_official';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

// Fonction pour récupérer les promotions et les étudiants associés, triés par taille des promotions
function find_ordered_students() {
    $pdo = connect_db();

    $sql = "SELECT grade.id AS grade_id, grade.name AS grade_name, grade.year,
                   COUNT(student.id) AS student_count
            FROM grade
            LEFT JOIN student ON grade.id = student.grade_id
            GROUP BY grade.id, grade.name, grade.year
            ORDER BY student_count DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($grades as $grade) {
        $result[$grade['grade_name']] = [
            'grade_id' => $grade['grade_id'],
            'year' => $grade['year'],
            'students' => get_students_by_grade($grade['grade_id'])
        ];
    }

    return $result;
}

// Fonction pour récupérer les étudiants d'une promotion donnée
function get_students_by_grade($grade_id) {
    $pdo = connect_db();

    $sql = "SELECT id, email, fullname, birthdate, gender
            FROM student
            WHERE grade_id = :grade_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':grade_id', $grade_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les promotions et les étudiants
$ordered_students = find_ordered_students();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des promotions et des étudiants</title>
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
        .students-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Liste des promotions et des étudiants</h1>

<?php foreach ($ordered_students as $grade_name => $grade_info): ?>
    <h2><?= htmlspecialchars($grade_name) ?> (Année <?= htmlspecialchars($grade_info['year']) ?>)</h2>
    <p>Nombre d'étudiants : <?= count($grade_info['students']) ?></p>
    <table class="students-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Nom Complet</th>
            <th>Date de Naissance</th>
            <th>Genre</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grade_info['students'] as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['id']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td><?= htmlspecialchars($student['fullname']) ?></td>
                <td><?= htmlspecialchars($student['birthdate']) ?></td>
                <td><?= htmlspecialchars($student['gender']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>

<?php if (empty($ordered_students)): ?>
    <p>Aucune promotion trouvée.</p>
<?php endif; ?>
</body>
</html>
