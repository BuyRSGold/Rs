<?php
// === KONFIGURASJON ===
$apiKey = '77f0423d067808082f91eeaf'; // Din nøkkel
$cacheFile = 'exchange-cache.json';  // Hvor vi lagrer data
$cacheTime = 3600; // 1 time = 3600 sekunder

// === Hvis cache eksisterer og er fersk, bruk den ===
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
    $data = file_get_contents($cacheFile);
    header('Content-Type: application/json');
    echo $data;
    exit;
}

// === Hent nye data fra API ===
$url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/USD";
$response = file_get_contents($url);

if ($response !== false) {
    // Lagre til cache
    file_put_contents($cacheFile, $response);

    header('Content-Type: application/json');
    echo $response;
} else {
    // Feilhåndtering
    http_response_code(500);
    echo json_encode(['error' => 'Unable to fetch exchange rates.']);
}
