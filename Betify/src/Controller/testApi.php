<?php

// Credenciales de la API de Spotify
$client_id = '62c59ffd98ff48419f68487957a44b84';
$client_secret = '59ae1ac04a9740bea1dc14569bfb3d99';

// Autenticación y obtención del token de acceso
$token_url = 'https://accounts.spotify.com/api/token';
$auth_header = base64_encode($client_id . ':' . $client_secret);
$auth_data = array(
    'grant_type' => 'client_credentials',
);

$auth_options = array(
    'http' => array(
        'header' => "Authorization: Basic $auth_header\r\n" . "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($auth_data),
    ),
);

$auth_context = stream_context_create($auth_options);
$auth_response = file_get_contents($token_url, false, $auth_context);
$auth_result = json_decode($auth_response, true);
$access_token = $auth_result['access_token'];

// Petición para obtener las 20 canciones más escuchadas
$api_url = 'https://api.spotify.com/v1/browse/categories/toplists/playlists/37i9dQZEVXbMDoHDwVN2tF/tracks';
$request_options = array(
    'http' => array(
        'header' => "Authorization: Bearer $access_token",
        'method' => 'GET',
    ),
);

$request_context = stream_context_create($request_options);
$response = file_get_contents($api_url, false, $request_context);
$data = json_decode($response, true);

// Mostrar las canciones
if (isset($data['items'])) {
    echo "Top 20 canciones más escuchadas en Spotify:<br>";
    foreach ($data['items'] as $item) {
        echo $item['track']['name'] . ' - ' . $item['track']['artists'][0]['name'] . '<br>';
    }
} else {
    echo "Error al obtener las canciones.";
}
?>
