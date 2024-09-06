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

// Fonction pour récupérer les informations d'un étudiant par email
function find_one_student($email) {
    $pdo = connect_db();
    $sql = "SELECT * FROM student WHERE email = :email"; // Requête SQL pour trouver l'étudiant
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    // Récupérer une seule ligne
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    return $student; // Retourner les informations de l'étudiant ou false si l'email n'existe pas
}

// Initialiser la variable pour stocker les informations de l'étudiant
$student_info = null;

// Vérifier si un email a été soumis via GET
if (isset($_GET['input-email-student'])) {
    $email = $_GET['input-email-student']; // Récupérer l'email soumis
    $student_info = find_one_student($email); // Récupérer les informations de l'étudiant
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'étudiant</title>
</head>
<body>
<h1>Recherche d'étudiant par email</h1>

<!-- Formulaire pour rechercher un étudiant -->
<form method="get">
    <label for="email">Entrez l'email de l'étudiant :</label>
    <input type="text" id="email" name="input-email-student" required>
    <button type="submit">Rechercher</button>
</form>

<?php if ($student_info): ?>
    <!-- Afficher les informations de l'étudiant si trouvé -->
    <h2>Informations de l'étudiant :</h2>
    <ul>
        <li>ID : <?= htmlspecialchars($student_info['id']) ?></li>
        <li>Grade ID : <?= htmlspecialchars($student_info['grade_id']) ?></li>
        <li>Email : <?= htmlspecialchars($student_info['email']) ?></li>
        <li>Nom complet : <?= htmlspecialchars($student_info['fullname']) ?></li>
        <li>Date de naissance : <?= htmlspecialchars($student_info['birthdate']) ?></li>
        <li>Genre : <?= htmlspecialchars($student_info['gender']) ?></li>
    </ul>
<?php elseif ($student_info === false && isset($_GET['input-email-student'])): ?>
    <!-- Afficher un message si l'email n'est pas trouvé -->
    <p>Aucun étudiant trouvé avec cet email.</p>
<?php endif; ?>
</body>
</html>
