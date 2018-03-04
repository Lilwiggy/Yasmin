<?php
/**
 * Yasmin
 * Copyright 2017-2018 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: https://github.com/CharlotteDunois/Yasmin/blob/master/LICENSE
*/

namespace CharlotteDunois\Yasmin\Models;

/**
 * Base class for all storages.
 */
class Storage extends \CharlotteDunois\Yasmin\Utils\Collection
    implements \CharlotteDunois\Yasmin\Interfaces\StorageInterface {
    
    protected $client;
    
    /**
     * @internal
     */
    function __construct(\CharlotteDunois\Yasmin\Client $client, array $data = null) {
        parent::__construct($data);
        $this->client = $client;
    }
    
    /**
     * @inheritDoc
     *
     * @throws \RuntimeException
     * @internal
     */
    function __get($name) {
        if(\property_exists($this, $name)) {
            return $this->$name;
        }
        
        throw new \RuntimeException('Unknown property '.\get_class($this).'::$'.$name);
    }
    
    /**
     * @inheritDoc
     */
    function has($key) {
        if(\is_array($key) || \is_object($key)) {
            return false;
        }
        
        return parent::get(((int) $key));
    }
    
    /**
     * @inheritDoc
     */
    function get($key) {
        if(\is_array($key) || \is_object($key)) {
            return null;
        }
        
        return parent::get(((int) $key));
    }
    
    /**
     * @inheritDoc
     */
    function set($key, $val) {
        if(\is_array($key) || \is_object($key)) {
            throw new \InvalidArgumentException('Key can not be an array or object');
        }
        
        return parent::set(((int) $key), $val);
    }
}
