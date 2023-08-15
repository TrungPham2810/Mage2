<?php

namespace Wagento\Zendesk\Helper\Api;

class Search extends AbstractApi
{
    // https://developer.zendesk.com/rest_api/docs/support/search
    // https://z3nianwagento.zendesk.com/api/v2/search.json?query=type:ticket
    // https://z3nianwagento.zendesk.com/api/v2/search.json?query=type:ticket%20status:open
    // https://z3nianwagento.zendesk.com/api/v2/search.json?query=type:ticket%20updated%3E2020-05-01%20updated%3C2020-08-05
    // https://z3nianwagento.zendesk.com/api/v2/search.json?query=type:ticket%20status:open%20priority:normal
    //const SEARCH = '/api/v2/search.json?query=type:ticket%20requester:roni_cost@example.com';

    // List Tickets: GET /api/v2/tickets.json
    public const SEARCH = '/api/v2/search.json';

    /**
     * Search Tickets

     * @param array $filters
     * @return array|mixed
     */
    public function searchTickets($filters = [])
    {
        $endpoint = self::SEARCH . "?query=type:ticket";
        if ($filters) {
            $endpoint .= "%20" . implode('%20', $filters);
        }
        $response = $this->get($endpoint);
        $data = json_decode($response, true);
        return isset($data['count']) && $data['count'] > 0 ? $data['results'] : [];
    }
}
