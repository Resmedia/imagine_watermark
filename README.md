# Imagine Watermark Settings

These settings are for the GalleryBehavior app from zxbodya. 
They are make positioning watermark depending on the size photo, both as newly created and on originals.

### Settings 

```
// path to watermark in my case the dimensions are 351x134
const WATERMARK = '/static/imgs/watermark.png'; 

//The multiplicity of how many times you need to change the watermark if the photo is large
const MULTIPLICITY = 3; 

// Height adjustment
const HEIGHT_AMENDMENT = 600;

// Width adjustment
const WIDTH_AMENDMENT = 140;

// Watermark size adjustment
const REDUCTION_FREQUENCY = 2;
```

### Settings at behavior in model

```
'galleryBehavior' => [
                'class' => GalleryBehavior::class,
                'type' => 'product',
                'extension' => 'jpg',
                // image dimmentions for preview in widget
                'previewWidth' => 300,
                'previewHeight' => 200,
                // path to location where to save images
                'directory' => Yii::getAlias('@webroot') . '/uploads/products',
                'url' => Yii::getAlias('@web') . '/uploads/products',
                // additional image versions
                'versions' => [
                    'i800x800' => function ($img) {
                        $width = 800;
                        $height = 800;

                        return Watermark::dimensions($img, $width, $height);
                    },
                ],
```
