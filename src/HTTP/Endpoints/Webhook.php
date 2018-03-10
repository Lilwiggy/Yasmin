<?php
/**
 * Yasmin
 * Copyright 2017-2018 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: https://github.com/CharlotteDunois/Yasmin/blob/master/LICENSE
*/

namespace CharlotteDunois\Yasmin\HTTP\Endpoints;

/**
 * Handles the API endpoints "Webhook".
 * @internal
 */
final class Webhook {
    /**
     * Endpoints Webhooks.
     * @var array
     */
    const ENDPOINTS = array(
        'create' => 'channels/%d/webhooks',
        'channels' => 'channels/%d/webhooks',
        'guilds' => 'guilds/%d/webhooks',
        'get' => 'webhooks/%d',
        'getToken' => 'webhooks/%d/%s',
        'modify' => 'webhooks/%d',
        'modifyToken' => 'webhooks/%d/%s',
        'delete' => 'webhooks/%d',
        'deleteToken' => 'webhooks/%d/%s',
        'execute' => 'webhooks/%d/%s'
    );
    
    /**
     * @var \CharlotteDunois\Yasmin\HTTP\APIManager
     */
    protected $api;
    
    /**
     * @param \CharlotteDunois\Yasmin\HTTP\APIManager $api
     */
    function __construct(\CharlotteDunois\Yasmin\HTTP\APIManager $api) {
        $this->api = $api;
    }
    
    function createWebhook(int $channelid, string $name, ?string $avatarBase64 = null, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['create'], $channelid);
        return $this->api->makeRequest('POST', $url, array('auditLogReason' => $reason, 'data' => array('name' => $name, 'avatar' => $avatarBase64)));
    }
    
    function getChannelWebhooks(int $channelid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['channels'], $channelid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function getGuildsWebhooks(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['guilds'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function getWebhook(int $webhookid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['get'], $webhookid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function getWebhookToken(int $webhookid, string $token) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['getToken'], $webhookid, $token);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function modifyWebhook(int $webhookid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['modify'], $webhookid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function modifyWebhookToken(int $webhookid, string $token, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['modifyToken'], $webhookid, $token);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options, 'noAuth' => true));
    }
    
    function deleteWebhook(int $webhookid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['delete'], $webhookid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function deleteWebhookToken(int $webhookid, string $token, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['deleteToken'], $webhookid, $token);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason, 'noAuth' => true));
    }
    
    function executeWebhook(int $webhookid, string $token, array $options, array $files = array(), array $querystring = array()) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['execute'], $webhookid, $token);
        return $this->api->makeRequest('POST', $url, array('data' => $options, 'files' => $files, 'noAuth' => true, 'querystring' => $querystring));
    }
}
