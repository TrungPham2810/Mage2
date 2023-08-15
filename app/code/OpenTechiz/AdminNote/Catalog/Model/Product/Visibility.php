<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/02/2021
 * Time: 09:22
 */

namespace OpenTechiz\AdminNote\Catalog\Model\Product;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Visibility
 * @package OpenTechiz\LayeredNavigationExtend\Catalog\Model\Product
 */
class Visibility extends \Magento\Catalog\Model\Product\Visibility implements OptionSourceInterface
{
    const VISIBILITY_FILTER = 5;

    /**
     * @return array|int[]
     */
    public function getVisibleInSearchIds()
    {
        return array(self::VISIBILITY_IN_SEARCH, self::VISIBILITY_BOTH, self::VISIBILITY_FILTER);
    }

    /**
     * Retrieve visible in site ids array
     *
     * @return array
     */
    public function getVisibleInSiteIds()
    {
        return array(self::VISIBILITY_IN_SEARCH, self::VISIBILITY_IN_CATALOG, self::VISIBILITY_BOTH, self::VISIBILITY_FILTER);
    }

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::VISIBILITY_NOT_VISIBLE => __('Not Visible Individually'),
            self::VISIBILITY_IN_CATALOG => __('Catalog'),
            self::VISIBILITY_IN_SEARCH => __('Search'),
            self::VISIBILITY_BOTH => __('Catalog, Search'),
            self::VISIBILITY_FILTER => __('Search, Filter')
        ];
    }

    public static function getAllOptions()
    {
        $res = [];
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
//    public function toOptionArray()
//    {
//        $optionArray = [
//            self::VISIBILITY_NOT_VISIBLE => __('Not Visible Individually'),
//            self::VISIBILITY_IN_CATALOG => __('Catalog'),
//            self::VISIBILITY_IN_SEARCH => __('Search'),
//            self::VISIBILITY_BOTH => __('Catalog, Search'),
//            self::VISIBILITY_FILTER => __('Search, Filter')
//        ];
//
//        $res = [];
//        foreach ($optionArray as $index => $value) {
//            $res[] = ['value' => $index, 'label' => $value];
//        }
//        return $res;
//
//    }
}
