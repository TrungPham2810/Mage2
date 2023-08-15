<?php

namespace Wagento\Zendesk\Block\Adminhtml\Ticket;

use Magento\Framework\View\Element\Template;

class Reply extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Wagento\Zendesk\Helper\Api\Ticket
     */
    private $ticketApi;
    /**
     * @var \Wagento\Zendesk\Helper\Api\Comment
     */
    private $commentApi;
    /**
     * @var \Wagento\Zendesk\Helper\Api\User
     */
    private $userApi;
    /**
     * @var \Wagento\Zendesk\Model\Config\Source\Ticket\Status
     */
    private $statusList;

    /**
     * Reply construct

     * @param Template\Context $context
     * @param \Wagento\Zendesk\Helper\Api\Ticket $ticketApi
     * @param \Wagento\Zendesk\Helper\Api\Comment $commentApi
     * @param \Wagento\Zendesk\Helper\Api\User $userApi
     * @param \Wagento\Zendesk\Model\Config\Source\Ticket\Status $statusList
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Wagento\Zendesk\Helper\Api\Ticket $ticketApi,
        \Wagento\Zendesk\Helper\Api\Comment $commentApi,
        \Wagento\Zendesk\Helper\Api\User $userApi,
        \Wagento\Zendesk\Model\Config\Source\Ticket\Status $statusList,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketApi = $ticketApi;
        $this->commentApi = $commentApi;
        $this->userApi = $userApi;
        $this->statusList = $statusList;
    }

    /**
     * Get Ticket Requester

     * @return false|mixed
     */
    public function getTicketRequester()
    {
        $ticketId = $this->getTicketId();
        $res = $this->ticketApi->showTicket($ticketId);
        return $res['requester_id'] ?? false;
    }

    /**
     * Get Ticket Comments.
     *
     * @return array
     */
    public function getComments()
    {
        $ticketId = $this->getTicketId();
        return $this->commentApi->getTicketComments($ticketId);
    }

    /**
     * Get Ticket Id.
     *
     * @return mixed
     */
    public function getTicketId()
    {
        return $this->getRequest()->getParam('id', null);
    }

    /**
     * Get user names.
     *
     * @param mixed $userId
     * @return mixed
     */
    public function getUserName($userId)
    {
        $data = $this->userApi->showUser($userId);
        return $data['name'];
    }

    /**
     * Get Agent Users

     * @return array
     */
    public function getAgentUsers()
    {
        $res = $this->userApi->listAgentUsers();
        return array_column($res, 'email', 'id');
    }

    /**
     * Get Action Url.
     *
     * @return string
     */
    public function getActionUrl()
    {
        return $this->_urlBuilder->getUrl('*/ticket/replypost');
    }

    /**
     * Get Status List

     * @return string[]
     */
    public function getStatusList()
    {
        return [
            '' => '-',
            'open' => 'Open',
            'pending' => 'Pending',
            'hold' => 'Hold',
            'solved' => 'Solved',
            'closed' => 'Closed',
        ];
    }
}
