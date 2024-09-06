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

// Fonction pour récupérer les salles, leur capacité et le nombre d'étudiants
function find_full_rooms() {
    $pdo = connect_db();

    $sql = "SELECT room.name AS room_name, room.capacity,
                   COALESCE(COUNT(student.id), 0) AS students_in_room
            FROM room
            LEFT JOIN grade ON room.id = grade.room_id
            LEFT JOIN student ON grade.id = student.grade_id
            GROUP BY room.id, room.name, room.capacity";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rooms as &$room) {
        $room['is_full'] = ($room['students_in_room'] >= $room['capacity']) ? 'Pleine' : 'Non pleine';
    }

    return $rooms;
}

// Récupérer toutes les informations des salles
$rooms = find_full_rooms();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des salles et leur statut</title>
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
<h1>Liste des salles et leur statut</h1>

<table>
    <thead>
    <tr>
        <th>Nom de la salle</th>
        <th>Capacité</th>
        <th>Nombre d'étudiants</th>
        <th>Statut (Pleine ou Non)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?= htmlspecialchars($room['room_name']) ?></td>
            <td><?= htmlspecialchars($room['capacity']) ?></td>
            <td><?= htmlspecialchars($room['students_in_room']) ?></td>
            <td><?= htmlspecialchars($room['is_full']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($rooms)): ?>
    <p>Aucune salle trouvée.</p>
<?php endif; ?>
</body>
</html>
