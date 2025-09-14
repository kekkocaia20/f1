<?php
$anno_selezionato = isset($_GET['year']) ? htmlspecialchars($_GET['year']) : date("Y");
$round_selezionato = isset($_GET['round']) ? htmlspecialchars($_GET['round']) : null;

// Mappa nazionalità / paesi -> codice bandiera ISO
$codici_bandiere = [
    'American'=>'us','Argentine'=>'ar','Australian'=>'au','Austrian'=>'at',
    'Belgian'=>'be','Brazilian'=>'br','British'=>'gb','Canadian'=>'ca',
    'Chilean'=>'cl','Colombian'=>'co','Danish'=>'dk','Dutch'=>'nl',
    'Finnish'=>'fi','French'=>'fr','German'=>'de','Hungarian'=>'hu',
    'Indian'=>'in','Indonesian'=>'id','Irish'=>'ie','Italian'=>'it',
    'Japanese'=>'jp','Malaysian'=>'my','Mexican'=>'mx','Monegasque'=>'mc',
    'New Zealander'=>'nz','Polish'=>'pl','Portuguese'=>'pt','Russian'=>'ru',
    'South African'=>'za','Spanish'=>'es','Swedish'=>'se','Swiss'=>'ch',
    'Thai'=>'th','Venezuelan'=>'ve','Uruguayan'=>'uy','Liechtensteiner'=>'li',
    'Chinese'=>'cn',
    // Paesi circuiti
    'Afghanistan' => 'af', 'Albania' => 'al', 'Algeria' => 'dz', 'Andorra' => 'ad',
    'Angola' => 'ao', 'Antigua and Barbuda' => 'ag', 'Argentina' => 'ar', 'Armenia' => 'am',
    'Australia' => 'au', 'Austria' => 'at', 'Azerbaijan' => 'az', 'Bahamas' => 'bs',
    'Bahrain' => 'bh', 'Bangladesh' => 'bd', 'Barbados' => 'bb', 'Belarus' => 'by',
    'Belgium' => 'be', 'Belize' => 'bz', 'Benin' => 'bj', 'Bhutan' => 'bt',
    'Bolivia' => 'bo', 'Bosnia and Herzegovina' => 'ba', 'Botswana' => 'bw', 'Brazil' => 'br',
    'Brunei Darussalam' => 'bn', 'Bulgaria' => 'bg', 'Burkina Faso' => 'bf', 'Burundi' => 'bi',
    'Cabo Verde' => 'cv', 'Cambodia' => 'kh', 'Cameroon' => 'cm', 'Canada' => 'ca',
    'Cayman Islands' => 'ky', 'Central African Republic' => 'cf', 'Chad' => 'td', 'Chile' => 'cl',
    'China' => 'cn', 'Colombia' => 'co', 'Comoros' => 'km', 'Congo' => 'cg',
    'Congo (Democratic Republic of the)' => 'cd', 'Cook Islands' => 'ck', 'Costa Rica' => 'cr', 'Croatia' => 'hr',
    'Cuba' => 'cu', 'Cyprus' => 'cy', 'Czech Republic' => 'cz', 'Denmark' => 'dk',
    'Djibouti' => 'dj', 'Dominica' => 'dm', 'Dominican Republic' => 'do', 'Ecuador' => 'ec',
    'Egypt' => 'eg', 'El Salvador' => 'sv', 'Equatorial Guinea' => 'gq', 'Eritrea' => 'er',
    'Estonia' => 'ee', 'Eswatini' => 'sz', 'Ethiopia' => 'et', 'Fiji' => 'fj',
    'Finland' => 'fi', 'France' => 'fr', 'Gabon' => 'ga', 'Gambia' => 'gm',
    'Georgia' => 'ge', 'Germany' => 'de', 'Ghana' => 'gh', 'Greece' => 'gr',
    'Grenada' => 'gd', 'Guatemala' => 'gt', 'Guinea' => 'gn', 'Guinea-Bissau' => 'gw',
    'Guyana' => 'gy', 'Haiti' => 'ht', 'Honduras' => 'hn', 'Hungary' => 'hu',
    'Iceland' => 'is', 'India' => 'in', 'Indonesia' => 'id', 'Iran' => 'ir',
    'Iraq' => 'iq', 'Ireland' => 'ie', 'Israel' => 'il', 'Italy' => 'it',
    'Jamaica' => 'jm', 'Japan' => 'jp', 'Jordan' => 'jo', 'Kazakhstan' => 'kz',
    'Kenya' => 'ke', 'Kiribati' => 'ki', 'Latvia' => 'lv',
    'Lebanon' => 'lb', 'Lesotho' => 'ls', 'Liberia' => 'lr', 'Libya' => 'ly',
    'Liechtenstein' => 'li', 'Lithuania' => 'lt', 'Luxembourg' => 'lu', 'Madagascar' => 'mg',
    'Malawi' => 'mw', 'Malaysia' => 'my', 'Maldives' => 'mv', 'Mali' => 'ml',
    'Malta' => 'mt', 'Marshall Islands' => 'mh', 'Mauritania' => 'mr', 'Mauritius' => 'mu',
    'Mexico' => 'mx', 'Micronesia (Federated States of)' => 'fm', 'Moldova (Republic of)' => 'md', 'Monaco' => 'mc',
    'Mongolia' => 'mn', 'Montenegro' => 'me', 'Morocco' => 'ma', 'Mozambique' => 'mz',
    'Myanmar' => 'mm', 'Namibia' => 'na', 'Nauru' => 'nr', 'Nepal' => 'np',
    'Netherlands' => 'nl', 'New Zealand' => 'nz', 'Nicaragua' => 'ni', 'Niger' => 'ne',
    'Nigeria' => 'ng', 'North Macedonia' => 'mk', 'Northern Mariana Islands' => 'mp', 'Norway' => 'no',
    'Oman' => 'om', 'Pakistan' => 'pk', 'Palau' => 'pw', 'Panama' => 'pa',
    'Papua New Guinea' => 'pg', 'Paraguay' => 'py', 'Peru' => 'pe', 'Philippines' => 'ph',
    'Poland' => 'pl', 'Portugal' => 'pt', 'Puerto Rico' => 'pr', 'Qatar' => 'qa',
    'Romania' => 'ro', 'Russian Federation' => 'ru', 'Rwanda' => 'rw', 'Réunion' => 're',
    'Saint Barthélemy' => 'bl', 'Saint Helena, Ascension and Tristan da Cunha' => 'sh', 'Saint Kitts and Nevis' => 'kn', 'Saint Lucia' => 'lc',
    'Saint Martin (French part)' => 'mf', 'Saint Pierre and Miquelon' => 'pm', 'Saint Vincent and the Grenadines' => 'vc', 'Samoa' => 'ws',
    'San Marino' => 'sm', 'Sao Tome and Principe' => 'st', 'Saudi Arabia' => 'sa', 'Senegal' => 'sn',
    'Serbia' => 'rs', 'Seychelles' => 'sc', 'Sierra Leone' => 'sl', 'Singapore' => 'sg',
    'Sint Maarten (Dutch part)' => 'sx', 'Slovakia' => 'sk', 'Slovenia' => 'si', 'Solomon Islands' => 'sb',
    'Somalia' => 'so', 'South Africa' => 'za', 'South Georgia and the South Sandwich Islands' => 'gs', 'South Sudan' => 'ss', 'Spain' => 'es',
    'Sri Lanka' => 'lk', 'Sudan' => 'sd', 'Suriname' => 'sr', 'Svalbard and Jan Mayen' => 'sj',
    'Sweden' => 'se', 'Switzerland' => 'ch', 'Syrian Arab Republic' => 'sy', 'Taiwan' => 'tw',
    'Tajikistan' => 'tj', 'Tanzania (United Republic of)' => 'tz', 'Thailand' => 'th', 'Timor-Leste' => 'tl',
    'Togo' => 'tg', 'Tokelau' => 'tk', 'Tonga' => 'to', 'Trinidad and Tobago' => 'tt',
    'Tunisia' => 'tn', 'Turkey' => 'tr', 'Turkmenistan' => 'tm', 'Tuvalu' => 'tv',
    'Uganda' => 'ug', 'Ukraine' => 'ua', 'United Arab Emirates' => 'ae', 'United Kingdom of Great Britain and Northern Ireland' => 'gb',
    'United Republic of Tanzania' => 'tz', 'United States of America' => 'us', 'Uruguay' => 'uy', 'Uzbekistan' => 'uz',
    'Vanuatu' => 'vu', 'Venezuela (Bolivarian Republic of)' => 've', 'Viet Nam' => 'vn', 'Western Sahara' => 'eh',
    'Yemen' => 'ye', 'Zambia' => 'zm', 'Zimbabwe' => 'zw',
     // Tag unici per UK e USA
     'UK' => 'gb',
     'USA' => 'us',
     'UAE' => 'ae',
     'Russia' => 'ru',
     'Korea' => 'kr'
];

