<?php
/**
 * Rating Calculator
 * ------------------
 * Auto-derives a trainee's Rating Score and Final Rank directly from their
 * final stats (inspired by the UmaTools Rating Calculator). This is
 * calculated server-side so it can never be spoofed via the form, and the
 * exact same numbers are mirrored in JS on the form pages just for live
 * preview while typing.
 *
 * Weighting follows the well-known in-game stat priority
 * (Speed > Stamina > Power > Guts/Wit), scaled up so a maxed-out
 * 1200/1200/1200/1200/1200 build lands around the UA/UB tier.
 *
 * NOTE: this is a stats-only estimate — it does not account for skills,
 * since this tracker does not store a trainee's skill list.
 */

function calculateRatingScore($spd, $sta, $pow, $gut, $wit): int
{
    $spd = max(0, (int) $spd);
    $sta = max(0, (int) $sta);
    $pow = max(0, (int) $pow);
    $gut = max(0, (int) $gut);
    $wit = max(0, (int) $wit);

    $weighted = ($spd * 1.0) + ($sta * 0.8) + ($pow * 0.6) + ($gut * 0.4) + ($wit * 0.4);

    return (int) round($weighted * 16);
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