<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/02/2021
 * Time: 09:32
 */

namespace OpenTechiz\AdminNote\Plugin\Catalog\Model\Product;


class Visibility
{
    const VISIBILITY_FILTER = 5;

    /**
     * @return array|int[]
     */
    public function afterGetVisibleInSearchIds(\Magento\Catalog\Model\Product\Visibility $subject, $result)
    {
        if(is_array($result)) {
            array_push( $result, self::VISIBILITY_FILTER);
        }
        return $result;
//        return array(self::VISIBILITY_IN_SEARCH, self::VISIBILITY_BOTH, self::VISIBILITY_FILTER);
    }

    /**
     * Retrieve visible in site ids array
     *
     * @return array
     */
    public function afterGetVisibleInSiteIds(\Magento\Catalog\Model\Product\Visibility $subject, $result)
    {
        if(is_array($result)) {
            array_push( $result, self::VISIBILITY_FILTER);
        }
        return $result;
//        return array(self::VISIBILITY_IN_SEARCH, self::VISIBILITY_IN_CATALOG, self::VISIBILITY_BOTH, self::VISIBILITY_FILTER);
    }

    /**
     * @return array
     */
    public function afterGetOptionArray(\Magento\Catalog\Model\Product\Visibility $subject, $result)
    {
        if(is_array($result)) {
            array_push( $result, [self::VISIBILITY_FILTER => __('Search, Filter')]);
        }
        return $result;
//        return [
//            self::VISIBILITY_NOT_VISIBLE => __('Not Visible Individually'),
//            self::VISIBILITY_IN_CATALOG => __('Catalog'),
//            self::VISIBILITY_IN_SEARCH => __('Search'),
//            self::VISIBILITY_BOTH => __('Catalog, Search'),
//            self::VISIBILITY_FILTER => __('Search, Filter')
//        ];
    }
}