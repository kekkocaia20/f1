<?php
$anno_selezionato = isset($_GET['anno']) ? htmlspecialchars($_GET['anno']) : date("Y");
$piloti_url = "http://api.jolpi.ca/ergast/f1/$anno_selezionato/driverStandings.json";
$costruttori_url = "http://api.jolpi.ca/ergast/f1/$anno_selezionato/constructorStandings.json";

$piloti_data = null;
$costruttori_data = null;
$error_message = null;

$piloti_json = @file_get_contents($piloti_url);
$costruttori_json = @file_get_contents($costruttori_url);

if ($piloti_json && $costruttori_json) {
    $piloti_data = json_decode($piloti_json);
    $costruttori_data = json_decode($costruttori_json);
} else {
    $error_message = "Dati non disponibili per l'anno selezionato o errore di connessione.";
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
    <link rel="stylesheet" href="f1.css">
    <title>Classifiche Formula 1</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-md d-flex justify-content-center align-items-center">
    <img src="f1_logo.png" alt="Logo" class="navbar-logo">
    <a class="navbar-brand" href="#">Classifiche F1</a>
  </div>
</nav>


<div class="containerr">
    <h1>Storico Classifiche F1</h1>

    <form action="" method="get">
        <label for="anno">Seleziona l'anno:</label>
        <select name="anno" id="anno">
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

    <?php
    if ($piloti_data && $costruttori_data) {
            // Mappatura delle nazionalità ai codici ISO per le bandiere
    $codici_bandiere = [
        'American' => 'us',
        'Argentine' => 'ar',
        'Australian' => 'au',
        'Austrian' => 'at',
        'Belgian' => 'be',
        'Brazilian' => 'br',
        'British' => 'gb',
        'Canadian' => 'ca',
        'Chilean' => 'cl',
        'Colombian' => 'co',
        'Danish' => 'dk',
        'Dutch' => 'nl',
        'Finnish' => 'fi',
        'French' => 'fr',
        'German' => 'de',
        'Hungarian' => 'hu',
        'Indian' => 'in',
        'Indonesian' => 'id',
        'Irish' => 'ie',
        'Italian' => 'it',
        'Japanese' => 'jp',
        'Malaysian' => 'my',
        'Mexican' => 'mx',
        'Monegasque' => 'mc',
        'New Zealander' => 'nz',
        'Polish' => 'pl',
        'Portuguese' => 'pt',
        'Russian' => 'ru',
        'South African' => 'za',
        'Spanish' => 'es',
        'Swedish' => 'se',
        'Swiss' => 'ch',
        'Thai' => 'th',
        'Venezuelan' => 've',
        'Uruguayan' => 'uy',
        'Liechtensteiner' => 'li',
        'Chinese' => 'cn',
        // Aggiungi qui altre nazionalità se necessario
    ];

    // Tabella Classifica Piloti
    echo "<h2>Classifica Piloti - $anno_selezionato</h2>";
    echo "<table>";
    // Modifica l'ordine delle intestazioni qui
    echo "<thead><tr><th>Posto</th><th>Nazione</th><th>Nome</th><th>Team</th><th>Punti</th></tr></thead>"; 
    echo "<tbody>";
    foreach ($piloti_data->MRData->StandingsTable->StandingsLists[0]->DriverStandings as $pilota) {
        $posizione = isset($pilota->position) ? $pilota->position : '-';
        $punti = isset($pilota->points) ? $pilota->points : '0';
        $costruttore_nome = isset($pilota->Constructors[0]->name) ? $pilota->Constructors[0]->name : 'N/A';
        $nazionalita_pilota = isset($pilota->Driver->nationality) ? $pilota->Driver->nationality : 'N/A';
        
        // Ottieni il codice della bandiera dalla mappa
        $codice_bandiera = isset($codici_bandiere[$nazionalita_pilota]) ? $codici_bandiere[$nazionalita_pilota] : null;
        
        $tag_bandiera = '';
        if ($codice_bandiera) {
            $tag_bandiera = '<span class="flag-icon flag-icon-' . $codice_bandiera . '"></span>';
        } else {
            $tag_bandiera = $nazionalita_pilota;
        }

        echo "<tr>";
        // Modifica l'ordine delle celle qui, corrispondente all'intestazione
        echo "<td>" . $posizione . "</td>";
        echo "<td>" . $tag_bandiera . "</td>";
        echo "<td>" . $pilota->Driver->givenName . " " . $pilota->Driver->familyName . "</td>";
        echo "<td>" . $costruttore_nome . "</td>";
        echo "<td>" . $punti . " Punti</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

        // Tabella Classifica Costruttori
        echo "<h2>Classifica Costruttori - $anno_selezionato</h2>";
        echo "<table>";
        echo "<thead><tr><th>Posizione</th><th>Team</th><th>Punti</th></tr></thead>";
        echo "<tbody>";
        foreach ($costruttori_data->MRData->StandingsTable->StandingsLists[0]->ConstructorStandings as $costruttore) {
            $posizione = isset($costruttore->position) ? $costruttore->position : '-';
            $punti = isset($costruttore->points) ? $costruttore->points : '0';
            echo "<tr>";
            echo "<td>" . $posizione . "</td>";
            echo "<td>" . $costruttore->Constructor->name . "</td>";
            echo "<td>" . $punti . " Punti</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>$error_message</p>";
    }
    ?>
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






