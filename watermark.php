<?php

namespace app\helpers;

use Imagine\Gd\Imagine;
use Imagine\Image\Point;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Yii;

class Watermark
{
    const WATERMARK = '/static/imgs/watermark.png';
    const MULTIPLICITY = 3;
    const REDUCTION_FREQUENCY = 2;

    public static function dimensions($img, $width, $height)
    {
        $imagine = new Imagine();
        $watermark = $imagine->open(Yii::getAlias('@webroot') . self::WATERMARK );
        $wSize     = $watermark->getSize();
        $imgSize = $img->getSize();

        $currentHeight = ($height > $imgSize->getHeight() ? $imgSize->getHeight() : $height) - $wSize->getHeight();
        // Left down
        $position = new Point(0, $currentHeight);

        $corpImage = $img
            ->copy()
            ->thumbnail(new Box($width, $height), ImageInterface::THUMBNAIL_OUTBOUND)
            ->paste($watermark, $position);

        $dimension = $imgSize->getWidth() / $wSize->getWidth();

        if($dimension > self::MULTIPLICITY){
            $watermarkWidth = $wSize->getWidth() * $dimension / self::REDUCTION_FREQUENCY;
            $watermarkHeight  = $wSize->getHeight() * $dimension / self::REDUCTION_FREQUENCY;
            $positionCenter = new Point(
                ($imgSize->getWidth() / $dimension),
                ($imgSize->getHeight() / $dimension)
            );
        } else {
            $watermarkWidth = $wSize->getWidth();
            $watermarkHeight  = $wSize->getHeight();
            $positionCenter = new Point(
                $imgSize->getWidth() / self::REDUCTION_FREQUENCY,
                $imgSize->getHeight() / self::REDUCTION_FREQUENCY
            );
        }

        $newWatermark = $watermark->resize(new Box($watermarkWidth, $watermarkHeight));

        $img->paste($newWatermark, $positionCenter);

        return $corpImage;
    }
}
