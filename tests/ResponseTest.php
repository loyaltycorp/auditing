<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing;

use LoyaltyCorp\Auditing\Response;

/**
 * @covers \LoyaltyCorp\Auditing\Response
 */
class ResponseTest extends TestCase
{
    /**
     * Test that the response content is what is expected.
     *
     * @return void
     */
    public function testGetContent(): void
    {
        $expected = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $response = new Response($expected);

        self::assertSame($expected, $response->getContent());
        self::assertSame($expected['key1'], $response->get('key1'));
        self::assertNull($response->get('invalid'));
        self::assertTrue($response->hasKey('key2'));
        self::assertFalse($response->hasKey('invalid'));
    }
}
