<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Helpers\Text;

/**
 * This is the text helper test class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class TextHelperTest extends AbstractTestCase
{
    public function testRemoveAccents()
    {
        $text = 'àáâãäÀÁÂÃÄèéêẽëÈÉÊẼËìíîĩïÌÍÎĨÏòóôõöÒÓÔÕÖùúûũüÙÚÛŨÜçÇ';
        $expected = 'aaaaaAAAAAeeeeeEEEEEiiiiiIIIIIoooooOOOOOuuuuuUUUUUcC';

        $this->assertEquals($expected, Text::removeAccents($text));
    }

    public function testClean()
    {
        $text = "Lorem  \nipsum  \tdolor sit amet,  consectetur adipiscing.";
        $expected = 'Lorem ipsum dolor sit amet, consectetur adipiscing.';

        $this->assertEquals($expected, Text::clean($text));
    }
}