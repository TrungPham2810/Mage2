<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace OpenTechiz\AdminNote\Test\Unit\Model;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use OpenTechiz\AdminNote\Model\AdminNote;
use OpenTechiz\AdminNote\Model\NoteUserRelation;
use OpenTechiz\AdminNote\Model\NoteUserRelationFactory;
use OpenTechiz\AdminNote\Model\ResourceModel\AdminNote as AdminNoteResource;
use OpenTechiz\AdminNote\Model\ResourceModel\AdminNote\Collection;
use OpenTechiz\AdminNote\Model\ResourceModel\NoteUserRelation\Collection as NoteUserRelationCollection;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class AdminNoteTest
 * @package OpenTechiz\AdminNote\Test\Unit\Model
 */
class AdminNoteTest extends TestCase
{
    /**
     * @var Registry|PHPUnit_Framework_MockObject_MockObject
     */
    protected $registry;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var AdminNoteResource|PHPUnit_Framework_MockObject_MockObject
     */
    protected $resource;

    /**
     * @var Collection|PHPUnit_Framework_MockObject_MockObject
     */
    protected $collection;

    /**
     * @var AdminNote
     */
    protected $model;

    /**
     * @var NoteUserRelationFactory
     */
    protected $noteUserRelation;

    /**
     * @var Session
     */
    protected $authSession;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $context = $this->createMock(Context::class);
        $this->registry = $this->createMock(Registry::class);
        $this->resource = $this->createMock(AdminNoteResource::class);
        $this->collection = $this->createMock(Collection::class);
        $this->authSession = $this->createPartialMock(
            Session::class,
            [
                'getUser', 'getUserId'
            ]
        );
        $this->noteUserRelation = $this->getMockBuilder(NoteUserRelationFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->model = $this->objectManager->getObject(
            AdminNote::class,
            [
                'context' => $context,
                'registry' => $this->registry,
                'collection' => $this->collection,
                'resource' => $this->resource,
                'authSession' => $this->authSession,
                'noteUserRelation' => $this->noteUserRelation
            ]
        );
    }

    public function testLoadStatus()
    {
        $userId = 2;
        $noteId = 2;
        $this->authSession->expects($this->once())
            ->method('getUser')->willReturnSelf();
        $this->authSession->expects($this->once())->method('getUserId')->willReturn($userId);

        $this->model->setNoteId($noteId);
        $noteUserCollection = $this->createMock(NoteUserRelationCollection::class);
        $noteUserModel = $this->createMock(NoteUserRelation::class);

        $this->noteUserRelation->expects($this->any())
            ->method('create')
            ->willReturn($noteUserModel);

        $noteUserModel->expects($this->once())
            ->method('getCollection')->willReturn($noteUserCollection);
        $noteUserCollection->expects($this->at(0))
            ->method('addFieldToFilter')
            ->with('user_id', ['eq' => $userId])
            ->willReturnSelf();
        $noteUserCollection->expects($this->at(1))
            ->method('addFieldToFilter')
            ->with('note_id', ['eq' => $noteId])
            ->willReturnSelf();
        $noteUserCollection->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $noteUserModel->expects($this->once())
            ->method('addData')->with([
                'user_id'          => $userId,
                'note_id'          => $noteId
            ])->willReturnSelf();
        $noteUserModel->expects($this->once())->method('save')->willReturnSelf();

        $this->model->loadStatus();
    }
}
