<?php

namespace hisorange\BrowserDetect\Test\Stages;

use hisorange\BrowserDetect\Exceptions\RuntimeException;
use hisorange\BrowserDetect\Result;
use hisorange\BrowserDetect\Stages\MobileDetect;
use hisorange\BrowserDetect\Test\TestCase;

/**
 * Test the CrawlerDetect stage.
 *
 * @package            hisorange\BrowserDetect\Test\Stages
 * @coversDefaultClass hisorange\BrowserDetect\Stages\MobileDetect
 */
class MobileDetectTest extends TestCase
{
    /**
     * @dataProvider provideAgents
     *
     * @covers ::__invoke()
     * @covers ::<protected>filter()
     *
     * @param string $agent
     * @param array  $changes
     *
     * @throws RuntimeException
     */
    public function testInvoke($agent, $changes)
    {
        $stage  = new MobileDetect;
        $result = new Result($agent);

        $stage($result);

        foreach ($changes as $key => $expected) {
            $this->assertSame($expected, $result->offsetGet($key));
        }
    }

    /**
     * Simple agents to test the crawler stage.
     *
     * @return array
     */
    public function provideAgents()
    {
        return [
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.1; en-ca; LG-P505R Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                [
                    'isMobile' => true,
                    'isTablet' => false,
                ],
            ],
            [
                'Opera/9.80 (S60; SymbOS; Opera Mobi/447; U; en) Presto/2.4.18 Version/10.00',
                [
                    'isMobile' => true,
                    'isTablet' => false,
                ],
            ],
            [
                'NotGonaMatchMe',
                [
                    'isMobile'  => false,
                    'isTablet'  => false,
                    'isDesktop' => false,
                ],
            ],
        ];
    }
}