<?php
session_start();
require_once 'config/database.php';
require_once 'includes/rating.php';

$char_stmt = $pdo->query("SELECT * FROM characters ORDER BY name ASC");
$characters = $char_stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Rating Score and Final Rank are now derived server-side from the
    // submitted stats, never trusted from the client.
    $score = calculateRatingScore(
        $_POST['stat_speed'], $_POST['stat_stamina'], $_POST['stat_power'],
        $_POST['stat_guts'], $_POST['stat_wit']
    );
    $rank = calculateFinalRank($score);

    $query = "INSERT INTO trainees (character_id, stat_speed, stat_stamina, stat_power, stat_guts, stat_wit, final_rank, rating_score, notes) 
              VALUES (:char_id, :spd, :sta, :pow, :gut, :wit, :rank, :score, :notes)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':char_id' => $_POST['character_id'], 
        ':rank' => $rank, 
        ':score' => $score, 
        ':notes' => $_POST['notes'],
        ':spd' => $_POST['stat_speed'], ':sta' => $_POST['stat_stamina'], ':pow' => $_POST['stat_power'], 
        ':gut' => $_POST['stat_guts'], ':wit' => $_POST['stat_wit']
    ]);
    $_SESSION['message'] = "Training Data Successfully Saved!";
    header("Location: index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Trainee | Tracen Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap');
        body { font-family: 'Noto Sans JP', sans-serif; background-color: #F5F6FA; color: #333333; }
        .uma-primary { background-color: #8A73FF; }
        .uma-primary-text { color: #8A73FF; }
        .clean-input { background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 0.75rem; padding: 0.75rem 1rem; width: 100%; transition: all 0.2s; outline: none; }
        .clean-input:focus { border-color: #8A73FF; box-shadow: 0 0 0 3px rgba(138, 115, 255, 0.2); background-color: #FFFFFF; }
        .apt-badge { display:flex; flex-direction:column; align-items:center; justify-content:center; border-radius: 0.5rem; padding: 0.35rem 0; font-weight: 900; font-size: 0.7rem; }
        .apt-label { font-size: 0.55rem; letter-spacing: 0.05em; opacity:0.7; margin-bottom:2px; }
    </style>
</head>
<body class="antialiased min-h-screen py-10 flex items-center justify-center">
    
    <div class="w-full max-w-5xl bg-white p-8 md:p-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
        
        <div class="flex justify-between items-center mb-10 pb-6 border-b border-gray-100">
            <div><h2 class="text-3xl font-black text-gray-900 uppercase italic tracking-tight">Register <span class="text-[#FF6699]">Trainee</span></h2></div>
            <a href="index.php" class="text-sm font-bold text-gray-400 hover:text-gray-800 transition bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-full shadow-sm">← Back to Database</a>
        </div>

        <form action="add-trainee.php" method="POST" class="flex flex-col md:flex-row gap-10">
            <div class="w-full md:w-1/3 flex flex-col gap-4">
                <div class="w-full aspect-[4/5] bg-gray-100 rounded-2xl flex items-end justify-center overflow-hidden relative shadow-inner border border-gray-200">
                    <img id="uiImg" src="" class="w-[90%] h-auto object-contain object-bottom hidden absolute z-10 transition-transform duration-500">
                    <span id="placeholderText" class="text-gray-400 text-sm font-bold z-20 mb-10 tracking-widest">CHARACTER PREVIEW</span>
                </div>

                <div id="aptitudePanel" class="hidden bg-gray-50 rounded-2xl border border-gray-100 p-4">
                    <p class="text-xs font-black text-gray-400 mb-3 uppercase tracking-wide">Aptitude</p>
                    <div class="mb-3">
                        <p class="apt-label uppercase text-gray-400 font-bold">Track</p>
                        <div class="grid grid-cols-2 gap-2" id="aptTrack"></div>
                    </div>
                    <div class="mb-3">
                        <p class="apt-label uppercase text-gray-400 font-bold">Distance</p>
                        <div class="grid grid-cols-4 gap-2" id="aptDistance"></div>
                    </div>
                    <div>
                        <p class="apt-label uppercase text-gray-400 font-bold">Strategy</p>
                        <div class="grid grid-cols-4 gap-2" id="aptStrategy"></div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3 space-y-6">
                <div>
                    <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide">Select Uma Musume</label>
                    <select name="character_id" id="charSelect" required class="clean-input font-bold text-gray-800 cursor-pointer">
                        <option value="" disabled selected>-- Select Character --</option>
                        <?php foreach($characters as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide">Final Stats</label>
                    <div class="grid grid-cols-5 gap-3">
                        <input type="number" name="stat_speed" id="stat_speed" placeholder="SPD" class="clean-input text-center font-bold !px-1 text-blue-600 focus:!border-blue-500" required>
                        <input type="number" name="stat_stamina" id="stat_stamina" placeholder="STA" class="clean-input text-center font-bold !px-1 text-pink-600 focus:!border-pink-500" required>
                        <input type="number" name="stat_power" id="stat_power" placeholder="POW" class="clean-input text-center font-bold !px-1 text-orange-600 focus:!border-orange-500" required>
                        <input type="number" name="stat_guts" id="stat_guts" placeholder="GUT" class="clean-input text-center font-bold !px-1 text-red-600 focus:!border-red-500" required>
                        <input type="number" name="stat_wit" id="stat_wit" placeholder="WIT" class="clean-input text-center font-bold !px-1 text-green-600 focus:!border-green-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide">Estimated Rating</label>
                        <div id="ratingPreview" class="clean-input font-black text-gray-400 bg-gray-100 flex items-center justify-center select-none">— auto —</div>
                        <p class="text-[9px] text-gray-400 font-bold mt-1 leading-tight">Calculated from stats, like the UmaTools rating calculator.</p>
                    </div>
                    
                    <div class="md:col-span-1">
                        <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide text-center">Rank</label>
                        <div id="rankDisplay" class="bg-gray-200 text-gray-400 font-black h-[46px] rounded-xl flex items-center justify-center text-xl transition-colors shadow-inner">?</div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide">Trainer Notes</label>
                        <input type="text" name="notes" placeholder="Optional..." class="clean-input text-gray-700 font-medium">
                    </div>
                </div>
                
                <button type="submit" class="w-full uma-primary text-white font-black py-4 rounded-xl hover:scale-[1.02] transition-transform shadow-lg shadow-purple-200 mt-4 text-lg tracking-wider">
                    SAVE TO DATABASE
                </button>
            </div>
        </form>
    </div>

    <script>
        const CHAR_DATA = <?php echo json_encode(array_column($characters, null, 'id')); ?>;

        const APT_COLORS = {
            'S': 'bg-yellow-400 text-yellow-900', 'A': 'bg-orange-400 text-white',
            'B': 'bg-pink-400 text-white', 'C': 'bg-green-500 text-white',
            'D': 'bg-blue-400 text-white', 'E': 'bg-purple-400 text-white',
            'F': 'bg-purple-300 text-white', 'G': 'bg-gray-300 text-gray-600'
        };

        function aptBadge(label, grade) {
            const colorClass = APT_COLORS[grade] || APT_COLORS['G'];
            return `<div class="apt-badge ${colorClass}"><span class="apt-label">${label}</span><span>${grade || 'G'}</span></div>`;
        }

        function renderAptitudes(char) {
            const panel = document.getElementById('aptitudePanel');
            if (!char) { panel.classList.add('hidden'); return; }
            panel.classList.remove('hidden');
            document.getElementById('aptTrack').innerHTML = aptBadge('TURF', char.apt_turf) + aptBadge('DIRT', char.apt_dirt);
            document.getElementById('aptDistance').innerHTML =
                aptBadge('SHORT', char.apt_short) + aptBadge('MILE', char.apt_mile) +
                aptBadge('MEDIUM', char.apt_medium) + aptBadge('LONG', char.apt_long);
            document.getElementById('aptStrategy').innerHTML =
                aptBadge('RUN', char.apt_runner) + aptBadge('LEAD', char.apt_leader) +
                aptBadge('BTWN', char.apt_betweener) + aptBadge('CHASE', char.apt_chaser);
        }

        function updateImage(charId) {
            const char = CHAR_DATA[charId];
            renderAptitudes(char);
            if(charId) {
                const prefix = charId.substring(0, 4);
                const localImageUrl = `assets/images/characters/chara_stand_${prefix}_${charId}.png`;
                const imgElement = document.getElementById('uiImg');
                const placeholder = document.getElementById('placeholderText');
                imgElement.src = localImageUrl;
                imgElement.onerror = function() { this.classList.add('hidden'); placeholder.classList.remove('hidden'); placeholder.innerText = "IMAGE NOT FOUND"; };
                imgElement.onload = function() { this.classList.remove('hidden'); placeholder.classList.add('hidden'); };
            }
        }

        document.getElementById('charSelect').addEventListener('change', function() { updateImage(this.value); });

        // Mirrors includes/rating.php exactly, for live preview only.
        // The server recalculates on submit — this never controls what gets saved.
        function calculateRatingScore(spd, sta, pow, gut, wit) {
            const weighted = (spd * 1.0) + (sta * 0.8) + (pow * 0.6) + (gut * 0.4) + (wit * 0.4);
            return Math.round(weighted * 16);
        }

        function calculateFinalRank(score) {
            const tiers = [
                [63400, 'US'], [55200, 'UA'], [47600, 'UB'], [40700, 'UC'], [34400, 'UD'],
                [28800, 'UE'], [23900, 'UF'], [19600, 'UG'], [19200, 'SS+'], [17500, 'SS'],
                [15900, 'S+'], [14500, 'S'], [12100, 'A+'], [10000, 'A'], [8200, 'B+'],
                [6500, 'B'], [4900, 'C+'], [3500, 'C'], [2900, 'D+'], [2300, 'D'],
                [1800, 'E+'], [1300, 'E'], [900, 'F+'], [600, 'F'], [300, 'G+']
            ];
            for (const [threshold, rank] of tiers) { if (score >= threshold) return rank; }
            return 'G';
        }

        const RANK_COLORS = {
            'US':'bg-[#FF6699] text-white shadow-md','UA':'bg-[#FF6699] text-white shadow-md','UB':'bg-[#FF6699] text-white shadow-md',
            'UC':'bg-[#FF6699] text-white shadow-md','UD':'bg-[#FF6699] text-white shadow-md','UE':'bg-[#FF6699] text-white shadow-md',
            'UF':'bg-[#FF6699] text-white shadow-md','UG':'bg-[#FF6699] text-white shadow-md',
            'SS+':'bg-yellow-400 text-yellow-900 shadow-md','SS':'bg-yellow-400 text-yellow-900 shadow-md',
            'S+':'bg-yellow-300 text-yellow-800 shadow-md','S':'bg-yellow-300 text-yellow-800 shadow-md',
            'A+':'bg-orange-400 text-white shadow-md','A':'bg-orange-400 text-white shadow-md',
            'B+':'bg-pink-400 text-white shadow-md','B':'bg-pink-400 text-white shadow-md',
            'C+':'bg-green-500 text-white shadow-md','C':'bg-green-500 text-white shadow-md',
            'D+':'bg-blue-400 text-white shadow-md','D':'bg-blue-400 text-white shadow-md',
            'E+':'bg-purple-400 text-white shadow-md','E':'bg-purple-400 text-white shadow-md',
            'F+':'bg-purple-300 text-white shadow-md','F':'bg-purple-300 text-white shadow-md',
            'G+':'bg-gray-400 text-white shadow-md','G':'bg-gray-300 text-gray-700 shadow-md'
        };

        function recalculate() {
            const ids = ['stat_speed','stat_stamina','stat_power','stat_guts','stat_wit'];
            const vals = ids.map(id => parseInt(document.getElementById(id).value) || 0);
            const anyFilled = vals.some(v => v > 0);
            const preview = document.getElementById('ratingPreview');
            const display = document.getElementById('rankDisplay');

            if (!anyFilled) {
                preview.innerText = '— auto —';
                preview.className = 'clean-input font-black text-gray-400 bg-gray-100 flex items-center justify-center select-none';
                display.innerText = '?';
                display.className = 'bg-gray-200 text-gray-400 font-black h-[46px] rounded-xl flex items-center justify-center text-xl transition-colors shadow-inner';
                return;
            }

            const score = calculateRatingScore(...vals);
            const rank = calculateFinalRank(score);
            const colorClass = RANK_COLORS[rank] || RANK_COLORS['G'];

            preview.innerText = score.toLocaleString();
            preview.className = 'clean-input font-black text-gray-800 bg-white flex items-center justify-center select-none';
            display.innerText = rank;
            display.className = `font-black h-[46px] rounded-xl flex items-center justify-center text-xl transition-colors ${colorClass}`;
        }

        ['stat_speed','stat_stamina','stat_power','stat_guts','stat_wit'].forEach(id => {
            document.getElementById(id).addEventListener('input', recalculate);
        });
    </script>
</body>
</html>