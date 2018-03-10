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
 * Handles the API endpoints "Guild".
 * @internal
 */
final class Guild {
    /**
     * Endpoints Guilds.
     * @var array
     */
    const ENDPOINTS = array(
        'get' => 'guilds/%d',
        'create' => 'guilds',
        'modify' => 'guilds/%d',
        'delete' => 'guilds/%d',
        'channels' => array(
            'list' => 'guilds/%d/channels',
            'create' => 'guilds/%d/channels',
            'modifyPositions' => 'guilds/%d/channels'
        ),
        'members' => array(
            'get' => 'guilds/%d/members/%d',
            'list' => 'guilds/%d/members',
            'add' => 'guilds/%d/members/%d',
            'modify' => 'guilds/%d/members/%d',
            'modifyCurrentNick' => 'guilds/%d/members/@me/nick',
            'addRole' => 'guilds/%d/members/%d/roles/%d',
            'removeRole' => 'guilds/%d/members/%d/roles/%d',
            'remove' => 'guilds/%d/members/%d'
        ),
        'bans' => array(
            'list' => 'guilds/%d/bans',
            'create' => 'guilds/%d/bans/%d',
            'remove' => 'guilds/%d/bans/%d'
        ),
        'roles' => array(
            'list' => 'guilds/%d/roles',
            'create' => 'guilds/%d/roles',
            'modifyPositions' => 'guilds/%d/roles',
            'modify' => 'guilds/%d/roles/%d',
            'delete' => 'guilds/%d/roles/%d'
        ),
        'prune' => array(
            'count' => 'guilds/%d/prune',
            'begin' => 'guilds/%d/prune'
        ),
        'voice' => array(
            'regions' => 'guilds/%d/regions'
        ),
        'invites' => array(
            'list' => 'guilds/%d/invites'
        ),
        'integrations' => array(
            'list' => 'guilds/%d/integrations',
            'create' => 'guilds/%d/integrations',
            'modify' => 'guilds/%d/integrations/%d',
            'delete' => 'guilds/%d/integrations/%d',
            'sync' => 'guilds/%d/integrations/%d'
        ),
        'embed' => array(
            'get' => 'guilds/%d/embed',
            'modify' => 'guilds/%d/embed'
        ),
        'audit-logs' => 'guilds/%d/audit-logs',
        'vanity-url' => 'guilds/%d/vanity-url'
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
    
    function getGuild(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['get'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createGuild(array $options) {
        $url = self::ENDPOINTS['create'];
        return $this->api->makeRequest('POST', $url, array('data' => $options));
    }
    
    function modifyGuild(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['modify'], $guildid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function deleteGuild(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['delete'], $guildid);
        return $this->api->makeRequest('DELETE', $url, array());
    }
    
    function getGuildChannels(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['channels']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createGuildChannel(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['channels']['create'], $guildid);
        return $this->api->makeRequest('POST', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function modifyGuildChannelPositions(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['channels']['modifyPositions'], $guildid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function getGuildMember(int $guildid, int $userid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['get'], $guildid, $userid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function listGuildMembers(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function addGuildMember(int $guildid, int $userid, array $options) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['add'], $guildid, $userid);
        return $this->api->makeRequest('PUT', $url, array('data' => $options));
    }
    
    function modifyGuildMember(int $guildid, int $userid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['modify'], $guildid, $userid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function removeGuildMember(int $guildid, int $userid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['remove'], $guildid, $userid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function modifyCurrentNick(int $guildid, int $userid, string $nick) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['modifyCurrentNick'], $guildid, $userid);
        return $this->api->makeRequest('PATCH', $url, array('data' => array('nick' => $nick)));
    }
    
    function addGuildMemberRole(int $guildid, int $userid, int $roleid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['addRole'], $guildid, $userid, $roleid);
        return $this->api->makeRequest('PUT', $url, array('auditLogReason' => $reason));
    }
    
    function removeGuildMemberRole(int $guildid, int $userid, int $roleid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['members']['removeRole'], $guildid, $userid, $roleid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function getGuildBans(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['bans']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createGuildBan(int $guildid, int $userid, int $daysDeleteMessages = 0, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['bans']['create'], $guildid, $userid);
        
        $qs = array('delete-message-days' => $daysDeleteMessages);
        if(!empty($reason)) {
            $qs['reason'] = $reason;
        }
        
        return $this->api->makeRequest('PUT', $url, array('auditLogReason' => $reason, 'querystring' => $qs));
    }
    
    function removeGuildBan(int $guildid, int $userid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['bans']['remove'], $guildid, $userid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function getGuildRoles(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['roles']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createGuildRole(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['roles']['create'], $guildid);
        return $this->api->makeRequest('POST', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function modifyGuildRolePositions(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['roles']['modifyPositions'], $guildid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function modifyGuildRole(int $guildid, int $roleid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['roles']['modify'], $guildid, $roleid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function deleteGuildRole(int $guildid, int $roleid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['roles']['delete'], $guildid, $roleid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function getGuildPruneCount(int $guildid, int $days) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['prune']['count'], $guildid);
        return $this->api->makeRequest('GET', $url, array('querystring' => array('days' => $days)));
    }
    
    function beginGuildPrune(int $guildid, int $days, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['prune']['begin'], $guildid);
        return $this->api->makeRequest('POST', $url, array('auditLogReason' => $reason, 'querystring' => array('days' => $days)));
    }
    
    function getGuildVoiceRegions(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['voice']['regions'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function getGuildInvites(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['invites']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function getGuildIntegrations(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['integrations']['list'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function createGuildIntegration(int $guildid, array $options) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['integrations']['create'], $guildid);
        return $this->api->makeRequest('POST', $url, array('data' => $options));
    }
    
    function modifyGuildIntegration(int $guildid, int $integrationid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['integrations']['modify'], $guildid, $integrationid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function deleteGuildIntegration(int $guildid, int $integrationid, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['integrations']['delete'], $guildid, $integrationid);
        return $this->api->makeRequest('DELETE', $url, array('auditLogReason' => $reason));
    }
    
    function syncGuildIntegration(int $guildid, int $integrationid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['integrations']['sync'], $guildid, $integrationid);
        return $this->api->makeRequest('POST', $url, array());
    }
    
    function getGuildEmbed(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['embed']['get'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
    
    function modifyGuildEmbed(int $guildid, array $options, string $reason = '') {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['embed']['modify'], $guildid);
        return $this->api->makeRequest('PATCH', $url, array('auditLogReason' => $reason, 'data' => $options));
    }
    
    function getGuildAuditLog(int $guildid, array $query) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['audit-logs'], $guildid);
        return $this->api->makeRequest('GET', $url, array('querystring' => $query));
    }
    
    function getGuildVanityURL(int $guildid) {
        $url = \CharlotteDunois\Yasmin\HTTP\APIEndpoints::format(self::ENDPOINTS['vanity-url'], $guildid);
        return $this->api->makeRequest('GET', $url, array());
    }
}
