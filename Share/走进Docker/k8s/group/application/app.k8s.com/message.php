<?php
/**
 * Created by AlicFeng at 2019-07-14 22:58
 */
echo json_encode(
    [
        'code'    => 1000,
        'message' => 'success',
        'data'    => [
            'version'  => 'v2.0.0',
            'name'     => 'samego',
            'time'     => time(),
            'hostname' => gethostname(),
        ]
    ]
);
