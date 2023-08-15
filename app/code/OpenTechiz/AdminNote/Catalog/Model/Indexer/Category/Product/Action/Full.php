<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 19/02/2021
 * Time: 09:01
 */

namespace OpenTechiz\AdminNote\Catalog\Model\Indexer\Category\Product\Action;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Query\Generator as QueryGenerator;
use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Store\Model\Store;

class Full extends \Magento\Catalog\Model\Indexer\Category\Product\Action\Full
{
    public function testOverride()
    {
        return 'success full override';
    }

    protected function getNonAnchorCategoriesSelect(Store $store)
    {
        if (!isset($this->nonAnchorSelects[$store->getId()])) {
            $statusAttributeId = $this->config->getAttribute(
                Product::ENTITY,
                'status'
            )->getId();
            $visibilityAttributeId = $this->config->getAttribute(
                Product::ENTITY,
                'visibility'
            )->getId();

            $rootPath = $this->getPathFromCategoryId($store->getRootCategoryId());

            $metadata = $this->metadataPool->getMetadata(ProductInterface::class);
            $linkField = $metadata->getLinkField();
            $select = $this->connection->select()->from(
                ['cc' => $this->getTable('catalog_category_entity')],
                []
            )->joinInner(
                ['ccp' => $this->getTable('catalog_category_product')],
                'ccp.category_id = cc.entity_id',
                []
            )->joinInner(
                ['cpw' => $this->getTable('catalog_product_website')],
                'cpw.product_id = ccp.product_id',
                []
            )->joinInner(
                ['cpe' => $this->getTable('catalog_product_entity')],
                'ccp.product_id = cpe.entity_id',
                []
            )->joinInner(
                ['cpsd' => $this->getTable('catalog_product_entity_int')],
                'cpsd.' . $linkField . ' = cpe.' . $linkField . ' AND cpsd.store_id = 0' .
                ' AND cpsd.attribute_id = ' .
                $statusAttributeId,
                []
            )->joinLeft(
                ['cpss' => $this->getTable('catalog_product_entity_int')],
                'cpss.' . $linkField . ' = cpe.' . $linkField . ' AND cpss.attribute_id = cpsd.attribute_id' .
                ' AND cpss.store_id = ' .
                $store->getId(),
                []
            )->joinInner(
                ['cpvd' => $this->getTable('catalog_product_entity_int')],
                'cpvd.' . $linkField . ' = cpe.' . $linkField . ' AND cpvd.store_id = 0' .
                ' AND cpvd.attribute_id = ' .
                $visibilityAttributeId,
                []
            )->joinLeft(
                ['cpvs' => $this->getTable('catalog_product_entity_int')],
                'cpvs.' . $linkField . ' = cpe.' . $linkField . ' AND cpvs.attribute_id = cpvd.attribute_id' .
                ' AND cpvs.store_id = ' .
                $store->getId(),
                []
            )->where(
                $this->connection->getIfNullSql('cpvs.value', 'cpvd.value') . ' IN (?)',
                [
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH,
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH,
                    5
                ]
            )->columns(
                [
                    'category_id' => 'cc.entity_id',
                    'product_id' => 'ccp.product_id',
                    'position' => 'ccp.position',
                    'is_parent' => new \Zend_Db_Expr('1'),
                    'store_id' => new \Zend_Db_Expr($store->getId()),
                    'visibility' => new \Zend_Db_Expr(
                        $this->connection->getIfNullSql('cpvs.value', 'cpvd.value')
                    ),
                ]
            );

            $this->addFilteringByChildProductsToSelect($select, $store);

            $this->nonAnchorSelects[$store->getId()] = $select;
        }

        return $this->nonAnchorSelects[$store->getId()];
    }
    private function addFilteringByChildProductsToSelect(Select $select, Store $store)
    {
        $metadata = $this->metadataPool->getMetadata(ProductInterface::class);
        $linkField = $metadata->getLinkField();

        $statusAttributeId = $this->config->getAttribute(Product::ENTITY, 'status')->getId();

        $select->joinLeft(
            ['relation' => $this->getTable('catalog_product_relation')],
            'cpe.' . $linkField . ' = relation.parent_id',
            []
        )->joinLeft(
            ['relation_product_entity' => $this->getTable('catalog_product_entity')],
            'relation.child_id = relation_product_entity.entity_id',
            []
        )->joinLeft(
            ['child_cpsd' => $this->getTable('catalog_product_entity_int')],
            'child_cpsd.' . $linkField . ' = '. 'relation_product_entity.' . $linkField
            . ' AND child_cpsd.store_id = 0'
            . ' AND child_cpsd.attribute_id = ' . $statusAttributeId,
            []
        )->joinLeft(
            ['child_cpss' => $this->getTable('catalog_product_entity_int')],
            'child_cpss.' . $linkField . ' = '. 'relation_product_entity.' . $linkField . ''
            . ' AND child_cpss.attribute_id = child_cpsd.attribute_id'
            . ' AND child_cpss.store_id = ' . $store->getId(),
            []
        )->where(
            'relation.child_id IS NULL OR '
            . $this->connection->getIfNullSql('child_cpss.value', 'child_cpsd.value') . ' = ?',
            \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED
        )->group(
            [
                'cc.entity_id',
                'ccp.product_id',
                'visibility',
            ]
        );
    }
}