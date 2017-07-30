<?php
namespace EzSwoole\Core\Protocol;

interface ProtocolContract {
    static function input ($buffer);
    static function decode ($packet);
    static function encode ($data);
}
