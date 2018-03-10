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
 * Handles the API endpoints "Channel".
 * @internal
 */
final class Channel {
    /**
     * Endpoints Channels.
     * @var array
     */
    const ENDPOINTS = array(
        'get' => 'channels/%d',
        'modify' => 'channels/%d',
        'delete' => 'channels/%d',
        'messages' => array(
            'list' => 'channels/%d/messages',
            'get' => 'channels/%d/messages/%d',
            'create' => 'channels/%d/messages',
            'reactions' => array(
                'create' => 'channels/%d/messages/%d/reactions/%s/@me',
                'delete' => 'channels/%d/messages/%d/reactions/%s/%s',
                'get' => 'channels/%d/messages/%d/reactions/%d',
                'deleteAll' => 'channels/%d/messages/%d/reactions',
            ),
            'edit' => 'channels/%d/messages/%d',
            'delete' => 'channels/%d/messages/%d',
            'bulkDelete' => 'channels/%d/messages/bulk-delete'
        ),
        'permissions' => array(
            'edit' => 'channels/%d/permissions/%d',
            'delete' => 'channels/%d/permissions/%d'
        ),
        'invites' => array(
            'list' => 'channels/%d/invites',
            'create' => 'channels/%d/invites'
        ),
        'typing' => 'channels/%d/typing',
        'pins' => array(
            'list' => 'channels/%d/pins',
            'add' => 'channels/%d/pins/%d',
            'delete' => 'channels/%d/pins/%d'
        ),
        'groupDM' => array(
            'add' => 'channels/%d/recipients/%d',
            'remove' => 'channels/%d/recipients/%d'
        )
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
    
    function getChannel(int $channelid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['get'], $channelid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function modifyChannel(int $channelid, array $data, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['modify'], $channelid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $data));
    }
    
    function deleteChannel(int $channelid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['delete'], $channelid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function getChannelMessages(int $channelid, array $options = array()) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['list'], $channelid);
        return $this->api->makeRequest('GET', $url, array('querystring' => $options));
    }
    
    function getChannelMessage(int $channelid, int $messageid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['get'], $channelid, $messageid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createMessage(int $channelid, array $options, array $files = array()) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['create'], $channelid);
        return $this->api->makeRequest('POST', $url, array('data' => $options, 'files' => $files));
    }
    
    function editMessage(int $channelid, int $messageid, array $options) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['edit'], $channelid, $messageid);
        return $this->api->makeRequest('PATCH', $url, array('data' => $options));
    }
    
    function deleteMessage(int $channelid, int $messageid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['delete'], $channelid, $messageid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function bulkDeleteMessages(int $channelid, array $snowflakes, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['bulkDelete'], $channelid);
        return $this->api->makeRequest('POST', $url, array('auditLogReason' => $reason, 'data' => array('messages' => $snowflakes)));
    }
    
    function createMessageReaction(int $channelid, int $messageid, string $emoji) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['reactions']['create'], $channelid, $messageid, $emoji);
        return $this->api->makeRequest('PUT', $url, array());
    }
    
    function deleteMessageReaction(int $channelid, int $messageid, string $emoji, string $user) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['reactions']['delete'], $channelid, $messageid, $emoji, $user);
        return $this->api->makeRequest('DELETE', $url, array());
    }
    
    function getMessageReactions(int $channelid, int $messageid, string $emoji, array $querystring = array()) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['reactions']['get'], $channelid, $messageid, $emoji);
        return $this->api->makeRequest('GET', $url, array('querystring' => $querystring));
    }
    
    function deleteMessageReactions(int $channelid, int $messageid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['messages']['reactions']['deleteAll'], $channelid, $messageid);
        return $this->api->makeRequest('DELETE', $url, array());
    }
    
    function editChannelPermissions(int $channelid, int $overwriteid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['permissions']['edit'], $channelid, $overwriteid);
        return $this->api->makeRequest('PUT', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function deleteChannelPermission(int $channelid, int $overwriteid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['permissions']['delete'], $channelid, $overwriteid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function getChannelInvites(int $channelid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['invites']['list'], $channelid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createChannelInvite(int $channelid, array $options = array()) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['invites']['create'], $channelid);
        return $this->api->makeRequest('GET', $url, array('data' => $options));
    }
    
    function triggerChannelTyping(int $channelid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['typing'], $channelid);
        return $this->api->makeRequest('POST', $url, array());
    }
    
    function getPinnedChannelMessages(int $channelid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['pins']['list'], $channelid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function pinChannelMessage(int $channelid, int $messageid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['pins']['add'], $channelid, $messageid);
        return $this->api->makeRequest('PUT', $url, array());
    }
    
    function unpinChannelMessage(int $channelid, int $messageid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['pins']['delete'], $channelid, $messageid);
        return $this->api->makeRequest('DELETE', $url, array());
    }
    
    function groupDMAddRecipient(int $channelid, int $userid, string $accessToken, string $nick) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['groupDM']['add'], $channelid, $userid);
        return $this->api->makeRequest('PUT', $url, array('data' => array('access_token' => $accessToken, 'nick' => $nick)));
    }
    
    function groupDMRemoveRecipient(int $channelid, int $userid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['groupDM']['remove'], $channelid, $userid);
        return $this->api->makeRequest('DELETE', $url, array());
    }
}
