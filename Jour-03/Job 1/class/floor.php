<?php

class Floor {
    private int $id;
    private string $name;
    private int $level;

    // Constructeur avec paramètres optionnels
    public function __construct(
        int $id = 0,
        string $name = '',
        int $level = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getLevel(): int {
        return $this->level;
    }

    // Method to get all rooms for this floor
    public function getRooms(): array {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM rooms WHERE floor_id = :floor_id");
        $stmt->bindParam(':floor_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $roomsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $rooms = [];
        foreach ($roomsData as $roomData) {
            $rooms[] = new Room(
                $roomData['id'],
                $roomData['floor_id'],
                $roomData['name'],
                $roomData['capacity']
            );
        }
        return $rooms;
    }
}

?>
