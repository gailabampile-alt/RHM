<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

// Créer une nouvelle image de 300x200 pixels
$image = Image::canvas(300, 200, '#bdc3c7');

// Écrire du texte sur l'image
$image->text('Carte de Service', 150, 100, function($font) {
    $font->file('path/to/font.ttf');
    $font->size(24);
    $font->color('#000000');
    $font->align('center');
    $font->valign('middle');
});

// Sauvegarder l'image sur le serveur
$image->save('carte_service.png');
