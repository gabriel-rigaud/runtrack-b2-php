<?php

class Grade {
    private int $id;
    private int $level;
    private string $name;
    private DateTime $start_date;

    // Constructor
    public function __construct(int $id = 0, int $level = 0, string $name = "", DateTime $start_date = null) {
        $this->id = $id;
        $this->level = $level;
        $this->name = $name;
        $this->start_date = $start_date ?? new DateTime();
    }

    // Getters and Setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): static {
        $this->id = $id;
        return $this;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function setLevel(int $level): static {
        $this->level = $level;
        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;
        return $this;
    }

    public function getStartDate(): DateTime {
        return $this->start_date;
    }

    public function setStartDate(DateTime $start_date): static {
        $this->start_date = $start_date;
        return $this;
    }

    // Method to get all students for this grade
    public function getStudents(): array {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM students WHERE grade_id = :grade_id");
        $stmt->bindParam(':grade_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $studentsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $students = [];
        foreach ($studentsData as $studentData) {
            $students[] = new Student(
                $studentData['id'],
                $studentData['grade_id'],
                $studentData['email'],
                $studentData['fullname'],
                new DateTime($studentData['birthdate']),
                $studentData['gender']
            );
        }
        return $students;
    }
}

?>
