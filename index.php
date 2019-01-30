<?php

function tireUnAdversaire($equipe,&$tableau)
{
    $idx = array_rand($tableau,1);
    $adversaire = $tableau[$idx];

    if ($adversaire['pays'] == $equipe['pays'] || ($equipe['poule'] != 'n/a' && ($adversaire['poule'] == $equipe['poule']))) {
        return false;
    }
    else {
        unset($tableau[$idx]);
        return $adversaire;
    }
}

function tirage($max,$premiersDePoule,$secondsDePoule)
{

    $nbEquipes = count($premiersDePoule);
    if ($nbEquipes != count($secondsDePoule)) {
        throw new \Exception('Tableaux mal formés.');
    }

    $res = [];
    $cpt = 0;
    $tirage = [];

    for ($i = 0 ; $i < $nbEquipes + 1 ; $i++) {
        for ($j = 0 ; $j < $nbEquipes + 1 ; $j++) {
            if ($i == 0 && $j > 0) {
                $res[$i][$j] = $secondsDePoule[$j - 1]['nom'];
            }
            elseif ($i > 0 && $j == 0) {
                $res[$i][$j] = $premiersDePoule[$i - 1]['nom'];
            }
            elseif($i > 0 && $j > 0) {
                $res[$i][$j] = 0;
            }
            else {
                $res[$i][$j] = '';
            }
        }
    }


    while($cpt < $max) {
        $premiers = $premiersDePoule;
        $seconds = $secondsDePoule;

        for ($i = 0 ; $i < $nbEquipes ; $i++) {
            $deuz = $seconds[$i];
            $preums = tireUnAdversaire($deuz,$premiers);
            if ($preums == false) {
                continue 2;
            }
            unset($seconds[$i]);
            $tirage[$i] = ['p' => $preums,'s' => $deuz];
        }

        for ($i = 0 ; $i < $nbEquipes ; $i++) {
            $res[$tirage[$i]['p']['pos'] + 1][$tirage[$i]['s']['pos'] + 1]++;
        }

        $cpt++;
    }

    for ($i = 1 ; $i < $nbEquipes + 1 ; $i++) {
        for ($j = 1 ; $j < $nbEquipes + 1 ; $j++) {
            $res[$i][$j] = $res[$i][$j] / $cpt * 100;
        }
    }

    return $res;

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Probas tirage sportifs</title>
</head>

<body>
<?php
$nbC1 = 500000;
$startC1 = microtime(true);
$premiersC1 = [
    3 => ['pos' => 3, 'poule' => 'A', 'pays' => 'Angleterre', 'nom' => 'ManU'],
    1 => ['pos' => 1, 'poule' => 'B', 'pays' => 'France', 'nom' => 'PSG'],
    6 => ['pos' => 6, 'poule' => 'C', 'pays' => 'Italie', 'nom' => 'Roma'],
    0 => ['pos' => 0, 'poule' => 'D', 'pays' => 'Espagne', 'nom' => 'Barca'],
    5 => ['pos' => 5, 'poule' => 'E', 'pays' => 'Angleterre', 'nom' => 'Liverpool'],
    2 => ['pos' => 2, 'poule' => 'F', 'pays' => 'Angleterre', 'nom' => 'ManCity'],
    7 => ['pos' => 7, 'poule' => 'G', 'pays' => 'Turquie', 'nom' => 'Besiktas'],
    4 => ['pos' => 4, 'poule' => 'H', 'pays' => 'Angleterre', 'nom' => 'Tottenham'],
];
$secondsC1 = [
    7 => ['pos' => 7, 'poule' => 'A', 'pays' => 'Suisse', 'nom' => 'Bâle'],
    1 => ['pos' => 1, 'poule' => 'B', 'pays' => 'Allemagne', 'nom' => 'Bayern'],
    4 => ['pos' => 4, 'poule' => 'C', 'pays' => 'Angleterre', 'nom' => 'Chelsea'],
    2 => ['pos' => 2, 'poule' => 'D', 'pays' => 'Italie', 'nom' => 'Juve'],
    3 => ['pos' => 3, 'poule' => 'E', 'pays' => 'Espagne', 'nom' => 'Séville'],
    6 => ['pos' => 6, 'poule' => 'F', 'pays' => 'Ukraine', 'nom' => 'Chakhtar'],
    5 => ['pos' => 5, 'poule' => 'G', 'pays' => 'Portugal', 'nom' => 'Porto'],
    0 => ['pos' => 0, 'poule' => 'H', 'pays' => 'Espagne', 'nom' => 'Real'],
];
try {
    $tirageC1 = tirage($nbC1, $premiersC1, $secondsC1);
} catch (\Exception $e) {
    echo $e->getMessage();
}
$endC1 = round(microtime(true) - $startC1);
?>
<div>
    <?php
    echo 'C1 : '.$nbC1.' tirages validés en '.floor(($endC1/60)).' min. et '.($endC1%60).' sec.';
    ?>
</div>
<table border="1" cellpadding="5">
    <?php for ($i = 0 ; $i < 9 ; $i++) { ?>
        <tr>
            <?php for ($j = 0 ; $j < 9 ; $j++) { ?>
                <td>
                    <?= $i > 0 && $j > 0 ? round($tirageC1[$i][$j],1) : $tirageC1[$i][$j] ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<?php
$nbC3 = 500000;
$startC3 = microtime(true);
$premiersC3 = [
    ['pos' => 0, 'poule' => 'A', 'pays' => 'Espagne', 'nom' => 'Villareal'],
    ['pos' => 1, 'poule' => 'B', 'pays' => 'Ukraine', 'nom' => 'Dynamo Kiev'],
    ['pos' => 2, 'poule' => 'C', 'pays' => 'Portugal', 'nom' => 'Braga'],
    ['pos' => 3, 'poule' => 'D', 'pays' => 'Italie', 'nom' => 'Milan'],
    ['pos' => 4, 'poule' => 'E', 'pays' => 'Italie', 'nom' => 'Atalanta'],
    ['pos' => 5, 'poule' => 'F', 'pays' => 'Russie', 'nom' => 'Lokomotiv Moscou'],
    ['pos' => 6, 'poule' => 'G', 'pays' => 'Tchéquie', 'nom' => 'Viktoria Plzen'],
    ['pos' => 7, 'poule' => 'H', 'pays' => 'Angleterre', 'nom' => 'Arsenal'],
    ['pos' => 8, 'poule' => 'I', 'pays' => 'Autriche', 'nom' => 'Red Bull Saltzbourg'],
    ['pos' => 9, 'poule' => 'J', 'pays' => 'Espagne', 'nom' => 'Athletic Bilbao'],
    ['pos' => 10, 'poule' => 'K', 'pays' => 'Italie', 'nom' => 'Lazio'],
    ['pos' => 11, 'poule' => 'L', 'pays' => 'Russie', 'nom' => 'Zenith Saint-Petersbourg'],
    ['pos' => 12, 'poule' => 'n/a', 'pays' => 'Russie', 'nom' => 'CSK Moscou'],
    ['pos' => 13, 'poule' => 'n/a', 'pays' => 'Espagne', 'nom' => 'Atlético Madrid'],
    ['pos' => 14, 'poule' => 'n/a', 'pays' => 'Allemagne', 'nom' => 'Red Bull Leipzig'],
    ['pos' => 15, 'poule' => 'n/a', 'pays' => 'Portugal', 'nom' => 'Sporting Portugal'],
];
$secondsC3 = [
    ['pos' => 0, 'poule' => 'A', 'pays' => 'Kazakhstan', 'nom' => 'Astana'],
    ['pos' => 1, 'poule' => 'B', 'pays' => 'Serbie', 'nom' => 'Partizan Belgrade'],
    ['pos' => 2, 'poule' => 'C', 'pays' => 'Bulgarie', 'nom' => 'Ludogorets'],
    ['pos' => 3, 'poule' => 'D', 'pays' => 'Grèce', 'nom' => 'AEK Athènes'],
    ['pos' => 4, 'poule' => 'E', 'pays' => 'France', 'nom' => 'Lyon'],
    ['pos' => 5, 'poule' => 'F', 'pays' => 'Danemark', 'nom' => 'Copenhague'],
    ['pos' => 6, 'poule' => 'G', 'pays' => 'Roumanie', 'nom' => 'Steaua Bucharest'],
    ['pos' => 7, 'poule' => 'H', 'pays' => 'Serbie', 'nom' => 'Red Star Belgrade'],
    ['pos' => 8, 'poule' => 'I', 'pays' => 'France', 'nom' => 'Marseille'],
    ['pos' => 9, 'poule' => 'J', 'pays' => 'Suède', 'nom' => 'Östersund'],
    ['pos' => 10, 'poule' => 'K', 'pays' => 'France', 'nom' => 'Nice'],
    ['pos' => 11, 'poule' => 'L', 'pays' => 'Espagne', 'nom' => 'Real Sociedad'],
    ['pos' => 12, 'poule' => 'n/a', 'pays' => 'Itaalie', 'nom' => 'Naples'],
    ['pos' => 13, 'poule' => 'n/a', 'pays' => 'Russie', 'nom' => 'Spartak Moscou'],
    ['pos' => 14, 'poule' => 'n/a', 'pays' => 'Écosse', 'nom' => 'Celtic'],
    ['pos' => 15, 'poule' => 'n/a', 'pays' => 'Allemagne', 'nom' => 'Dortmund'],
];
try {
    $tirageC3 = tirage($nbC3, $premiersC3, $secondsC3);
} catch (\Exception $e) {
    echo $e->getMessage();
}
$endC3 = round(microtime(true) - $startC3);
?>
<div>
    <?php
    echo 'C3 : '.$nbC3.' tirages validés en '.floor(($endC3/60)).' min. et '.($endC3%60).' sec.';
    ?>
</div>
<table border="1" cellpadding="5">
    <?php for ($i = 0 ; $i < 17 ; $i++) { ?>
        <tr>
            <?php for ($j = 0 ; $j < 17 ; $j++) { ?>
                <td>
                    <?= $i > 0 && $j > 0 ? round($tirageC3[$i][$j],1) : $tirageC3[$i][$j] ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
</body>

</html>
