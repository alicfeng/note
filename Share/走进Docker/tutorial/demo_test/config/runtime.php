<?php
/**
 * Created by PhpStorm   User: AlicFeng   DateTime: 19-3-20 上午11:28
 */

return [
    // open request message into logfile[Recommend true]
    'trace'        => true,

    // open runtime analysis functions
    'status'       => false,

    // Log configure | Available Settings: "single", "daily"
    'log'          => 'daily',

    // PHP memory_limit in CLI model
    'memory_limit' => '128M',

    // except for same request not to writing log by routerName
    'log_except'   => [

    ]
];
