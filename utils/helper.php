<?php

function getBaseUrl(): string
{
    // Détection du protocole
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
    );
    $protocol = $isHttps ? 'https' : 'http';

    // Hôte (nom de domaine + port)
    $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

    // Calcul du sous-dossier racine du projet à partir de DOCUMENT_ROOT
    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $currentDir = str_replace('\\', '/', dirname(realpath($_SERVER['SCRIPT_FILENAME'])));
    $relativePath = str_replace($docRoot, '', $currentDir);
    $relativePath = explode('/', trim($relativePath, '/'))[0] ?? '';
    $basePath = $relativePath ? '/' . $relativePath : '';

    // Construire l'URL de base
    $baseUrl = rtrim($protocol . '://' . $host . $basePath, '/');

    return $baseUrl;
}