<?php
/**
 * Yasmin
 * Copyright 2017-2018 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: https://github.com/CharlotteDunois/Yasmin/blob/master/LICENSE
*/

namespace CharlotteDunois\Yasmin\WebSocket\Events;

/**
 * WS Event
 * @see https://discordapp.com/developers/docs/topics/gateway#channel-update
 * @internal
 */
class ChannelUpdate {
    protected $client;
    protected $clones = false;
    
    function __construct(\CharlotteDunois\Yasmin\Client $client) {
        $this->client = $client;
        
        $clones = $this->client->getOption('disableClones', array());
        $this->clones = !($clones === true || \in_array('channelUpdate', (array) $clones));
    }
    
    function handle(array $data) {
        $channel = $this->client->channels->get($data['id']);
        if($channel) {
            $oldChannel = null;
            if($this->clones) {
                $oldChannel = clone $channel;
            }
            
            $channel->_patch($data);
            
            $prom = array();
            if($channel instanceof \CharlotteDunois\Yasmin\Interfaces\GuildChannelInterface) {
                foreach($channel->permissionOverwrites as $overwrite) {
                    if($overwrite->type === 'member' && $overwrite->target === null) {
                        $prom[] = $channel->guild->fetchMember($overwrite->id)->then(function (\CharlotteDunois\Yasmin\Models\GuildMember $member) use ($overwrite) {
                            $overwrite->_patch(array('target' => $member));
                        }, function () {
                            // Do nothing
                        });
                    }
                }
            }
            
            \React\Promise\all($prom)->otherwise(function () {
                return null;
            })->then(function () use ($channel, $oldChannel) {
                $this->client->emit('channelUpdate', $channel, $oldChannel);
            })->done(null, array($this->client, 'handlePromiseRejection'));
        }
    }
}
