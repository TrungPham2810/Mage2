<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\Zendesk\Ui\Component;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * @var \Wagento\Zendesk\Helper\Api\Ticket
     */
    private $ticket;

    /**
     * @var \Wagento\Zendesk\Helper\Api\User
     */
    private $user;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Magento\Backend\Helper\Data
     */
    private $backedUrl;
    /**
     * @var \Wagento\Zendesk\Helper\Api\Search
     */
    private $searchApi;

    /**
     * DataProvider constructor.

     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param \Wagento\Zendesk\Helper\Api\Ticket $ticket
     * @param \Wagento\Zendesk\Helper\Api\User $user
     * @param \Magento\Backend\Helper\Data $backedUrl
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Wagento\Zendesk\Helper\Api\Search $searchApi
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        \Wagento\Zendesk\Helper\Api\Ticket $ticket,
        \Wagento\Zendesk\Helper\Api\User $user,
        \Magento\Backend\Helper\Data $backedUrl,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Wagento\Zendesk\Helper\Api\Search $searchApi,
        array $meta = [],
        array $data = []
    ) {

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->ticket = $ticket;
        $this->user = $user;
        $this->urlBuilder = $urlBuilder;
        $this->backedUrl = $backedUrl;
        $this->searchApi = $searchApi;
    }

    /**
     * Get Data

     * @return array
     */
    public function getData()
    {
        $users = $this->user->listUsers();
        $emails = array_column($users, 'email', 'id');

        // Filters
        // https://z3nianwagento.zendesk.com//api/v2/search.json?query=type:ticket%20updated%3E2020-05-01%20updated%3C2020-08-05
        // https://z3nianwagento.zendesk.com//api/v2/search.json?query=type:ticket%20status:open%20priority:normal
        $mFiters = $this->request->getParam('filters');

        $zFilters = [];

        if ($mFiters) {
            foreach ($mFiters as $name => $filter) {
                switch ($name) {
                    case 'id':
                        $zFilters[] = $filter; // Ticket id no needs param
                        break;
                    case 'email':
                        $zFilters[] = "requester:{$filter}*";
                        break;
                    case 'subject':
                        $zFilters[] = "subject:\"{$filter}\"";
                        break;
                    case 'type':
                        $zFilters[] = "ticket_type:{$filter}";
                        break;
                    case 'priority':
                        $zFilters[] = "priority:{$filter}";
                        break;
                    case 'status':
                        $zFilters[] = "status:{$filter}";
                        break;
                    case 'created_at':
                        if (isset($filter['from'])) {
                            $from = $filter['from'];
                            $zFilters[] = "created > $from";
                        }
                        if (isset($filter['to'])) {
                            $to = $filter['to'];
                            $zFilters[] = "created < $to";
                        }
                        break;
                    case 'updated_at':
                        if (isset($filter['from'])) {
                            $from = $filter['from'];
                            $zFilters[] = "updated > $from";
                        }
                        if (isset($filter['to'])) {
                            $to = $filter['to'];
                            $zFilters[] = "updated < $to";
                        }
                        break;
                }
            }
        }
        $tickets = $this->searchApi->searchTickets($zFilters);

        //sorting
        if ($sorting = $this->request->getParam('sorting')) {
            $tickets = $this->getSorting($tickets, $sorting, $emails);
        }

        $data = [];
        $result = [];
        $data['totalRecords'] = count($tickets);

        //paging
        $searchCriteria = $this->searchCriteriaBuilder->getData();

        $page_size = $searchCriteria['page_size'];
        $current_page = $searchCriteria['current_page'];

        $first = (($page_size * $current_page) - $page_size);

        if (($first + $page_size) < count($tickets)) {
            $last = $page_size * $current_page;
        } else {
            $last = count($tickets);
        }
        //end

        for ($i = $first; $i < $last; $i++) {
            $ticket = $tickets[$i];

            $result[] = $ticket;
        }

        $data['items'] = $result;

        return $data;
    }

    /**
     * Get Sorting Tickets.

     * @param array $tickets
     * @param array $sorting
     * @param array $emails
     */
    private function getSorting($tickets, $sorting, $emails)
    {
        $array_sorting = [];
        $key = 0;
        foreach ($tickets as $ticket) {
            $ticket['email'] = (isset($emails[$ticket['requester_id']]) ? $emails[$ticket['requester_id']] : '');
            $array_sorting[$ticket[$sorting['field']] . $key] = $ticket;
            $key++;
        }

        if ($sorting['direction'] == 'asc') {
            ksort($array_sorting);
        } else {
            krsort($array_sorting);
        }

        return array_values($array_sorting);
    }
}
