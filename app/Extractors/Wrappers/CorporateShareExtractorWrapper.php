<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Extractors\Wrappers;

/**
 * This is the corporate share extractor wrapper.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 *
 * @method int|null nif(string $str)
 */
class CorporateShareExtractorWrapper extends AbstractExtractorWrapper
{
    const EXTRACTORS = [
        'nif' => '\App\Extractors\CorporateShare\NifExtractor',
    ];
}
