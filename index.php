<?php
session_start();
require_once 'config/database.php';

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$rank_filter = isset($_GET['rank_filter']) ? $_GET['rank_filter'] : '';

$order_sql = "trainees.logged_at DESC"; 
if ($sort === 'oldest') {
    $order_sql = "trainees.logged_at ASC";
} elseif ($sort === 'name_asc') {
    $order_sql = "characters.name ASC";
} elseif ($sort === 'stats_desc') {
    $order_sql = "(trainees.stat_speed + trainees.stat_stamina + trainees.stat_power + trainees.stat_guts + trainees.stat_wit) DESC";
} elseif ($sort === 'rating_desc') {
    $order_sql = "trainees.rating_score DESC";
}

$where_clauses = [];
$params = [];

if ($search !== '') {
    $where_clauses[] = "characters.name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}
if ($rank_filter !== '') {
    $where_clauses[] = "trainees.final_rank = :rank_filter";
    $params[':rank_filter'] = $rank_filter;
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";

$query = "SELECT trainees.*, characters.name AS uma_name, characters.id AS char_id 
          FROM trainees 
          JOIN characters ON trainees.character_id = characters.id 
          $where_sql
          ORDER BY $order_sql";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$trainees = $stmt->fetchAll();

$rank_order = ['US','UA','UB','UC','UD','UE','UF','UG','SS+','SS','S+','S','A+','A','B+','B','C+','C','D+','D','E+','E','F+','F','G+','G'];
$existing_ranks = $pdo->query("SELECT DISTINCT final_rank FROM trainees WHERE final_rank IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);
$available_ranks = array_values(array_filter($rank_order, fn($r) => in_array($r, $existing_ranks)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracen Academy | Official Trainee Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap');
        body { font-family: 'Noto Sans JP', sans-serif; background-color: #F5F6FA; color: #333333; }
        .uma-primary { background-color: #8A73FF; }
        .uma-primary-text { color: #8A73FF; }
        .clean-select { background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 9999px; padding: 0.5rem 1rem; outline: none; transition: all 0.2s; cursor: pointer; font-weight: 700; color: #4B5563; font-size: 0.875rem;}
        .clean-select:focus { border-color: #8A73FF; box-shadow: 0 0 0 3px rgba(138, 115, 255, 0.2); }
        .clean-search { background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 9999px; padding: 0.5rem 1.25rem; outline: none; transition: all 0.2s; font-weight: 700; color: #4B5563; font-size: 0.875rem;}
        .clean-search:focus { border-color: #8A73FF; box-shadow: 0 0 0 3px rgba(138, 115, 255, 0.2); }
    </style>
</head>
<body class="antialiased min-h-screen pb-12">
    
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <a href="index.php">
                    <h1 class="text-2xl font-black tracking-tight text-gray-900 uppercase italic text-center md:text-left">
                        Tracen <span class="uma-primary-text">Academy</span>
                    </h1>
                </a>
                <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase text-center md:text-left">Trainee Database Log</p>
            </div>
            
            <div class="flex flex-wrap items-center justify-center gap-4">
                <form action="index.php" method="GET" class="flex flex-wrap items-center justify-center gap-3 m-0">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by character..." class="clean-search shadow-sm w-48">

                    <select name="rank_filter" onchange="this.form.submit()" class="clean-select shadow-sm">
                        <option value="">All Ranks</option>
                        <?php foreach($available_ranks as $r): ?>
                            <option value="<?php echo htmlspecialchars($r); ?>" <?php if($rank_filter === $r) echo 'selected'; ?>><?php echo htmlspecialchars($r); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select name="sort" onchange="this.form.submit()" class="clean-select shadow-sm">
                        <option value="newest" <?php if($sort == 'newest') echo 'selected'; ?>>Sort: Newest First</option>
                        <option value="oldest" <?php if($sort == 'oldest') echo 'selected'; ?>>Sort: Oldest First</option>
                        <option value="stats_desc" <?php if($sort == 'stats_desc') echo 'selected'; ?>>Sort: Highest Total Stats</option>
                        <option value="rating_desc" <?php if($sort == 'rating_desc') echo 'selected'; ?>>Sort: Highest Rating</option>
                        <option value="name_asc" <?php if($sort == 'name_asc') echo 'selected'; ?>>Sort: Name (A-Z)</option>
                    </select>

                    <button type="submit" class="uma-primary text-white px-5 py-2 rounded-full font-bold shadow-md hover:scale-105 transition-transform duration-200 text-sm">Filter</button>
                    <?php if($search !== '' || $rank_filter !== ''): ?>
                        <a href="index.php" class="text-xs font-bold text-gray-400 hover:text-gray-700 underline">Clear</a>
                    <?php endif; ?>
                </form>

                <div class="h-6 w-[1px] bg-gray-200 hidden md:block"></div>

                <div class="flex items-center gap-4 font-bold text-sm text-gray-500">
                    <a href="index.php" class="uma-primary-text border-b-2 border-[#8A73FF] pb-1">Dashboard</a>
                    <a href="characters.php" class="hover:text-[#8A73FF] transition">Characters</a>
                </div>

                <a href="add-trainee.php" class="uma-primary text-white px-6 py-2.5 rounded-full font-bold shadow-md hover:scale-105 transition-transform duration-200 text-sm whitespace-nowrap">
                    + Register New Trainee
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 mt-8">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="bg-white border-l-4 border-[#8A73FF] text-gray-700 p-4 rounded shadow-sm mb-8 font-bold">
                ✓ <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if($search !== '' || $rank_filter !== ''): ?>
            <p class="text-sm font-bold text-gray-400 mb-4">
                Showing <?php echo count($trainees); ?> result<?php echo count($trainees) !== 1 ? 's' : ''; ?>
                <?php if($search !== ''): ?> for "<span class="text-gray-700"><?php echo htmlspecialchars($search); ?></span>"<?php endif; ?>
                <?php if($rank_filter !== ''): ?> ranked <span class="text-gray-700"><?php echo htmlspecialchars($rank_filter); ?></span><?php endif; ?>
            </p>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if(count($trainees) > 0): ?>
                <?php foreach($trainees as $t): ?>
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-100 flex flex-col relative">
                        
                        <div class="relative w-full aspect-[4/5] bg-gray-100 flex items-end justify-center overflow-hidden border-b border-gray-100">
                            <?php 
                                $prefix = substr($t['character_id'], 0, 4);
                                $local_image = "assets/images/characters/chara_stand_{$prefix}_{$t['character_id']}.png";
                            ?>
                            <img src="<?php echo htmlspecialchars($local_image); ?>" 
                                 alt="<?php echo htmlspecialchars($t['uma_name']); ?>" 
                                 class="w-[90%] h-auto object-contain object-bottom group-hover:scale-110 transition-transform duration-500 ease-out z-10">
                        </div>

                        <div class="p-5 flex-1 flex flex-col bg-white z-20">
                            <h3 class="text-lg font-black text-gray-900 text-center leading-tight mb-3">
                                <?php echo htmlspecialchars($t['uma_name']); ?>
                            </h3>
                            
                            <div class="flex justify-center gap-2 mb-4">
                                <?php if($t['final_rank']): ?>
                                    <span class="bg-[#FFE5F1] text-[#FF6699] px-3 py-1 rounded-full text-xs font-black shadow-sm border border-[#FFB3D9]">
                                        RANK: <?php echo htmlspecialchars($t['final_rank']); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if($t['rating_score']): ?>
                                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-black shadow-sm border border-indigo-100">
                                        Score: <?php echo number_format($t['rating_score']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="grid grid-cols-5 gap-1 mb-4">
                                <div class="text-center"><p class="text-[9px] font-bold text-blue-500 bg-blue-50 rounded-t py-1">SPD</p><p class="text-xs font-black text-gray-700 border border-t-0 border-blue-50 rounded-b py-1"><?php echo $t['stat_speed']; ?></p></div>
                                <div class="text-center"><p class="text-[9px] font-bold text-pink-500 bg-pink-50 rounded-t py-1">STA</p><p class="text-xs font-black text-gray-700 border border-t-0 border-pink-50 rounded-b py-1"><?php echo $t['stat_stamina']; ?></p></div>
                                <div class="text-center"><p class="text-[9px] font-bold text-orange-500 bg-orange-50 rounded-t py-1">POW</p><p class="text-xs font-black text-gray-700 border border-t-0 border-orange-50 rounded-b py-1"><?php echo $t['stat_power']; ?></p></div>
                                <div class="text-center"><p class="text-[9px] font-bold text-red-500 bg-red-50 rounded-t py-1">GUT</p><p class="text-xs font-black text-gray-700 border border-t-0 border-red-50 rounded-b py-1"><?php echo $t['stat_guts']; ?></p></div>
                                <div class="text-center"><p class="text-[9px] font-bold text-green-500 bg-green-50 rounded-t py-1">WIT</p><p class="text-xs font-black text-gray-700 border border-t-0 border-green-50 rounded-b py-1"><?php echo $t['stat_wit']; ?></p></div>
                            </div>

                            <?php if(!empty($t['notes'])): ?>
                                <p class="text-[10px] text-gray-400 font-bold text-center mb-4 truncate border-t border-gray-50 pt-3">
                                    "<?php echo htmlspecialchars($t['notes']); ?>"
                                </p>
                            <?php endif; ?>

                            <div class="mt-auto opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex gap-2 pt-2">
                                <a href="edit-trainee.php?id=<?php echo $t['id']; ?>" class="flex-1 text-center bg-gray-100 hover:bg-[#8A73FF] hover:text-white text-gray-500 text-[10px] font-black py-2 rounded-lg transition-colors uppercase tracking-widest">Edit</a>
                                <a href="delete-trainee.php?id=<?php echo $t['id']; ?>" class="flex-1 text-center bg-gray-100 hover:bg-red-500 hover:text-white text-gray-500 text-[10px] font-black py-2 rounded-lg transition-colors uppercase tracking-widest" onclick="return confirm('Retire (Delete) this record?');">Retire</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-white p-12 text-center rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 font-bold text-lg">
                        <?php if($search !== '' || $rank_filter !== ''): ?>
                            No trainees match your search. <a href="index.php" class="uma-primary-text underline">Clear filters</a> to see everyone.
                        <?php else: ?>
                            No training data available. Please register a new character.
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>