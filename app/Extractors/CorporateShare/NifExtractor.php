<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Extractors\CorporateShare;

use App\Extractors\ExtractorInterface;

/**
 * This is the nif extractor class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class NifExtractor implements ExtractorInterface
{
    const REGEX_NIF = '/\b[12568][0-9]{8}\b/';

    /**
     * The input string.
     *
     * @var string
     */
    protected $str;

    /**
     * Create a new nif extractor instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->str = $params[0];
    }

    /**
     * Extract the NIF.
     *
     * @return int|null
     */
    public function extract()
    {
        if (preg_match(self::REGEX_NIF, $this->str, $match)) {
            return (integer) $match[0];
        }
    }
}