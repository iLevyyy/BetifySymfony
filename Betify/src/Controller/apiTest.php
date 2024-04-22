<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class apiTest extends AbstractController
{
    public function getTopSongs()
    {
        // Definir las credenciales de la aplicación Spotify
        $client_id = '62c59ffd98ff48419f68487957a44b84';
        $client_secret = '59ae1ac04a9740bea1dc14569bfb3d99';

        // Obtener un token de acceso de Spotify utilizando las credenciales de la aplicación
        $auth_client = new Client([
            'base_uri' => 'https://accounts.spotify.com/',
        ]);

        $response = $auth_client->request('POST', 'api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $access_token = $data['access_token'];

        // Realizar una solicitud a la API de Spotify para obtener las 20 primeras canciones del top global
        $spotify_client = new Client([
            'base_uri' => 'https://api.spotify.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ],
        ]);

        $response = $spotify_client->request('GET', 'playlists/37i9dQZEVXbMDoHDwVN2tF/tracks', [
        ]);
        

        $top_songs = json_decode($response->getBody()->getContents(), true);


        return new JsonResponse($response);
    }
}
