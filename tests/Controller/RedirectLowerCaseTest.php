<?php

namespace Tests\Controller;

use Stefanius\LowerCaseRedirectorBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;

class RedirectLowerCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RedirectController
     */
    protected $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new RedirectController();
    }


    /**
     * Test is an url is redirected to an lowercased version.
     *
     * @param string $url
     * @param string $expectedUrl
     *
     * @dataProvider provider
     */
    public function testUrl($url, $expectedUrl)
    {
        $request  = Request::create($url);

        $response = $this->controller->lowerCaseAction($request);

        $this->assertEquals($expectedUrl, $response->getTargetUrl());
        $this->assertEquals(($url === $expectedUrl), ($url === $response->getTargetUrl()), 'The url and the target-url are exactly the same.');
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ['http://my-domain.ext/my-super-duper-page', 'http://my-domain.ext/my-super-duper-page'],
            ['http://my-domain.ext/my-SUPER-duper-page', 'http://my-domain.ext/my-super-duper-page'],
        ];
    }

}
