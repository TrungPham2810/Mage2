<?php


namespace OpenTechiz\CacheTest\Plugin;


use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context;

class CustomerContextPlugin
{
    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }
    /**
     * \Magento\Framework\App\Http\Context::getVaryString is used to retrieve unique identifier for selected context,
     * so this is a best place to declare custom context variables
     */
    public function beforeGetVaryString(Context $subject)
    {
//        $age = $this->customerSession->getCustomerData()->getCustomAttribute('age');
        $age = 35;
        $defaultAgeContext = 0;
        $ageContext = $age >= 18 ? 1 : $defaultAgeContext;
        $subject->setValue('CONTEXT_AGE', $ageContext, $defaultAgeContext);
    }
}
