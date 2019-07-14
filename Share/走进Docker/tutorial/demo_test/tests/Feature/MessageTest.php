<?php
/**
 * Created by AlicFeng at 2019-07-14 13:49
 */

namespace Tests\Feature;


use Tests\TestCase;

class MessageTest extends TestCase
{
    public function testMessage()
    {
        $uri = 'api/message';
        $this->getJson($uri)
            ->assertStatus(200)
            ->assertJsonStructure(
                ['code', 'message', 'data']
            )
            ->assertJson(
                [
                    'code'    => 1000,
                    'message' => 'success',
                    'data'    => [

                        'name' => 'AlicFeng',
                        'age'  => 24,
                        'id'   => [
                            'type'   => 1,
                            'number' => '4417011888888888'
                        ]

                    ]
                ]
            );
    }

    public function testTrue(){
        $this->assertTrue(true);
    }
}
