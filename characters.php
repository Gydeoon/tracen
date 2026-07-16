<?php
session_start();
require_once 'config/database.php';

// Menangkap nilai input pencarian dan filter sorting dari URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';

// Menyusun kueri dasar SQL
$query = "SELECT * FROM characters";
$where_clauses = [];
$params = [];

// Logika Filter Pencarian Nama
if ($search !== '') {
    $where_clauses[] = "name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

if (count($where_clauses) > 0) {
    $query .= " WHERE " . implode(" AND ", $where_clauses);
}

// Logika Pengurutan (Sorting) Berdasarkan Abjad & Tingkat Bakat Jarak Lari (S -> G)
$order_sql = "name ASC"; 
if ($sort === 'name_desc') {
    $order_sql = "name DESC";
} elseif ($sort === 'sprint') {
    $order_sql = "CASE apt_short WHEN 'S' THEN 1 WHEN 'A' THEN 2 WHEN 'B' THEN 3 WHEN 'C' THEN 4 WHEN 'D' THEN 5 WHEN 'E' THEN 6 WHEN 'F' THEN 7 WHEN 'G' THEN 8 ELSE 9 END ASC, name ASC";
} elseif ($sort === 'mile') {
    $order_sql = "CASE apt_mile WHEN 'S' THEN 1 WHEN 'A' THEN 2 WHEN 'B' THEN 3 WHEN 'C' THEN 4 WHEN 'D' THEN 5 WHEN 'E' THEN 6 WHEN 'F' THEN 7 WHEN 'G' THEN 8 ELSE 9 END ASC, name ASC";
} elseif ($sort === 'medium') {
    $order_sql = "CASE apt_medium WHEN 'S' THEN 1 WHEN 'A' THEN 2 WHEN 'B' THEN 3 WHEN 'C' THEN 4 WHEN 'D' THEN 5 WHEN 'E' THEN 6 WHEN 'F' THEN 7 WHEN 'G' THEN 8 ELSE 9 END ASC, name ASC";
} elseif ($sort === 'long') {
    $order_sql = "CASE apt_long WHEN 'S' THEN 1 WHEN 'A' THEN 2 WHEN 'B' THEN 3 WHEN 'C' THEN 4 WHEN 'D' THEN 5 WHEN 'E' THEN 6 WHEN 'F' THEN 7 WHEN 'G' THEN 8 ELSE 9 END ASC, name ASC";
}

$query .= " ORDER BY " . $order_sql;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$characters = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Characters Directory | Tracen Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap');
        body { 
            font-family: 'Noto Sans JP', sans-serif; 
            background: linear-gradient(135deg, #EBF0FF 0%, #F4F5FA 50%, #FFF0F5 100%); 
            color: #333333; 
        }
        .uma-primary { background-color: #8A73FF; }
        .uma-primary-text { color: #8A73FF; }
        
        /* Optimasi ukuran badge agar tetap muat di mobile screen yang sempit */
        .apt-badge { display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 0.375rem; padding: 0.15rem 0; font-weight: 900; font-size: 0.65rem; text-align: center; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
        @media (min-width: 640px) {
            .apt-badge { border-radius: 0.5rem; padding: 0.25rem 0; font-size: 0.7rem; }
        }
        .apt-label { font-size: 0.45rem; letter-spacing: 0.02em; opacity: 0.7; margin-bottom: 1px; font-weight: 700; }
        @media (min-width: 640px) {
            .apt-label { font-size: 0.55rem; letter-spacing: 0.05em; }
        }
        
        .clean-select { background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 9999px; padding: 0.5rem 1rem; outline: none; transition: all 0.2s; cursor: pointer; font-weight: 700; color: #4B5563; font-size: 0.825rem;}
        @media (min-width: 640px) {
            .clean-select { padding: 0.6rem 1.25rem; font-size: 0.875rem; }
        }
        .clean-search { background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 9999px; padding: 0.5rem 1.25rem; outline: none; transition: all 0.2s; font-weight: 700; color: #4B5563; font-size: 0.825rem;}
        @media (min-width: 640px) {
            .clean-search { padding: 0.6rem 1.5rem; font-size: 0.875rem; }
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-12">
    
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <a href="index.php">
                    <h1 class="text-2xl font-black tracking-tight text-gray-900 uppercase italic">
                        Tracen <span class="uma-primary-text">Academy</span>
                    </h1>
                </a>
                <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Master Character Directory</p>
            </div>
            <div class="flex items-center gap-4 sm:gap-6 font-bold text-xs sm:text-sm text-gray-500">
                <a href="index.php" class="hover:text-[#8A73FF] transition">Dashboard</a>
                <a href="characters.php" class="uma-primary-text transition border-b-2 border-[#8A73FF] pb-1">Characters</a>
                <a href="add-trainee.php" class="uma-primary text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-full shadow-md hover:scale-105 transition-transform duration-200 text-xs sm:text-sm whitespace-nowrap">
                    + Register Trainee
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
        <div class="w-full bg-gradient-to-r from-[#7D66FF] to-[#A394FF] rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 mb-6 sm:mb-8 shadow-xl shadow-indigo-100/40 relative overflow-hidden flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 sm:gap-6">
            <div class="z-10">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white uppercase italic tracking-tight">Characters</h2>
            </div>
            
            <form action="characters.php" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 z-10 m-0">
                <div class="relative flex-1">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search character..." class="clean-search shadow-sm w-full sm:w-56 md:w-64">
                </div>

                <select name="sort" onchange="this.form.submit()" class="clean-select shadow-sm cursor-pointer bg-white">
                    <option value="name_asc" <?php if($sort === 'name_asc') echo 'selected'; ?>>Sort: Name (A-Z)</option>
                    <option value="name_desc" <?php if($sort === 'name_desc') echo 'selected'; ?>>Sort: Name (Z-A)</option>
                    <option value="sprint" <?php if($sort === 'sprint') echo 'selected'; ?>>Aptitude: Sprint Distance</option>
                    <option value="mile" <?php if($sort === 'mile') echo 'selected'; ?>>Aptitude: Mile Distance</option>
                    <option value="medium" <?php if($sort === 'medium') echo 'selected'; ?>>Aptitude: Medium Distance</option>
                    <option value="long" <?php if($sort === 'long') echo 'selected'; ?>>Aptitude: Long Distance</option>
                </select>

                <button type="submit" class="bg-gray-900 text-white font-black px-5 sm:px-6 py-2.5 sm:py-3 rounded-full text-xs sm:text-sm hover:bg-gray-800 transition shadow-md whitespace-nowrap">
                    Search
                </button>
                <?php if($search !== '' || $sort !== 'name_asc'): ?>
                    <a href="characters.php" class="flex items-center justify-center text-xs font-bold text-indigo-100 hover:text-white underline whitespace-nowrap py-1 sm:py-0 pl-1">Clear</a>
                <?php endif; ?>
            </form>

            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <?php if($search !== ''): ?>
            <p class="text-xs sm:text-sm font-bold text-gray-400 mb-6 bg-white/60 inline-block px-4 py-1.5 rounded-full border border-gray-100">
                Found <span class="text-gray-800 font-black"><?php echo count($characters); ?></span> results matching "<span class="uma-primary-text"><?php echo htmlspecialchars($search); ?></span>"
            </p>
        <?php endif; ?>
        
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
            <?php 
            $apt_colors = [
                'S' => 'bg-yellow-400 text-yellow-900', 'A' => 'bg-orange-400 text-white',
                'B' => 'bg-pink-400 text-white', 'C' => 'bg-green-500 text-white',
                'D' => 'bg-blue-400 text-white', 'E' => 'bg-purple-400 text-white',
                'F' => 'bg-purple-300 text-white', 'G' => 'bg-gray-300 text-gray-600'
            ];
            
            if(count($characters) > 0):
                foreach($characters as $c): 
                    $prefix = substr($c['id'], 0, 4);
                    $local_image = "assets/images/characters/chara_stand_{$prefix}_{$c['id']}.png";
                ?>
                    <div class="bg-white/90 rounded-[1.25rem] sm:rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.01)] sm:shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100 overflow-hidden flex flex-col group hover:shadow-[0_20px_40px_rgba(138,115,255,0.08)] hover:border-[#8A73FF]/30 transition-all duration-300 transform hover:-translate-y-0.5 sm:hover:-translate-y-1">
                        
                        <div class="relative w-full aspect-[4/5] bg-gradient-to-b from-gray-50/50 to-gray-100/80 flex items-end justify-center overflow-hidden border-b border-gray-100 p-2 sm:p-4">
                            <img src="<?php echo htmlspecialchars($local_image); ?>" 
                                 alt="<?php echo htmlspecialchars($c['name']); ?>" 
                                 class="w-[92%] sm:w-[88%] h-auto object-contain object-bottom group-hover:scale-105 transition-transform duration-500 ease-out z-10"
                                 onerror="this.src='https://via.placeholder.com/400x500.png?text=Image+Not+Found'">
                        </div>

                        <div class="p-3 sm:p-6 flex-1 flex flex-col justify-between bg-white">
                            <div>
                                <h3 class="text-sm sm:text-xl font-black text-gray-900 text-center leading-tight mb-2 sm:mb-4 tracking-tight group-hover:uma-primary-text transition-colors truncate">
                                    <?php echo htmlspecialchars($c['name']); ?>
                                </h3>

                                <div class="grid grid-cols-5 gap-0.5 sm:gap-1.5 text-center font-mono mb-3 sm:mb-5">
                                    <div class="bg-blue-50/40 p-1 sm:p-1.5 rounded-md sm:rounded-xl border border-blue-100/50"><p class="text-[7px] sm:text-[8px] font-bold text-blue-500 uppercase">Spd</p><p class="text-[10px] sm:text-xs font-black text-gray-800"><?php echo $c['b_spd']; ?></p></div>
                                    <div class="bg-pink-50/40 p-1 sm:p-1.5 rounded-md sm:rounded-xl border border-pink-100/50"><p class="text-[7px] sm:text-[8px] font-bold text-pink-500 uppercase">Sta</p><p class="text-[10px] sm:text-xs font-black text-gray-800"><?php echo $c['b_sta']; ?></p></div>
                                    <div class="bg-orange-50/40 p-1 sm:p-1.5 rounded-md sm:rounded-xl border border-orange-100/50"><p class="text-[7px] sm:text-[8px] font-bold text-orange-500 uppercase">Pow</p><p class="text-[10px] sm:text-xs font-black text-gray-800"><?php echo $c['b_pow']; ?></p></div>
                                    <div class="bg-red-50/40 p-1 sm:p-1.5 rounded-md sm:rounded-xl border border-red-100/50"><p class="text-[7px] sm:text-[8px] font-bold text-red-500 uppercase">Gut</p><p class="text-[10px] sm:text-xs font-black text-gray-800"><?php echo $c['b_gut']; ?></p></div>
                                    <div class="bg-green-50/40 p-1 sm:p-1.5 rounded-md sm:rounded-xl border border-green-100/50"><p class="text-[7px] sm:text-[8px] font-bold text-green-500 uppercase">Wit</p><p class="text-[10px] sm:text-xs font-black text-gray-800"><?php echo $c['b_wit']; ?></p></div>
                                </div>

                                <div class="space-y-2 mb-3 sm:mb-5 border-t border-gray-50 pt-2 sm:pt-4">
                                    <div class="grid grid-cols-4 gap-1 sm:gap-1.5">
                                        <div class="apt-badge <?php echo $apt_colors[$c['apt_short']] ?? 'bg-gray-100'; ?>"><span class="apt-label">SPRINT</span><?php echo $c['apt_short']; ?></div>
                                        <div class="apt-badge <?php echo $apt_colors[$c['apt_mile']] ?? 'bg-gray-100'; ?>"><span class="apt-label">MILE</span><?php echo $c['apt_mile']; ?></div>
                                        <div class="apt-badge <?php echo $apt_colors[$c['apt_medium']] ?? 'bg-gray-100'; ?>"><span class="apt-label">MEDIUM</span><?php echo $c['apt_medium']; ?></div>
                                        <div class="apt-badge <?php echo $apt_colors[$c['apt_long']] ?? 'bg-gray-100'; ?>"><span class="apt-label">LONG</span><?php echo $c['apt_long']; ?></div>
                                    </div>
                                </div>
                            </div>

                            <a href="add-trainee.php?char_id=<?php echo $c['id']; ?>" 
                               class="block w-full text-center uma-primary text-white text-[10px] sm:text-xs font-black py-2 sm:py-3 rounded-lg sm:rounded-xl hover:bg-opacity-95 transition shadow-sm tracking-wider sm:tracking-widest uppercase">
                                Train
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                    <p class="text-gray-400 font-bold text-lg">No characters match your search filter criteria. <a href="characters.php" class="uma-primary-text underline font-black">Reset directory</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>