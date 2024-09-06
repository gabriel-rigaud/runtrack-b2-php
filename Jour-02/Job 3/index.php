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

// Fonction pour insérer un nouvel étudiant en base de données
function insert_student($email, $fullname, $gender, $birthdate, $grade_id) {
    $pdo = connect_db();
    $sql = "INSERT INTO student (email, fullname, gender, birthdate, grade_id) 
            VALUES (:email, :fullname, :gender, :birthdate, :grade_id)";
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête avec les paramètres
    $stmt->execute([
        'email' => $email,
        'fullname' => $fullname,
        'gender' => $gender,
        'birthdate' => $birthdate,
        'grade_id' => $grade_id
    ]);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs envoyées par le formulaire
    $email = $_POST['input-email'];
    $fullname = $_POST['input-fullname'];
    $gender = $_POST['input-gender'];
    $birthdate = $_POST['input-birthdate'];
    $grade_id = $_POST['input-grade_id'];

    // Insérer l'étudiant en base de données
    insert_student($email, $fullname, $gender, $birthdate, $grade_id);

    // Message de succès
    $success_message = "Étudiant ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
</head>
<body>
<center>
<h1>Ajouter un nouvel étudiant</h1>

<!-- Affichage d'un message de succès si l'étudiant est ajouté -->
<?php if (isset($success_message)): ?>
    <p style="color:green;"><?= htmlspecialchars($success_message) ?></p>
<?php endif; ?>

<!-- Formulaire pour ajouter un nouvel étudiant -->
<form method="post">
    <label for="email">Email :</label>
    <input type="email" id="email" name="input-email" required><br><br>

    <label for="fullname">Nom complet :</label>
    <input type="text" id="fullname" name="input-fullname" required><br><br>

    <label for="gender">Genre :</label>
    <select id="gender" name="input-gender" required>
        <option value="male">Homme</option>
        <option value="female">Femme</option>
    </select><br><br>

    <label for="birthdate">Date de naissance :</label>
    <input type="date" id="birthdate" name="input-birthdate" required><br><br>

    <label for="grade_id">Grade ID :</label>
    <input type="number" id="grade_id" name="input-grade_id" required><br><br>

    <button type="submit">Ajouter l'étudiant</button>
</form>
</center>
</body>
</html>
