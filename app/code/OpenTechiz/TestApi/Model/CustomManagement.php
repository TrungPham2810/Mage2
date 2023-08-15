<?php


namespace OpenTechiz\TestApi\Model;


class CustomManagement implements \OpenTechiz\TestApi\Api\CustomManagementInterface
{
    /**
     * {@inheritdoc}
     */
    public function getListApi()
    {
        try{
            $response = [
                'name' => 'xxxx',
                'age' => 'xxxx',
                'job' => 'xxx'
            ];
        } catch (\Exception $e) {
            $response=['error' => $e->getMessage()];
        }
        return json_encode($response);
    }
}
