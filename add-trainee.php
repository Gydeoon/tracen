<?php
session_start();
require_once 'config/database.php';

$char_stmt = $pdo->query("SELECT * FROM characters ORDER BY name ASC");
$characters = $char_stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "INSERT INTO trainees (character_id, stat_speed, stat_stamina, stat_power, stat_guts, stat_wit, final_rank, rating_score, notes) 
              VALUES (:char_id, :spd, :sta, :pow, :gut, :wit, :rank, :score, :notes)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':char_id' => $_POST['character_id'], 
        ':rank' => $_POST['final_rank'], 
        ':score' => $_POST['rating_score'] ?: null, 
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
    </style>
</head>
<body class="antialiased min-h-screen py-10 flex items-center justify-center">
    
    <div class="w-full max-w-5xl bg-white p-8 md:p-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
        
        <div class="flex justify-between items-center mb-10 pb-6 border-b border-gray-100">
            <div><h2 class="text-3xl font-black text-gray-900 uppercase italic tracking-tight">Register <span class="text-[#FF6699]">Trainee</span></h2></div>
            <a href="index.php" class="text-sm font-bold text-gray-400 hover:text-gray-800 transition bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-full shadow-sm">← Back to Database</a>
        </div>

        <form action="add-trainee.php" method="POST" class="flex flex-col md:flex-row gap-10">
            <div class="w-full md:w-1/3 flex flex-col">
                <div class="w-full aspect-[4/5] bg-gray-100 rounded-2xl flex items-end justify-center overflow-hidden relative shadow-inner border border-gray-200">
                    <img id="uiImg" src="" class="w-[90%] h-auto object-contain object-bottom hidden absolute z-10 transition-transform duration-500">
                    <span id="placeholderText" class="text-gray-400 text-sm font-bold z-20 mb-10 tracking-widest">CHARACTER PREVIEW</span>
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
                        <input type="number" name="stat_speed" placeholder="SPD" class="clean-input text-center font-bold !px-1 text-blue-600 focus:!border-blue-500" required>
                        <input type="number" name="stat_stamina" placeholder="STA" class="clean-input text-center font-bold !px-1 text-pink-600 focus:!border-pink-500" required>
                        <input type="number" name="stat_power" placeholder="POW" class="clean-input text-center font-bold !px-1 text-orange-600 focus:!border-orange-500" required>
                        <input type="number" name="stat_guts" placeholder="GUT" class="clean-input text-center font-bold !px-1 text-red-600 focus:!border-red-500" required>
                        <input type="number" name="stat_wit" placeholder="WIT" class="clean-input text-center font-bold !px-1 text-green-600 focus:!border-green-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide">Rating Score</label>
                        <input type="number" name="rating_score" id="ratingInput" placeholder="e.g. 19600" class="clean-input font-black text-gray-800" required>
                    </div>
                    
                    <div class="md:col-span-1">
                        <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wide text-center">Rank</label>
                        <input type="hidden" name="final_rank" id="finalRankInput" required>
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
        document.getElementById('charSelect').addEventListener('change', function() {
            const charId = this.value;
            if(charId) {
                const prefix = charId.substring(0, 4);
                const localImageUrl = `assets/images/characters/chara_stand_${prefix}_${charId}.png`;
                const imgElement = document.getElementById('uiImg');
                const placeholder = document.getElementById('placeholderText');
                imgElement.src = localImageUrl;
                imgElement.onerror = function() { this.classList.add('hidden'); placeholder.classList.remove('hidden'); placeholder.innerText = "IMAGE NOT FOUND"; };
                imgElement.onload = function() { this.classList.remove('hidden'); placeholder.classList.add('hidden'); };
            }
        });

        document.getElementById('ratingInput').addEventListener('input', function() {
            const score = parseInt(this.value) || 0;
            let rank = 'G'; let colorClass = 'bg-gray-200 text-gray-500';

            if (score >= 63400) { rank = 'US'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 55200) { rank = 'UA'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 47600) { rank = 'UB'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 40700) { rank = 'UC'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 34400) { rank = 'UD'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 28800) { rank = 'UE'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 23900) { rank = 'UF'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 19600) { rank = 'UG'; colorClass = 'bg-[#FF6699] text-white shadow-md'; }
            else if (score >= 19200) { rank = 'SS+'; colorClass = 'bg-yellow-400 text-yellow-900 shadow-md'; }
            else if (score >= 17500) { rank = 'SS'; colorClass = 'bg-yellow-400 text-yellow-900 shadow-md'; }
            else if (score >= 15900) { rank = 'S+'; colorClass = 'bg-yellow-300 text-yellow-800 shadow-md'; }
            else if (score >= 14500) { rank = 'S'; colorClass = 'bg-yellow-300 text-yellow-800 shadow-md'; }
            else if (score >= 12100) { rank = 'A+'; colorClass = 'bg-orange-400 text-white shadow-md'; }
            else if (score >= 10000) { rank = 'A'; colorClass = 'bg-orange-400 text-white shadow-md'; }
            else if (score >= 8200)  { rank = 'B+'; colorClass = 'bg-pink-400 text-white shadow-md'; }
            else if (score >= 6500)  { rank = 'B'; colorClass = 'bg-pink-400 text-white shadow-md'; }
            else if (score >= 4900)  { rank = 'C+'; colorClass = 'bg-green-500 text-white shadow-md'; }
            else if (score >= 3500)  { rank = 'C'; colorClass = 'bg-green-500 text-white shadow-md'; }
            else if (score >= 2900)  { rank = 'D+'; colorClass = 'bg-blue-400 text-white shadow-md'; }
            else if (score >= 2300)  { rank = 'D'; colorClass = 'bg-blue-400 text-white shadow-md'; }
            else if (score >= 1800)  { rank = 'E+'; colorClass = 'bg-purple-400 text-white shadow-md'; }
            else if (score >= 1300)  { rank = 'E'; colorClass = 'bg-purple-400 text-white shadow-md'; }
            else if (score >= 900)   { rank = 'F+'; colorClass = 'bg-purple-300 text-white shadow-md'; }
            else if (score >= 600)   { rank = 'F'; colorClass = 'bg-purple-300 text-white shadow-md'; }
            else if (score >= 300)   { rank = 'G+'; colorClass = 'bg-gray-400 text-white shadow-md'; }
            else { rank = 'G'; colorClass = 'bg-gray-300 text-gray-700 shadow-md'; }

            const display = document.getElementById('rankDisplay');
            const hiddenInput = document.getElementById('finalRankInput');
            
            if (this.value === '') {
                display.innerText = '?';
                display.className = 'bg-gray-200 text-gray-400 font-black h-[46px] rounded-xl flex items-center justify-center text-xl transition-colors shadow-inner';
                hiddenInput.value = '';
            } else {
                display.innerText = rank;
                display.className = `font-black h-[46px] rounded-xl flex items-center justify-center text-xl transition-colors ${colorClass}`;
                hiddenInput.value = rank; 
            }
        });
    </script>
</body>
</html>