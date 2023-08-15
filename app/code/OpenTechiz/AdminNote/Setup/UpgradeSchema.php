<?php
namespace OpenTechiz\AdminNote\Setup;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 * @package OpenTechiz\CatalogExtend\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * UpgradeSchema constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();
        try {
            if (version_compare($context->getVersion(), '2.0.4', '<')) {
                $eavSetup->addAttribute(
                    Category::ENTITY,
                    'slider_id',
                    [
                        'type' => 'text',
                        'label' => 'Slide Id',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 20,

                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                        'group' => 'Setting Slider',
                    ]
                );
                $eavSetup->addAttribute(
                    Category::ENTITY,
                    'slider_align',
                    [
                        'type' => 'text',
                        'label' => 'Slide Align',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 30,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'Setting Slider',
                    ]
                );
            }

        } catch (LocalizedException $e) {
        } catch (Zend_Validate_Exception $e) {
        }
    }
}
