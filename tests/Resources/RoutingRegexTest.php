<?php

namespace Tests\Resources;

use Symfony\Component\Yaml\Yaml;

class RoutingRegexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $path;

    protected $configFile = 'routing.yml';

    protected function setUp()
    {
        parent::setUp();

        $this->path = __DIR__ . '/../../src/Stefanius/LowerCaseRedirectorBundle/Resources/config';
    }

    /**
     * See if the configfile and Resources path are readable.
     */
    public function testConfigFileAccess()
    {
        $this->assertNotEmpty($this->path, 'The path string has to be filled');
        $this->assertNotEmpty($this->configFile, 'The configFile string has to be filled');

        $this->assertTrue(is_string($this->path) && is_scalar($this->path), 'The path has to be a string.');
        $this->assertNotEmpty(is_string($this->configFile) && is_scalar($this->configFile), 'The configFile has to be a string.');

        $this->assertNotFalse(realpath($this->path), 'The config path seems to be non-existed or non-accessible.');

        $fullPath = $this->getFullPath();

        $this->assertTrue(file_exists($fullPath), 'The full path and filename are non-existing. (' . $fullPath . ')');
    }

    /**
     * Check if some key's exists in the config.
     *
     * @depends testConfigFileAccess
     */
    public function testConfigFileData()
    {
        $config = $this->getConfigData();

        $this->assertArrayHasKey('redirect_to_lowercase', $config);
        $this->assertArrayHasKey('requirements', $config['redirect_to_lowercase']);
        $this->assertArrayHasKey('url', $config['redirect_to_lowercase']['requirements']);
    }

    /**
     * Test if the regex matches the correct routes.
     *
     * @param string $input
     * @param bool   $shouldMatch
     *
     * @depends testConfigFileData
     * @dataProvider testRouteMatchingRegexDataProvider
     */
    public function testRouteMatchingRegex($input, $shouldMatch)
    {
        $regex = $this->getRouteRegex();

        if ($shouldMatch) {
            $this->assertRegExp($regex, $input);
        } else {
            $this->assertNotRegExp($regex, $input);
        }
    }

    /**
     * @return array
     */
    public function testRouteMatchingRegexDataProvider()
    {
        return [
            ['aaa', false],
            ['AAA', true],
            ['Aaa', true],
            ['AaA', true],
            ['bBa', true],
            ['bBa1', true],
            ['1bBa1', true],
            ['1b3Ba1', true],
            ['1b3aa1', false],
            ['http://www.my-domain.dev/my-lovely-page', false],
            ['http://www.my-domain.dev/my-lovely-PAGE', true],
            ['http://www.my-domain.dev/my-lovely-PAGE-123546', true],
            ['http://www.my-domain.dev/111-my-lovely-PAGE-123546', true],
            ['http://www.my-domain.dev/111-my_lovely-PAGE-123546', true],
            ['http://www.my-domain.dev/111-PAGE-123546', true],
            ['http://www.my-domain.dev/111-false-123546', false],
            ['http://www.my-domain.dev/a-false-123546', false],
            ['http://www.my-domain.dev/186', false],
            ['http://www.my-domain.dev/AAAAAAAAAAAAAA', true],
            ['http://www.my-domain.dev/AAAAAAA3AAAAAAA', true],
            ['http://www.my-domain.dev/Nieuws', true],
            ['http://www.my-domain.dev/NieuwS', true],
            ['http://www.my-domain.dev/NiEuwS', true],
            ['http://www.my-domain.dev/Nieuws1', true],
            ['http://www.my-domain.dev/1NieuwS', true],
            ['http://www.my-domain.dev/NiEuwS1', true],
            ['http://www.my-domain.dev/NiEuwS1/UPPERCASE', true],
            ['http://www.my-domain.dev/NiEuwS1/lowercase/wserwete6344532eefw3r', true],
            ['http://www.my-domain.dev/nieuws/lowercase/wserwete6344532eefw3r', false],
        ];
    }

    /**
     * Gets the full path and filename of the config file.
     * @return string
     */
    protected function getFullPath()
    {
        return realpath($this->path) . '/' . $this->configFile;
    }

    /**
     * Get the config file contents as an array.
     *
     * @return array
     */
    protected function getConfigData()
    {
        return Yaml::parse($this->getFullPath());
    }

    /**
     * Get the regex used to match the route.
     *
     * @return mixed
     */
    protected function getRouteRegex()
    {
        $config = $this->getConfigData();

        return '/' . $config['redirect_to_lowercase']['requirements']['url'] . '/';
    }
}
