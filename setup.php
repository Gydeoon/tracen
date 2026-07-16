<?php
$host = 'localhost'; $db_name = 'tracen_db'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db_name");
    $pdo->exec("USE $db_name");

    // Wiping current tables to perform a clean deployment
    $pdo->exec("DROP TABLE IF EXISTS trainees");
    $pdo->exec("DROP TABLE IF EXISTS characters");

    // 1. Re-create the Master Character Table
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

    // 2. Re-create the Core Trainee Log Table
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
        '106701' => ['Satono Diamond', [91, 135, 110, 98, 116], [0, 15, 0, 0, 15], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'E', 'A', 'F']],
        '105301' => ['Bamboo Memory', [95, 80, 110, 100, 85], [10, 0, 20, 0, 0], ['A', 'G'], ['A', 'A', 'E', 'G'], ['G', 'B', 'A', 'B']],
        '105902' => ['Mejiro Dober', [90, 95, 95, 80, 110], [0, 0, 10, 0, 20], ['A', 'G'], ['G', 'A', 'A', 'E'], ['G', 'A', 'A', 'F']],
        '103401' => ['Inari One', [85, 105, 105, 110, 75], [0, 0, 15, 15, 0], ['A', 'A'], ['G', 'G', 'A', 'A'], ['G', 'B', 'A', 'A']],
        '106401' => ['Mejiro Palmer', [95, 115, 85, 110, 75], [0, 10, 0, 20, 0], ['A', 'G'], ['G', 'F', 'A', 'A'], ['A', 'F', 'E', 'G']],
        '103101' => ['Ines Fujin', [105, 100, 95, 90, 80], [10, 0, 0, 20, 0], ['A', 'G'], ['G', 'A', 'A', 'F'], ['A', 'B', 'F', 'G']],
        '106002' => ['Nice Nature', [80, 100, 90, 105, 95], [0, 0, 0, 20, 10], ['A', 'G'], ['G', 'G', 'A', 'A'], ['G', 'B', 'A', 'C']],
        '106102' => ['King Halo', [100, 85, 100, 90, 95], [10, 0, 10, 0, 10], ['A', 'G'], ['A', 'B', 'B', 'C'], ['G', 'B', 'B', 'A']],
        '107201' => ['Yaeno Muteki', [100, 85, 110, 90, 85], [10, 0, 20, 0, 0], ['A', 'G'], ['G', 'B', 'A', 'E'], ['G', 'A', 'A', 'F']],
        '105101' => ['Nishino Flower', [110, 75, 95, 90, 110], [15, 0, 0, 0, 15], ['A', 'G'], ['A', 'A', 'G', 'G'], ['G', 'A', 'B', 'G']],
        '100502' => ['Fuji Kiseki (Alt)', [105, 80, 105, 90, 90], [20, 0, 10, 0, 0], ['A', 'G'], ['G', 'A', 'B', 'G'], ['G', 'A', 'B', 'G']],
        '102002' => ['Seiun Sky (Alt)', [90, 110, 85, 90, 105], [0, 10, 0, 0, 20], ['A', 'G'], ['G', 'E', 'A', 'A'], ['A', 'C', 'G', 'G']],
        '103301' => ['Admire Vega', [100, 85, 100, 90, 95], [10, 0, 0, 0, 20], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'C', 'B', 'A']],
        '107401' => ['Mejiro Bright', [80, 120, 90, 100, 80], [0, 10, 0, 20, 0], ['A', 'G'], ['G', 'G', 'B', 'A'], ['G', 'C', 'A', 'A']],
        '104502' => ['Super Creek (Alt)', [85, 115, 90, 90, 95], [0, 10, 0, 0, 20], ['A', 'G'], ['G', 'E', 'A', 'A'], ['G', 'A', 'B', 'G']],
        '101901' => ['Agnes Digital', [95, 90, 100, 85, 100], [0, 0, 10, 0, 20], ['A', 'A'], ['G', 'A', 'A', 'G'], ['F', 'A', 'A', 'G']],
        '102801' => ['Hishi Akebono', [95, 90, 115, 100, 70], [0, 10, 20, 0, 0], ['A', 'B'], ['A', 'A', 'G', 'G'], ['B', 'A', 'G', 'G']],
        '105602' => ['Matikanefukukitaru', [85, 100, 95, 100, 90], [0, 0, 0, 10, 20], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'B', 'A', 'C']],
        '103701' => ['Eishin Flash', [100, 90, 95, 90, 95], [10, 0, 0, 0, 20], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'A', 'A', 'F']],
        '100102' => ['Special Week (Alt)', [102, 100, 98, 92, 108], [0, 10, 20, 0, 0], ['A', 'G'], ['G', 'C', 'A', 'A'], ['F', 'A', 'A', 'G']],
        '100402' => ['Maruzensky (Alt)', [115, 90, 100, 95, 100], [10, 0, 20, 0, 0], ['A', 'B'], ['B', 'A', 'B', 'G'], ['A', 'B', 'F', 'G']],
        '104001' => ['Gold City', [100, 95, 95, 85, 100], [0, 0, 10, 0, 20], ['A', 'G'], ['G', 'A', 'A', 'C'], ['F', 'B', 'A', 'E']],
        '100501' => ['Fuji Kiseki', [100, 85, 100, 95, 95], [20, 0, 10, 0, 0], ['A', 'G'], ['G', 'A', 'B', 'G'], ['G', 'A', 'B', 'G']],
        '103201' => ['Agnes Tachyon', [95, 90, 95, 90, 110], [0, 0, 0, 0, 20], ['A', 'G'], ['G', 'A', 'A', 'G'], ['F', 'A', 'A', 'G']],
        '102701' => ['Mejiro Ryan', [90, 100, 105, 95, 85], [0, 0, 20, 10, 0], ['A', 'G'], ['G', 'G', 'A', 'B'], ['F', 'A', 'A', 'F']],
        '104501' => ['Super Creek', [85, 110, 90, 95, 95], [0, 10, 0, 0, 20], ['A', 'G'], ['G', 'E', 'A', 'A'], ['G', 'A', 'B', 'G']],
        '102401' => ['Mayano Top Gun', [95, 105, 90, 95, 90], [0, 10, 0, 10, 0], ['A', 'E'], ['G', 'B', 'A', 'A'], ['A', 'A', 'B', 'B']],
        '101801' => ['Air Groove', [105, 90, 100, 90, 90], [10, 0, 0, 0, 20], ['A', 'G'], ['G', 'A', 'A', 'G'], ['F', 'A', 'A', 'G']],
        '101401' => ['El Condor Pasa', [95, 95, 100, 90, 95], [0, 0, 10, 0, 20], ['A', 'B'], ['F', 'A', 'A', 'E'], ['B', 'A', 'B', 'G']],
        '101101' => ['Grass Wonder', [90, 100, 95, 95, 95], [0, 0, 0, 20, 10], ['A', 'G'], ['G', 'A', 'A', 'B'], ['G', 'B', 'A', 'B']],
        '100901' => ['Daiwa Scarlet', [100, 95, 95, 90, 95], [10, 0, 0, 10, 0], ['A', 'G'], ['G', 'A', 'A', 'F'], ['A', 'A', 'F', 'G']],
        '100801' => ['Vodka', [100, 85, 105, 95, 90], [0, 0, 20, 10, 0], ['A', 'G'], ['G', 'A', 'A', 'F'], ['G', 'B', 'A', 'G']],
        '100701' => ['Gold Ship', [90, 110, 100, 100, 80], [0, 20, 0, 10, 0], ['A', 'G'], ['G', 'G', 'A', 'A'], ['G', 'C', 'B', 'A']],
        '106201' => ['Matikane Tannhauser', [85, 105, 95, 100, 90], [0, 10, 0, 20, 0], ['A', 'G'], ['G', 'G', 'A', 'A'], ['G', 'A', 'A', 'F']],
        '103001' => ['Rice Shower', [85, 115, 90, 95, 90], [0, 10, 0, 20, 0], ['A', 'G'], ['G', 'G', 'A', 'A'], ['F', 'A', 'B', 'G']],
        '101301' => ['Mejiro McQueen', [90, 115, 90, 100, 80], [0, 20, 0, 0, 10], ['A', 'G'], ['G', 'G', 'A', 'A'], ['B', 'A', 'E', 'F']],
        '101001' => ['Taiki Shuttle', [110, 90, 105, 90, 80], [0, 0, 20, 0, 10], ['A', 'B'], ['A', 'A', 'E', 'G'], ['A', 'A', 'E', 'G']],
        '100101' => ['Special Week', [85, 110, 95, 95, 115], [0, 20, 0, 0, 10], ['A', 'G'], ['G', 'C', 'A', 'A'], ['F', 'A', 'A', 'G']],
        '100201' => ['Silence Suzuka', [120, 85, 90, 90, 90], [20, 0, 0, 0, 10], ['A', 'G'], ['G', 'A', 'A', 'E'], ['A', 'B', 'F', 'G']],
        '100301' => ['Tokai Teio', [110, 80, 95, 95, 95], [20, 0, 0, 0, 10], ['A', 'G'], ['G', 'A', 'A', 'E'], ['G', 'A', 'B', 'F']],
        '100401' => ['Maruzensky', [110, 90, 95, 95, 85], [10, 0, 0, 0, 20], ['A', 'B'], ['B', 'A', 'B', 'G'], ['A', 'B', 'F', 'G']],
        '100601' => ['Oguri Cap', [100, 90, 105, 95, 85], [0, 0, 20, 0, 10], ['A', 'B'], ['G', 'A', 'A', 'B'], ['G', 'A', 'A', 'F']],
        '101501' => ['TM Opera O', [90, 105, 95, 100, 85], [0, 0, 0, 20, 10], ['A', 'G'], ['G', 'F', 'A', 'A'], ['B', 'A', 'B', 'F']],
        '102601' => ['Mihono Bourbon', [115, 90, 95, 95, 80], [0, 10, 20, 0, 0], ['A', 'G'], ['G', 'B', 'A', 'G'], ['A', 'B', 'G', 'G']],
        '102301' => ['Biwa Hayahide', [90, 95, 95, 90, 110], [0, 0, 0, 10, 20], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'A', 'B', 'F']],
        '101302' => ['Mejiro McQueen (Alt)', [90, 110, 95, 105, 80], [0, 10, 0, 20, 0], ['A', 'G'], ['G', 'G', 'A', 'A'], ['B', 'A', 'E', 'F']],
        '100302' => ['Tokai Teio (Alt)', [105, 85, 95, 95, 95], [0, 10, 20, 0, 0], ['A', 'G'], ['G', 'A', 'A', 'E'], ['G', 'A', 'B', 'F']],
        '102402' => ['Mayano Top Gun (Alt)', [95, 100, 95, 95, 90], [0, 0, 10, 20, 0], ['A', 'E'], ['G', 'B', 'A', 'A'], ['A', 'A', 'B', 'B']],
        '101601' => ['Narita Brian', [105, 95, 100, 85, 90], [10, 0, 20, 0, 0], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'B', 'A', 'F']],
        '104601' => ['Smart Falcon', [115, 80, 100, 95, 85], [20, 0, 10, 0, 0], ['E', 'A'], ['A', 'A', 'E', 'G'], ['A', 'B', 'G', 'G']],
        '105001' => ['Narita Taishin', [100, 80, 95, 95, 105], [0, 0, 10, 0, 20], ['A', 'G'], ['G', 'D', 'A', 'B'], ['G', 'F', 'B', 'A']],
        '103801' => ['Curren Chan', [125, 75, 105, 95, 80], [10, 0, 20, 0, 0], ['A', 'G'], ['A', 'B', 'G', 'G'], ['A', 'A', 'F', 'G']],
        '101802' => ['Air Groove (Alt)', [100, 95, 95, 95, 90], [0, 10, 20, 0, 0], ['A', 'G'], ['G', 'A', 'A', 'G'], ['F', 'A', 'A', 'G']],
        '102001' => ['Seiun Sky', [95, 105, 85, 90, 100], [0, 10, 0, 0, 20], ['A', 'G'], ['G', 'E', 'A', 'A'], ['A', 'C', 'G', 'G']],
        '101201' => ['Hishi Amazon', [95, 95, 105, 95, 85], [0, 0, 20, 10, 0], ['A', 'G'], ['G', 'A', 'A', 'B'], ['G', 'B', 'A', 'B']],
        '101402' => ['El Condor Pasa (Alt)', [100, 90, 95, 100, 90], [0, 10, 0, 20, 0], ['A', 'B'], ['F', 'A', 'A', 'E'], ['B', 'A', 'B', 'G']],
        '101102' => ['Grass Wonder (Alt)', [95, 95, 100, 95, 90], [10, 0, 20, 0, 0], ['A', 'G'], ['G', 'A', 'A', 'B'], ['G', 'B', 'A', 'B']],
        '105801' => ['Meisho Doto', [85, 105, 100, 95, 90], [0, 10, 10, 10, 0], ['A', 'G'], ['G', 'F', 'A', 'A'], ['G', 'A', 'A', 'F']],
        '101701' => ['Symboli Rudolf', [90, 105, 95, 95, 90], [0, 20, 0, 0, 10], ['A', 'G'], ['G', 'E', 'A', 'A'], ['G', 'A', 'A', 'G']]
    ];

    $stmt = $pdo->prepare("INSERT INTO characters VALUES (?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?, ?,?,?,?, ?,?,?,?)");
    foreach ($characters as $id => $d) {
        $prefix = substr($id, 0, 4);
        $img = "assets/images/characters/chara_stand_{$prefix}_{$id}.png";
        $stmt->execute([
            $id, $d[0], $img,
            $d[1][0], $d[1][1], $d[1][2], $d[1][3], $d[1][4], // Base Stats
            $d[2][0], $d[2][1], $d[2][2], $d[2][3], $d[2][4], // Growth Bonuses
            $d[3][0], $d[3][1],                               // Ground Surfaces
            $d[4][0], $d[4][1], $d[4][2], $d[4][3],           // Track Distance
            $d[5][0], $d[5][1], $d[5][2], $d[5][3]            // Run Strategy
        ]);
    }
    
    echo "<h1>Sukses! Roster Proyek Berhasil Diperbarui. Total: " . count($characters) . " Karakter Aktif.</h1>";
    echo "<a href='index.php'>Buka Dashboard</a>";

} catch(PDOException $e) { 
    echo "Gagal Memasang Database Roster: " . $e->getMessage(); 
}
?>