<?php
/**
 * Yasmin
 * Copyright 2017-2018 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: https://github.com/CharlotteDunois/Yasmin/blob/master/LICENSE
*/

namespace CharlotteDunois\Yasmin;

/**
 * The webhook client.
 *
 * @inheritDoc
 */
class WebhookClient extends \CharlotteDunois\Yasmin\Models\Webhook {
    /**
     * Constructor.
     * @param string                               $id       The webhook ID.
     * @param string                               $token    The webhook token.
     * @param \React\EventLoop\LoopInterface|null  $loop     The ReactPHP Event Loop.
     * @param array                                $options  Any Client Options.
     */
    function __construct(string $id, string $token, ?\React\EventLoop\LoopInterface $loop = null, array $options = array()) {
        $options['internal.ws.disable'] = true;
        
        $client = new \CharlotteDunois\Yasmin\Client($loop, $options);
        parent::__construct($client, array(
            'id' => $id,
            'token' => $token
        ));
    }
}
