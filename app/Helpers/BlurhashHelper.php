<?php


namespace App\Helpers;


use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use kornrunner\Blurhash\Blurhash;

class BlurhashHelper
{
    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function generateBlurhash(UploadedFile $uploadedFile): string
    {
        $image = Image::make($uploadedFile)->getCore();
        $width = imagesx($image);
        $height = imagesy($image);

        $pixels = [];
        for ($y = 0; $y < $height; ++$y) {
            $row = [];
            for ($x = 0; $x < $width; ++$x) {
                $index = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $index);

                $row[] = [$colors['red'], $colors['green'], $colors['blue']];
            }
            $pixels[] = $row;
        }

        $components_x = 4;
        $components_y = 3;

        return Blurhash::encode($pixels, $components_x, $components_y);
    }
}
