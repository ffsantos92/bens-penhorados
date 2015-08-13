<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This is the nif extractor test class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class NifExtractorTest extends AbstractCorporateShareExtractorTest
{
    public function testExtractNif()
    {
        $text = [
            '100000000' => 100000000,
            '200000000' => 200000000,
            '500000000' => 500000000,
            '600000000' => 600000000,
            '800000000' => 800000000,
            '900000000' => 900000000,
        ];

        foreach ($text as $input => $expected) {
            $this->assertSame($expected, $this->extractor->nif($input));
        }
    }
}
