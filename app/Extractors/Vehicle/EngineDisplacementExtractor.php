<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Extractors\Vehicle;

use App\Extractors\ExtractorInterface;
use App\Helpers\Text;

/**
 * This is the engine displacement extractor class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class EngineDisplacementExtractor implements ExtractorInterface
{
    const REGEX_ENGDISPL = '/(\d+)\s*(cc|cm[³3])/iu';

    /**
     * The input string.
     *
     * @var string
     */
    protected $str;

    /**
     * Create a new engine displacement extractor instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->str = Text::removeAccents($params[0]);
    }

    /**
     * Extract the engine displacement.
     *
     * @return int|null
     */
    public function extract()
    {
        if (preg_match(self::REGEX_ENGDISPL, $this->str, $match)) {
            return (integer) $match[1];
        }
    }
}
