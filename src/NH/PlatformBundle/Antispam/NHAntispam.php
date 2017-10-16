<?php
//src/NH/PlatformBundle/Antispam/NHAntispam.php

namespace NH\PlatformBundle\Antispam;

class NHAntispam
{
    public function isSpam($text){
        return strlen($text) < 50;
    }
}