// Funzione per ottenere JSON da Jolpi.ca
function getApiData($url) {
    $response = @file_get_contents($url);
    return $response ? json_decode($response, true) : null;
}

if ($round_selezionato) {
    // Mostra classifica gara selezionata
    $url = "http://api.jolpi.ca/ergast/f1/$anno_selezionato/$round_selezionato/results.json";
    $data = getApiData($url);
    $results = $data['MRData']['RaceTable']['Races'][0]['Results'] ?? [];
    $raceName = $data['MRData']['RaceTable']['Races'][0]['raceName'] ?? '';
} else {
    // Mostra calendario
    $url = "http://api.jolpi.ca/ergast/f1/$anno_selezionato.json";
    $data = getApiData($url);
    $races = $data['MRData']['RaceTable']['Races'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="calendar.css">
    <title>
        <?php echo $round_selezionato ? "Classifica $raceName - $anno_selezionato" : "Calendario F1 $anno_selezionato"; ?>
    </title>
</head>
<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-md d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="calendar.php">
      <img src="f1_logo.png" alt="Logo" class="navbar-logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Classifiche</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar.php">Calendario</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="containerr">
<?php if ($round_selezionato): ?>
    <h1>Classifica <?= $raceName ?> - <?= $anno_selezionato ?></h1>
    <?php if (!empty($results)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Posto</th>
                        <th>Nazione</th>
                        <th>Pilota</th>
                        <th>Team</th>
                        <th>Tempo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $res): ?>
                        <tr>
                            <td><?= $res['position'] ?></td>
                            <td>
                                <?php
                                $nazionalita = $res['Driver']['nationality'] ?? 'N/A';
                                $codice_bandiera = $codici_bandiere[$nazionalita] ?? null;
                                echo $codice_bandiera ? '<span class="flag-icon flag-icon-'.$codice_bandiera.'"></span>' : $nazionalita;
                                ?>
                            </td>
                            <td><?= $res['Driver']['givenName'] . " " . $res['Driver']['familyName'] ?></td>
                            <td><?= $res['Constructor']['name'] ?></td>
                            <td><?= $res['Time']['time'] ?? '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Classifica non disponibile per questa gara.</p>
    <?php endif; ?>
    <div class="text-center mt-3">
        <a href="calendar.php?year=<?= $anno_selezionato ?>" class="btn btn-secondary">Torna al calendario</a>
    </div>
<?php else: ?>
    <h1>Calendario F1 - <?= $anno_selezionato ?></h1>
    <!-- Selezione anno -->
    <form action="" method="get">
        <label for="anno">Seleziona l'anno:</label>
        <select name="year" id="anno">
            <?php
            $anno_corrente = date("Y");
            for ($anno = $anno_corrente; $anno >= 1950; $anno--) {
                $selected = ($anno_selezionato == $anno) ? 'selected' : '';
                echo "<option value=\"$anno\" $selected>$anno</option>";
            }
            ?>
        </select>
        <button type="submit">Visualizza</button>
    </form>

    <?php if (!empty($races)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Round</th>
                        <th>Gran Premio</th>
                        <th>Circuito</th>
                        <th>Località</th>
                        <th>Paese</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $oggi = date('Y-m-d');
                    foreach ($races as $race):
                        $round = $race['round'];
                        $gp = $race['raceName'];
                        $circuito = $race['Circuit']['circuitName'];
                        $localita = $race['Circuit']['Location']['locality'];
                        $paese = $race['Circuit']['Location']['country'];
                        $data_race = $race['date'];
                        $ora = $race['time'] ?? '';
                        $data_ora = $ora ? "$data_race $ora" : $data_race;

                        // Usa la stessa variabile $codice_bandiera per il paese
                        $codice_bandiera = $codici_bandiere[$paese] ?? null;
                        ?>
                        <tr>
                            <td><?= $round ?></td>
                            <td>
                                <?php if ($data_race <= $oggi): ?>
                                    <a href="?year=<?= $anno_selezionato ?>&round=<?= $round ?>"><?= $gp ?></a>
                                <?php else: ?>
                                    <?= $gp ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $circuito ?></td>
                            <td><?= $localita ?></td>
                            <td>
                                <?= $codice_bandiera ? '<span class="flag-icon flag-icon-'.$codice_bandiera.'"></span> ' : '' ?>
                            </td>
                            <td><?= $data_ora ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Calendario non disponibile per l'anno <?= $anno_selezionato ?>.</p>
    <?php endif; ?>
<?php endif; ?>
</div>

      <!-- Footer -->
      <footer class="footer">
    <div class="container text-center">
      <p class="caia-text">&copy; 2025 Classifica F1 by Francesco Caianiello.</p>
      <div class="social-icons d-flex justify-content-center gap-4 mt-3">
  <a href="https://github.com/kekkocaia20" target="_blank" class="text-white d-flex align-items-center gap-2">
    <i class="fab fa-github fa-lg"></i>
    <span class="caia-text">GitHub</span>
  </a>
  <a href="https://www.linkedin.com/in/francesco-caianiello-065525197/" target="_blank" class="text-white d-flex align-items-center gap-2">
    <i class="fab fa-linkedin fa-lg"></i>
    <span class="caia-text">LinkedIn</span>
  </a>
</div>
  </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




