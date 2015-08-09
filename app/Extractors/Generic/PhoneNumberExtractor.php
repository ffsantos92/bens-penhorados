<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Extractors\Generic;

use App\Extractors\ExtractorInterface;
use App\Helpers\Text;

/**
 * This is the phone number extractor class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class PhoneNumberExtractor implements ExtractorInterface
{
    const REGEX_PHONENUMBER = '/\d{9,}/';

    /**
     * The input string.
     *
     * @var string
     */
    protected $str;

    /**
     * Create a new phone number extractor instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->str = Text::clean($params[0]);
    }

    /**
     * Extract the phone number.
     *
     * @return int|null
     */
    public function extract()
    {
        if (preg_match(self::REGEX_PHONENUMBER, $this->str, $match)) {
            return (integer) $match[0];
        }
    }
}
