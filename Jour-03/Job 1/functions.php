<?php

// Fonction pour établir une connexion à la base de données
function getDbConnection(): PDO {
    $host = 'localhost'; // Remplacez par votre hôte
    $dbname = 'my_database'; // Remplacez par le nom de votre base de données
    $username = 'root'; // Remplacez par votre nom d'utilisateur
    $password = ''; // Remplacez par votre mot de passe

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Erreur de connexion : " . $e->getMessage());
    }
}

// Fonction pour récupérer un étudiant par son ID
function findOneStudent(int $id): ?Student {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($studentData) {
        return new Student(
            $studentData['id'],
            $studentData['grade_id'],
            $studentData['email'],
            $studentData['fullname'],
            new DateTime($studentData['birthdate']),
            $studentData['gender']
        );
    }
    return null;
}

// Fonction pour récupérer une note par son ID
function findOneGrade(int $id): ?Grade {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM grades WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $gradeData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($gradeData) {
        return new Grade(
            $gradeData['id'],
            $gradeData['level'],
            $gradeData['name'],
            new DateTime($gradeData['start_date'])
        );
    }
    return null;
}

// Fonction pour récupérer un étage par son ID
function findOneFloor(int $id): ?Floor {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM floors WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $floorData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($floorData) {
        return new Floor(
            $floorData['id'],
            $floorData['name'],
            $floorData['level']
        );
    }
    return null;
}

// Fonction pour récupérer une salle par son ID
function findOneRoom(int $id): ?Room {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $roomData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($roomData) {
        return new Room(
            $roomData['id'],
            $roomData['floor_id'],
            $roomData['name'],
            $roomData['capacity']
        );
    }
    return null;
}

?>
