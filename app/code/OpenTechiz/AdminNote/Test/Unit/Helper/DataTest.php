<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace OpenTechiz\AdminNote\Test\Unit\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use OpenTechiz\AdminNote\Helper\Data;
use PHPUnit\Framework\TestCase;

/**
 * Class DataTest
 * @package OpenTechiz\AdminNote\Test\Unit\Helper
 */
class DataTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var Data
     */
    protected $helper;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $context = $this->createMock(Context::class);

        $this->helper = $this->objectManager->getObject(
            Data::class,
            [
                'context' => $context,
            ]
        );
    }

    public function testGetCurrentPathId()
    {
        $httpRequest = $this->createMock(Http::class);
        $httpRequest->expects($this->once())
            ->method('getFullActionName')
            ->willReturn('admin_adminnote_edit');
        $httpRequest->expects($this->once())
            ->method('getParams')
            ->willReturn([
                'id' => 12
            ]);

        $this->assertEquals('admin_adminnote_edit/12', $this->helper->getCurrentPathId());
    }
}
