<?php

class Room {
    private int $id;
    private int $floor_id;
    private string $name;
    private int $capacity;

    // Constructeur avec paramètres optionnels
    public function __construct(
        int $id = 0,
        int $floor_id = 0,
        string $name = '',
        int $capacity = 0
    ) {
        $this->id = $id;
        $this->floor_id = $floor_id;
        $this->name = $name;
        $this->capacity = $capacity;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getFloorId(): int {
        return $this->floor_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCapacity(): int {
        return $this->capacity;
    }

    // Method to get all grades for this room
    public function getGrades(): array {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM grades WHERE id IN (SELECT grade_id FROM student_rooms WHERE room_id = :room_id)");
        $stmt->bindParam(':room_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $gradesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $grades = [];
        foreach ($gradesData as $gradeData) {
            $grades[] = new Grade(
                $gradeData['id'],
                $gradeData['level'],
                $gradeData['name'],
                new DateTime($gradeData['start_date'])
            );
        }
        return $grades;
    }
}

?>
