<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Psr\Log\LoggerInterface;

class AddZdUserIdCustomerMetadataInterfaceAttribute implements DataPatchInterface
{
    public const ZD_USER_ID = 'zd_user_id';
    public const ADMINHTML_CUSTOMER = 'adminhtml_customer';

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;

    /**
     * AddCustomerPhoneNumberAttribute constructor.

     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->logger               = $logger;
    }

    /**
     * Apply finction

     * @return void|AddZdUserIdCustomerMetadataInterfaceAttribute
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->createCustomerAttribute();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Create Customer Attribute

     * @return void
     */
    private function createCustomerAttribute()
    {
        $customerSetup  = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var \Magento\Eav\Model\Entity\Attribute\Set $attributeSet*/
        $attributeSet     = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(Customer::ENTITY, self::ZD_USER_ID, [
            'label' => 'Zendesk User Id',
            'type' => 'varchar',
            'input' => 'text',
            'visible' => true,
            'required' => false,
            'position' => 150,
            'sort_order' => 150,
            'system' => false
        ]);

        $this->setUsedInForm(
            $customerSetup,
            Customer::ENTITY,
            self::ZD_USER_ID,
            $attributeSetId,
            $attributeGroupId,
            [
                self::ADMINHTML_CUSTOMER,
            ]
        );
    }

    /**
     * Set Used In Form

     * @param \Magento\Customer\Setup\CustomerSetup $customerSetup    Customer Setup
     * @param string                                $entityType       Entity Type
     * @param string                                $attributeCode    Attribute Code
     * @param int                                   $attributeSetId   Attribute Set Id
     * @param int                                   $attributeGroupId Attribute Group Id
     * @param array                                 $usedInForms      Used In Forms
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function setUsedInForm(
        $customerSetup,
        $entityType,
        $attributeCode,
        $attributeSetId,
        $attributeGroupId,
        $usedInForms
    ) {
        $attribute = $customerSetup->getEavConfig()->getAttribute($entityType, $attributeCode)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => $usedInForms,
            ]);

        try {
            $attribute->save();
        } catch (\Exception $e) {
            $this->logger->error(
                __('Can\'t create customer address attributes'),
                ['exception' => $e->getMessage()]
            );
        }
    }
}
