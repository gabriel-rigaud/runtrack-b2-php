<?php

require_once 'class/grade.php';
require_once 'class/room.php';
require_once 'class/floor.php';
require_once 'functions.php';

// Test de la méthode getStudents() pour un grade
$gradeId = 1; // Utilisez un ID valide
$grade = findOneGrade($gradeId);
if ($grade) {
    $students = $grade->getStudents();
    foreach ($students as $student) {
        var_dump($student);
    }
}

// Test de la méthode getGrades() pour une room
$roomId = 1; // Utilisez un ID valide
$room = findOneRoom($roomId);
if ($room) {
    $grades = $room->getGrades();
    foreach ($grades as $grade) {
        var_dump($grade);
    }
}

// Test de la méthode getRooms() pour un floor
$floorId = 1; // Utilisez un ID valide
$floor = findOneFloor($floorId);
if ($floor) {
    $rooms = $floor->getRooms();
    foreach ($rooms as $room) {
        var_dump($room);
    }
}

?>
