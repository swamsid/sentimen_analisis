<?php
/**
 * Sastrawi (https://github.com/sastrawi/sastrawi)
 *
 * @link      http://github.com/sastrawi/sastrawi for the canonical source repository
 * @license   https://github.com/sastrawi/sastrawi/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\Stemmer;

class CachedStemmer implements StemmerInterface
{
    protected $cache;
    protected $arrayBucket;
    protected $delegatedStemmer;

    public function __construct(Cache\CacheInterface $cache, StemmerInterface $delegatedStemmer, Array $arrayBucket)
    {
        $this->cache = $cache;
        $this->delegatedStemmer = $delegatedStemmer;
        $this->arrayBucket = $arrayBucket;

        // echo json_encode($arrayBucket);
    }

    public function stem($text)
    {
        $normalizedText = Filter\TextNormalizer::normalizeText($text);

        $words = explode(' ', $normalizedText);
        $stems = array();

        foreach ($words as $word) {
            // var_dump($this->cache);

            // echo $word;
            if ($this->cache->has($word)) {
                // echo "a<br>";
                $stems[] = $this->cache->get($word);
            } else {
                if(in_array($word, $this->arrayBucket)){
                    $stem = $this->delegatedStemmer->stem($word);
                    $this->cache->set($word, $stem);
                    $stems[] = $stem;
                }
            }
        }

        // echo json_encode($stems);
        return implode(' ', $stems);
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function getDelegatedStemmer()
    {
        return $this->delegatedStemmer;
    }
}
