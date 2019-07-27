<?php

require __DIR__ . '/../vendor/autoload.php';

use SixtyNine\WordCloud\Builder\WordCloudBuilder;
use SixtyNine\WordCloud\Renderer\WordCloudRenderer;
use SixtyNine\WordCloud\Helper\Palette;
use SixtyNine\WordCloud\FrequencyTable\FrequencyTableFactory;
use SixtyNine\WordCloud\Builder\Context\BuilderContextFactory;
use SixtyNine\WordCloud\ImageBuilder\RawImageRenderer;
use Colors\RandomColor;


/**
 * The text to build the word cloud from
 */
$text = <<<EOT
A tag cloud (word cloud, or weighted list in visual design) is a visual representation for text data, typically used to depict keyword metadata (tags) on websites, or to visualize free form text. 'Tags' are usually single words, normally listed alphabetically, and the importance of each tag is shown with font size or color.[1] This format is useful for quickly perceiving the most prominent terms and for locating a term alphabetically to determine its relative prominence. When used as website navigation aids, the terms are hyperlinked to items associated with the tag.
In the language of visual design, a tag cloud (or word cloud) is one kind of "weighted list", as commonly used on geographic maps to represent the relative size of cities in terms of relative typeface size. An early printed example of a weighted list of English keywords was the "subconscious files" in Douglas Coupland's Microserfs (1995). A German appearance occurred in 1992.[2]
EOT;

/**
 * The TrueType font to use
 */
$font = __DIR__ . '/../fonts/Arial.ttf';

/**
 * Dimensions of the resulting image
 */
$img_width = 1000;

$img_height = 750;

/**
 * The color palette to use
 */

$colors = RandomColor::many(30, array(
    'luminosity' => 'bright',
    'hue' => array('purple'),
));
$palette = Palette::getPaletteFromHex($colors);

/**
 * Create a frequency table from the text
 */
$ft = FrequencyTableFactory::getDefaultFrequencyTable($text);

/**
 * Setup the cloud builder and build the word cloud
 */
$builder = new WordCloudBuilder(
    $ft,
    BuilderContextFactory::getDefaultBuilderContext($ft, $palette, $font, $img_width, $img_height),
    array(
        'font' => $font,
        'size' => array($img_width, $img_height)
    )
);
$cloud = $builder->build(50);

/**
 * Render the word cloud image
 */

// var_dump($cloud);

$renderer = new WordCloudRenderer();

$imgRenderer = new RawImageRenderer($cloud, $renderer);
$source = imagecreatefromstring($imgRenderer->getImage());

if ($source !== false) {
    header('Content-Type: image/jpeg');
    imagepng($source);
    imagedestroy($source);
}
