<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Helper\Api;

class Apps extends AbstractApi
{

    // Remove App Installation: DELETE /api/v2/apps/installations/{id}.json
    public const REMOVE_APP_INSTALLATION = '/api/v2/apps/installations/%s.json';

    // Install App: POST /api/v2/apps/installations.json
    public const INSTALL_APP = '/api/v2/apps/installations.json';

    // List App Installations: GET /api/v2/apps/installations.json
    public const LIST_APP_INSTALLATIONS = '/api/v2/apps/installations.json';

    // List Owned Apps: GET /api/v2/apps/owned.json
    public const LIST_OWNED_APPS = '/api/v2/apps/owned.json';

    // Delete App: DELETE /api/v2/apps/{id}.json
    public const DELETE_APP = '/api/v2/apps/%s.json';

    // Update App: UPDATE /api/v2/apps/installations/{id}.json
    public const UPDATE_APP = '/api/v2/apps/installations/%s.json';

    /**
     * Remove App Installation

     * @param mixed $id
     * @return bool
     */
    public function removeAppInstallation($id)
    {
        $endpoint = sprintf(self::REMOVE_APP_INSTALLATION, $id);
        $response = $this->delete($endpoint);
        $data = json_decode($response, true);
        return isset($data['error']) ? false : true;
    }

    /**
     * Installs an app in the account.
     *
     * @param mixed $appId
     * @param array $setting
     * @return array
     */
    public function installApp($appId, $setting)
    {
        $params = json_encode(['app_id' => $appId, 'settings' => $setting]);
        $response = $this->post(self::INSTALL_APP, $params);
        $data = json_decode($response, true);
        return isset($data['id']) ? $data['id'] : null;
    }

    /**
     * Lists apps owned by the current account.
     *
     * @return array
     */
    public function listOwnedApps()
    {
        $response = $this->get(self::LIST_OWNED_APPS);

        $data = json_decode($response, true);

        return isset($data['apps']) ? $data['apps'] : [];
    }

    /**
     * Lists all app installations in the account. The enabled property indicates whether or not the installed app is active in the product.
     *
     * @return array
     */
    public function listAppInstallations()
    {
        $response = $this->get(self::LIST_APP_INSTALLATIONS);
        $data = json_decode($response, true);
        return isset($data['installations']) ? $data['installations'] : [];
    }

    /**
     * Update App

     * @param mixed $appId
     * @param mixed $setting
     * @return null
     */
    public function updateApp($appId, $setting)
    {
        $endpoint = sprintf(self::UPDATE_APP, $appId);
        $params = json_encode(['settings' => $setting]);
        $response = $this->put($endpoint, $params);
        $data = json_decode($response, true);
        return isset($data['id']) ? $data['id'] : null;
    }

    /**
     * Deletes the specified app and removes it from the Manage pages in Zendesk Support.
     *
     * @param mixed $id
     * @return array
     */
    public function deleteApp($id)
    {
        $endpoint = sprintf(self::DELETE_APP, $id);
        $response = $this->delete($endpoint);
        return [];
    }
}
