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

use App\Extractors\AbstractExtractor;
use App\Helpers\Text;
use App\Models\Attributes\Generic\ItemPurchaseType;

/**
 * This is the purchase type extractor class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class PurchaseTypeExtractor extends AbstractExtractor
{
    /**
     * The item's purchase types.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $purchaseTypes;

    /**
     * Create a new purchase type extractor instance.
     *
     * @param array $params
     */
    public function __construct($params)
    {
        $this->str = Text::clean($params[0]);
        $this->purchaseTypes = ItemPurchaseType::all();
    }

    /**
     * Extract the purchase type.
     *
     * @return int|null
     */
    public function extract()
    {
        $this->str = Text::removeAccents($this->str);

        foreach ($this->purchaseTypes as $type) {
            if (preg_match($type->regex, $this->str)) {
                return $type->id;
            }
        }
    }
}
