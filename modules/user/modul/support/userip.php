<?php
namespace Modules\User\Modul\Support;

class Userip
{
    public function takeIP(){
         $ipKeys = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {

            if (!empty($_SERVER[$key] ?? null)) {

                $ips = explode(',', (string)$_SERVER[$key]);

                foreach ($ips as $ip) {

                    $ip = trim($ip);

                    if (filter_var(
                        $ip,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                    )) {
                        return $ip;
                    }

                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '';
    }

    
}
