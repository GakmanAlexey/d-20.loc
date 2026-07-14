<?php
namespace Modules\User\Modul\Support;

class Agent
{
    public function takeAgent(){
        return $this->parseUserAgent($this->getAgent());
    }
    public function getAgent(){
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }
    public function parseUserAgent($userAgent){
        $userAgent = strtolower($userAgent);
        
        $device = 'desktop';
        $browser = 'unknown';
        $os = 'unknown';
        
        // Определение устройства
        if (preg_match('/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $userAgent)) {
            $device = 'mobile';
        } elseif (preg_match('/(tablet|ipad|playbook)/i', $userAgent)) {
            $device = 'tablet';
        } elseif (preg_match('/(tv|smarthub|bravia)/i', $userAgent)) {
            $device = 'tv';
        }
        
        // Определение браузера
        if (strpos($userAgent, 'chrome') !== false) {
            $browser = 'chrome';
        } elseif (strpos($userAgent, 'firefox') !== false) {
            $browser = 'firefox';
        } elseif (strpos($userAgent, 'safari') !== false) {
            $browser = 'safari';
        } elseif (strpos($userAgent, 'edge') !== false) {
            $browser = 'edge';
        } elseif (strpos($userAgent, 'msie') !== false || strpos($userAgent, 'trident') !== false) {
            $browser = 'internet explorer';
        } elseif (strpos($userAgent, 'opera') !== false) {
            $browser = 'opera';
        }
        
        // Определение операционной системы
        if (strpos($userAgent, 'windows') !== false) {
            $os = 'windows';
        } elseif (strpos($userAgent, 'mac') !== false) {
            $os = 'mac';
        } elseif (strpos($userAgent, 'linux') !== false) {
            $os = 'linux';
        } elseif (strpos($userAgent, 'android') !== false) {
            $os = 'android';
        } elseif (strpos($userAgent, 'ios') !== false || strpos($userAgent, 'iphone') !== false || strpos($userAgent, 'ipad') !== false) {
            $os = 'ios';
        } elseif (strpos($userAgent, 'freebsd') !== false) {
            $os = 'freebsd';
        }
        
        return [
            'device' => $device,
            'browser' => $browser,
            'os' => $os
        ];
    }
}
