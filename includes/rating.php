<?php
/**
 * Rating Calculator
 * ------------------
 * Auto-derives a trainee's Rating Score and Final Rank directly from their
 * final stats. Calculated server-side so it can never be spoofed via the
 * form; the exact same numbers are mirrored in JS on the form pages purely
 * for live preview while typing.
 *
 * Two things the real game's rating is known for, that a flat weighted sum
 * does NOT reproduce, so this formula bakes both in:
 *
 *  1. Stat priority: Speed > Stamina > Power > Guts ≈ Wit.
 *  2. Concentration matters: spreading points evenly across all 5 stats
 *     scores noticeably worse than putting the same total into fewer,
 *     higher stats (e.g. a 1200/1200/200/200/200 spread scores well above
 *     an even 600/600/600/600/600 spread with the same stat total). This
 *     needs each stat's own contribution to curve upward as it gets
 *     higher, not just a per-stat weight.
 *
 * Calibrated against publicly reported in-game data points, e.g. players
 * reporting an A rank (10,000-12,099) around 1100 SPD / 700 STA / 700 POW /
 * 300 GUT / 300 WIT, and around 1200 SPD / 1200 WIT / ~300 elsewhere.
 *
 * NOTE: this is a stats-only estimate. It will not match a tool like the
 * UmaTools Rating Calculator exactly, because that also factors in Skill
 * Score and Unique Bonus - this tracker doesn't record a trainee's skill
 * list, so those two components simply aren't part of the equation here.
 */

function calculateRatingScore($spd, $sta, $pow, $gut, $wit): int
{
    $weights = ['spd' => 1.0, 'sta' => 0.8, 'pow' => 0.6, 'gut' => 0.4, 'wit' => 0.4];
    $stats = ['spd' => $spd, 'sta' => $sta, 'pow' => $pow, 'gut' => $gut, 'wit' => $wit];

    $weighted = 0.0;
    foreach ($stats as $key => $value) {
        $value = max(0, (int) $value);
        // Each stat's own contribution accelerates as it climbs, so
        // concentrating points into fewer stats scores higher than
        // spreading the same total thin across all five.
        $contribution = $value * (1 + $value / 2400);
        $weighted += $contribution * $weights[$key];
    }

    return (int) round($weighted * 3.5);
}

function calculateFinalRank(int $score): string
{
    $tiers = [
        63400 => 'US',  55200 => 'UA',  47600 => 'UB',  40700 => 'UC',  34400 => 'UD',
        28800 => 'UE',  23900 => 'UF',  19600 => 'UG',
        19200 => 'SS+', 17500 => 'SS',
        15900 => 'S+',  14500 => 'S',
        12100 => 'A+',  10000 => 'A',
        8200  => 'B+',  6500  => 'B',
        4900  => 'C+',  3500  => 'C',
        2900  => 'D+',  2300  => 'D',
        1800  => 'E+',  1300  => 'E',
        900   => 'F+',  600   => 'F',
        300   => 'G+',
    ];

    foreach ($tiers as $threshold => $rank) {
        if ($score >= $threshold) {
            return $rank;
        }
    }

    return 'G';
}