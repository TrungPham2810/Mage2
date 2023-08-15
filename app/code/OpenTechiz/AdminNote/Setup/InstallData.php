<?php
namespace OpenTechiz\AdminNote\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\Backend\Datetime;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Zend_Validate_Exception;
use Magento\Catalog\Helper\DefaultCategory;
use Magento\Catalog\Helper\DefaultCategoryFactory;
use Magento\Catalog\Setup\CategorySetupFactory;


class InstallData implements InstallDataInterface
{
    protected $eavSetupFactory;
    private $categorySetupFactory;
    private $moduleDataSetup;
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CategorySetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $connection->addColumn(
            $setup->getTable('catalog_product_entity'),
            'xxxxxx',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length' => 10,
                'nullable' => true,
                'comment' => 'Category Depth'
            ]
        );
        $setup->endSetup();

        $eavSetup = $this->eavSetupFactory->create();

        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $categorySetup->addAttributeGroup($entityTypeId, $attributeSetId, 'New Group Test', 20);
        $initials = [
            'group'                      => 'General',
            'input'                      => 'select',
            'type'                       => 'int',
            'label'                      => 'Initials',
            'visible'                    => true,
            'required'                   => false,
            'user_defined'               => true,
            'searchable'                 => true,
            'filterable'                 => true,
            'comparable'                 => true,
            'visible_on_front'           => true,
            'visible_in_advanced_search' => true,
            'is_html_allowed_on_front'   => false,
            'used_for_promo_rules'       => true,
            'frontend_class'             => '',
            'global'                     =>  ScopedAttributeInterface::SCOPE_GLOBAL,
            'unique'                     => false,
            'apply_to'                   => 'simple,grouped,configurable,downloadable,virtual,bundle',
            'is_used_in_grid'            => true,
            'is_visible_in_grid'         => false,
            'is_filterable_in_grid'      => true,
        ];
        try {
            $eavSetup->addAttribute(Product::ENTITY, 'initials', $initials);
            $eavSetup->addAttribute(
                Product::ENTITY,
                'yyyyyy',
                [
                    'type' => 'static',
                    'input' => 'date',
                    'sort_order' => 19,
                    'visible' => false,
                ]
            );

            $eavSetup->addAttribute(
                Product::ENTITY,
                'xxxxxx',
                [
                    'type' => 'static',
                    'label' => 'xxxxxx',
                    'input' => 'text',
                    'frontend_class' => 'validate-length maximum-length-64',
                    'unique' => true,
                    'sort_order' => 2,
                    'searchable' => true,
                    'comparable' => true,
                    'visible_in_advanced_search' => true,
                ]
            );
            $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'rule_metal_diamond');
            $eavSetup->addAttribute(
                Category::ENTITY,
                'category_template_extend',
                [
                    'type' => 'varchar',
                    'label' => 'Category Template Extend',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 100,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'New Group Test',
                ]
            );
            $eavSetup->addAttribute(Product::ENTITY, 'created_at', [
                'label' => 'New',
                'type' => 'static',
                'input' => 'datetime',
                'backend' => Datetime::class,
//                'backend' => null,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => 1,
                'required' => 1,
                'visible_on_front' => 0,
                'used_in_product_listing' => true
            ]);

            $eavSetup->addAttribute(Product::ENTITY, 'test', [
                'label' => 'Test',
                'type' => 'datetime',
                'input' => 'datetime',
                'backend' => Datetime::class,
//                'backend' => null,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => 1,
                'required' => 0,
                'visible_on_front' => 0,
                'used_in_product_listing' => true
            ]);

            $eavSetup->addAttribute(Product::ENTITY,

                'helloworld_label', array(

                    'type' => 'varchar',

                    'label' => 'HeloWorld label',

                    'input' => 'text',

                    'required' => false,

                    'visible_on_front' => true,

                    'apply_to' => 'simple,configurable,virtual,bundle,downloadable',

                    'unique' => false,

                    'group' => 'HelloWorld'

                ));

//            $eavSetup->addAttribute(
//                Category::ENTITY,
//                'stone_available',
//                [
//                    'type' => 'text',
//                    'label' => 'Stone Available',
//                    'input' => 'text',
//                    'required' => false,
//                    'sort_order' => 110,
//                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
//                    'group' => 'General Information',
//                ]
//            );
//
//            $eavSetup->addAttribute(
//                Category::ENTITY,
//                'category_filter',
//                [
//                    'type' => 'int',
//                    'label' => 'Category Filter',
//                    'input' => 'select',
//                    'required' => false,
//                    'sort_order' => 120,
//                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
//                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
//                    'group' => 'General Information',
//                ]
//            );
//            $eavSetup->addAttribute(
//                Category::ENTITY,
//                'custom_view_layout',
//                [
//                    'type' => 'varchar',
//                    'label' => 'Custom View layout',
//                    'input' => 'select',
//                    'required' => false,
//                    'sort_order' => 130,
//                    'source' => 'OpenTechiz\CatalogExtend\Model\Catalog\Attribute\CustomViewLayout',
//                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
//                    'group' => 'Display Settings',
//                ]
//            );
        } catch (LocalizedException $e) {
        } catch (Zend_Validate_Exception $e) {
        }
    }
}
