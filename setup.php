<?php
$host = 'localhost'; $db_name = 'tracen_db'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db_name");
    $pdo->exec("USE $db_name");

    // Reset tables
    $pdo->exec("DROP TABLE IF EXISTS trainees");
    $pdo->exec("DROP TABLE IF EXISTS characters");

    // Master Table
    $pdo->exec("CREATE TABLE characters (
        id VARCHAR(10) PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        b_spd INT, b_sta INT, b_pow INT, b_gut INT, b_wit INT,
        bon_spd INT, bon_sta INT, bon_pow INT, bon_gut INT, bon_wit INT,
        apt_turf VARCHAR(1), apt_dirt VARCHAR(1),
        apt_short VARCHAR(1), apt_mile VARCHAR(1), apt_medium VARCHAR(1), apt_long VARCHAR(1),
        apt_runner VARCHAR(1), apt_leader VARCHAR(1), apt_betweener VARCHAR(1), apt_chaser VARCHAR(1)
    )");

    // Trainees Table (Now with rating_score!)
    $pdo->exec("CREATE TABLE trainees (
        id INT AUTO_INCREMENT PRIMARY KEY,
        character_id VARCHAR(10) NOT NULL,
        final_rank VARCHAR(10) NULL,
        rating_score INT NULL, 
        stat_speed INT DEFAULT 0, stat_stamina INT DEFAULT 0, stat_power INT DEFAULT 0,
        stat_guts INT DEFAULT 0, stat_wit INT DEFAULT 0,
        notes TEXT NULL,
        logged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (character_id) REFERENCES characters(id) ON DELETE CASCADE
    )");

    // Seed Data
    $characters = [
        '100702' => ['Gold Ship (Summer)', [96, 113, 137, 89, 115], [0, 0, 20, 0, 10], ['A', 'G'], ['G', 'C', 'A', 'A'], ['G', 'B', 'B', 'A']],
        '101303' => ['Mejiro McQueen (Summer)', [92, 120, 93, 110, 135], [0, 0, 0, 10, 20], ['A', 'G'], ['G', 'G', 'A', 'A'], ['B', 'A', 'E', 'F']],
        '100103' => ['Special Week (Commander)', [110, 108, 93, 116, 123], [14, 0, 0, 8, 8], ['A', 'G'], ['G', 'C', 'A', 'A'], ['C', 'A', 'A', 'G']],
        '103601' => ['Air Shakur', [90, 106, 92, 125, 137], [0, 0, 0, 10, 20], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'E', 'A', 'A']],
        '101002' => ['Taiki Shuttle (Camping)', [113, 113, 101, 99, 124], [0, 15, 0, 15, 0], ['A', 'B'], ['A', 'A', 'E', 'G'], ['A', 'A', 'F', 'G']],
        '103802' => ['Curren Chan (Wedding)', [135, 78, 116, 92, 129], [10, 0, 10, 0, 10], ['A', 'G'], ['A', 'D', 'G', 'G'], ['B', 'A', 'G', 'G']],
        '102202' => ['Fine Motion (Wedding)', [112, 100, 93, 106, 139], [0, 0, 15, 0, 15], ['A', 'G'], ['G', 'A', 'A', 'G'], ['B', 'A', 'E', 'G']],
        '104401' => ['Sweep Tosho', [113, 100, 121, 93, 123], [0, 0, 20, 0, 10], ['A', 'G'], ['G', 'A', 'A', 'G'], ['G', 'G', 'A', 'A']],
        '105202' => ['Haru Urara (Alt)', [117, 85, 115, 129, 104], [0, 0, 15, 15, 0], ['G', 'A'], ['A', 'B', 'G', 'G'], ['G', 'G', 'A', 'A']],
        '106801' => ['Kitasan Black', [123, 115, 93, 115, 104], [20, 10, 0, 0, 0], ['A', 'G'], ['G', 'F', 'A', 'A'], ['A', 'E', 'F', 'G']],
        '106701' => ['Satono Diamond', [91, 135, 110, 98, 116], [0, 15, 0, 0, 15], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'E', 'A', 'F']]
    ];

    $stmt = $pdo->prepare("INSERT INTO characters VALUES (?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?, ?,?,?,?, ?,?,?,?)");
    foreach ($characters as $id => $d) {
        $prefix = substr($id, 0, 4);
        $img = "assets/images/characters/chara_stand_{$prefix}_{$id}.png";
        $stmt->execute([
            $id, $d[0], $img,
            $d[1][0], $d[1][1], $d[1][2], $d[1][3], $d[1][4],
            $d[2][0], $d[2][1], $d[2][2], $d[2][3], $d[2][4],
            $d[3][0], $d[3][1],
            $d[4][0], $d[4][1], $d[4][2], $d[4][3],
            $d[5][0], $d[5][1], $d[5][2], $d[5][3]
        ]);
    }
    
    echo "<h1>Database Reset & Updated Successfully!</h1>";
    echo "<a href='index.php'>Go to Dashboard</a>";

} catch(PDOException $e) { echo "Failed: " . $e->getMessage(); }
?>