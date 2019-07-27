<?php
/**
 * This is a basic example, it reads $_POST and web pages without any sort of
 * escaping. It should be considered unsafe to use in prod.
 */
require __DIR__ . '/../vendor/autoload.php';

use SixtyNine\WordCloud\Builder\WordCloudBuilder;
use SixtyNine\WordCloud\Renderer\WordCloudRenderer;
use SixtyNine\WordCloud\Helper\Palette;
use SixtyNine\WordCloud\FrequencyTable\FrequencyTableFactory;
use SixtyNine\WordCloud\Builder\Context\BuilderContextFactory;
use SixtyNine\WordCloud\ImageBuilder\RawImageRenderer;


$text = 'aa bb';

// echo $text;

$img_width = 100;
$img_height = 640;

$palette = Palette::getNamedPalette($_POST['palette'] ? : 'grey');
$font = $_POST['font'] ? : 'Arial.ttf';
$font = __DIR__ . '/../fonts/' . $font;

$ft = FrequencyTableFactory::getDefaultFrequencyTable($text);

$builder = new WordCloudBuilder(
    $ft,
    BuilderContextFactory::getDefaultBuilderContext($ft, $palette, $font, $img_width, $img_height),
    array(
        'font' => $font,
        'size' => array($img_width, $img_height)
    )
);

$imgRenderer = new RawImageRenderer(
    $builder->build(50),
    new WordCloudRenderer()
);

?>

<img src="data:image/png;base64,<?= base64_encode($imgRenderer->getImage()) ?>" width="100%"/>
