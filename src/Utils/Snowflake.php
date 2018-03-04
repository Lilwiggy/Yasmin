<?php
/**
 * Yasmin
 * Copyright 2017-2018 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: https://github.com/CharlotteDunois/Yasmin/blob/master/LICENSE
*/

namespace CharlotteDunois\Yasmin\Utils;

/**
 * Represents a Snowflake.
 * @property float      $timestamp  The timestamp of when this snowflake got generated. In seconds with microseconds.
 * @property int        $workerID   The ID of the worker which generated this snowflake.
 * @property int        $processID  The ID of the process which generated this snowflake.
 * @property int        $increment  The increment index of the snowflake.
 * @property string     $binary     The binary representation of this snowflake.
 * @property \DateTime  $date       A DateTime instance of the timestamp.
 */
class Snowflake {
    /**
     * Time since UNIX epoch to Discord epoch.
     * @var int
     */
    const EPOCH = 1420070400;
    
    protected static $incrementIndex = 0;
    
    protected $timestamp;
    protected $workerID;
    protected $processID;
    protected $increment;
    protected $binary;
    
    /**
     * Constructor.
     * @param string|int  $snowflake
     */
    function __construct($snowflake) {
        $snowflake = (int) $snowflake;
        $this->binary = \str_pad(\decbin($snowflake), 64, 0, \STR_PAD_LEFT);

        $time = (string) ($snowflake >> 22);

        $this->timestamp = (float) ((((int) \substr($time, 0, -3)) + self::EPOCH).'.'.\substr($time, -3));
        $this->workerID = ($snowflake & 0x3E0000) >> 17;
        $this->processID = ($snowflake & 0x1F000) >> 12;
        $this->increment = ($snowflake & 0xFFF);
    }
    
    /**
     * @throws \Exception
     * @internal
     */
    function __get($name) {
        switch($name) {
            case 'timestamp':
            case 'workerID':
            case 'processID':
            case 'increment':
            case 'binary':
                return $this->$name;
            break;
            case 'date':
                return \CharlotteDunois\Yasmin\Utils\DataHelpers::makeDateTime(((int) $this->timestamp));
            break;
        }
        
        throw new \Exception('Undefined property: '.(self::class).'::$'.$name);
    }
    
    /**
     * Deconstruct a snowflake.
     * @param string|int  $snowflake
     * @return Snowflake
     */
    static function deconstruct($snowflake) {
        return (new self($snowflake));
    }
    
    /**
     * Generates a new snowflake.
     * @param int  $workerID   Valid values are in the range of 0-31.
     * @param int  $processID  Valid values are in the range of 0-31.
     * @return string
     */
    static function generate(int $workerID = 1, int $processID = 0) {
        if($workerID > 31 || $workerID < 0) {
            throw new \InvalidArgumentException('Worker ID is out of range');
        }
        
        if($processID > 31 || $processID < 0) {
            throw new \InvalidArgumentException('Process ID is out of range');
        }
        
        if(self::$incrementIndex >= 4095) {
            self::$incrementIndex = 0;
        }
        
        $workerID = \str_pad(\decbin($workerID), 5, 0, \STR_PAD_LEFT);
        $processID = \str_pad(\decbin($processID), 5, 0, \STR_PAD_LEFT);
        
        $mtime = \explode('.', ((string) \microtime(true)));
        $time = ((string) (((int) $mtime[0]) - self::EPOCH)).\substr($mtime[1], 0, 3);
        
        $binary = \str_pad(\decbin(((int) $time)), 42, 0, \STR_PAD_LEFT).$workerID.$processID.\str_pad(\decbin((self::$incrementIndex++)), 12, 0, \STR_PAD_LEFT);
        return ((string) \bindec($binary));
    }
    
    /**
     * This method merely determines whether a given snowflake is considered valid, but not if it exists.
     * @return bool
     */
    function isValid() {
        return ($this->timestamp >= self::EPOCH && $this->timestamp < \microtime(true) && $this->workerID >= 0 && $this->workerID < 32 && $this->processID >= 0 && $this->processID < 32 && $this->increment >= 0 && $this->increment < 4096);
    }
}
