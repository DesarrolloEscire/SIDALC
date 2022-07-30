<?php

/**
 * Proxy service unit test.
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2010.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  Tests
 * @author   David Maus <maus@hab.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development
 */
namespace VuFindTest;

use VuFindHttp\HttpService as Service;

/**
 * Proxy service unit test.
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2010.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  Tests
 * @author   David Maus <maus@hab.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development
 */
class ProxyServiceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Example representations of localhost.
     *
     * @var array
     */
    protected $local = ['ipv4 localhost' => 'http://localhost',
                        'ipv4 loopback'  => 'http://127.0.0.1',
                        'ipv6 loopback'  => 'http://[::1]'];

    /**
     * Example custom regular expression for extended local server detection.
     *
     * @var string
     */
    protected $localAddressesRegEx = '@^(localhost|127(\.\d+){3}|\[::1\]|([a-z])+\.internal)@';

    /**
     * Test GET request with associative array.
     *
     * @return void
     */
    public function testGetWithAssocParams()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld?foo=bar&bar%5B0%5D=baz')
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->get('http://example.tld', ['foo' => 'bar', 'bar' => ['baz']]);
    }

    /**
     * Test GET request with parameter pairs.
     *
     * @return void
     */
    public function testGetWithParamPairs()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld?foo=bar&bar=baz&bar=bar')
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->get('http://example.tld', ['foo=bar', 'bar=baz', 'bar=bar']);
    }

    /**
     * Test GET request appends query part.
     *
     * @return void
     */
    public function testGetAppendsQueryPart()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld?foo=bar&bar=baz')
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->get('http://example.tld?foo=bar', ['bar=baz']);
    }

    /**
     * Test GET request appends headers.
     *
     * @return void
     */
    public function testGetAppendsHeaders()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld?foo=bar')
                ),
                $this->equalTo('1.1'),
                $this->equalTo(
                    ['Host' => 'example.tld', 'Connection' => 'close', 'Accept-Encoding' => 'gzip, deflate','User-Agent' => 'Laminas_Http_Client', 'Content-Type' => 'application/json', 'Accept' => 'application/json']
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->get('http://example.tld', ['foo=bar'], 'test', ["Content-type: application/json", "Accept: application/json"]);
    }

    /**
     * Test POST request appends headers.
     *
     * @return void
     */
    public function testPostAppendsHeaders()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld')
                ),
                $this->equalTo('1.1'),
                $this->equalTo(
                    ['Host' => 'example.tld', 'Connection' => 'close', 'Accept-Encoding' => 'gzip, deflate','User-Agent' => 'Laminas_Http_Client', 'Content-Type' => 'application/json', 'Accept' => 'application/json', 'Content-Length' => '5']
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->post('http://example.tld', 'dummy', 'application/json', null, ['Accept: application/json']);
    }

    /**
     * Test POST request of form data.
     *
     * @return void
     */
    public function testPostForm()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld', 'foo=bar&bar=baz')
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->postForm('http://example.tld', ['foo=bar']);
    }

    /**
     * Test POST request.with empty body
     *
     * @return void
     */
    public function testSendPostRequestEmptyBody()
    {
        $service = new Service();
        $adapter = $this->getMockBuilder('Laminas\Http\Client\Adapter\Test')
            ->setMethods(['write'])->getMock();
        $adapter->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo(
                    new \Laminas\Uri\Http('http://example.tld')
                )
            );
        $service->setDefaultAdapter($adapter);
        $service->post('http://example.tld');
    }

    /**
     * Test proxify.
     *
     * @return void
     */
    public function testProxify()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666'
            ]
        );
        $client = new \Laminas\Http\Client('http://example.tld:8080');
        $client = $service->proxify($client);
        $adapter = $client->getAdapter();
        $this->assertInstanceOf('Laminas\Http\Client\Adapter\Proxy', $adapter);
        $config = $adapter->getConfig();
        $this->assertEquals('localhost', $config['proxy_host']);
        $this->assertEquals('666', $config['proxy_port']);
    }

    /**
     * Test proxify with a Curl adapter.
     *
     * @return void
     */
    public function testProxifyCurlAdapter()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666'
            ]
        );
        $service->setDefaultAdapter(new \Laminas\Http\Client\Adapter\Curl());
        $client = new \Laminas\Http\Client('http://example.tld:8080');
        $client = $service->proxify($client);
        $adapter = $client->getAdapter();
        $this->assertInstanceOf('Laminas\Http\Client\Adapter\Curl', $adapter);
        $config = $adapter->getConfig();
        $this->assertEquals('localhost', $config['curloptions'][CURLOPT_PROXY]);
        $this->assertEquals('666', $config['curloptions'][CURLOPT_PROXYPORT]);
    }

    /**
     * Test proxify w/SOCKS5 option.
     *
     * @return void
     */
    public function testProxifySocks5()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666',
                'proxy_type' => 'socks5',
            ]
        );
        $client = new \Laminas\Http\Client('http://example.tld:8080');
        $client = $service->proxify($client);
        $adapter = $client->getAdapter();
        $this->assertInstanceOf('Laminas\Http\Client\Adapter\Curl', $adapter);
        $config = $adapter->getConfig();
        $this->assertEquals('localhost', $config['curloptions'][CURLOPT_PROXY]);
        $this->assertEquals('666', $config['curloptions'][CURLOPT_PROXYPORT]);
        $this->assertEquals(
            CURLPROXY_SOCKS5, $config['curloptions'][CURLOPT_PROXYTYPE]
        );
        $this->assertNotContains(CURLOPT_FOLLOWLOCATION, $config['curloptions']);
    }

    /**
     * Test no proxify with local address.
     *
     * @return void
     */
    public function testNoProxifyLocal()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666'
            ]
        );
        foreach ($this->local as $name => $address) {
            $client = new \Laminas\Http\Client($address);
            $client->setAdapter(new \Laminas\Http\Client\Adapter\Test());
            $client = $service->proxify($client);
            $this->assertInstanceOf(
                'Laminas\Http\Client\Adapter\Test',
                $client->getAdapter(),
                sprintf('Failed to proxify %s: %s', $name, $address)
            );
        }
    }

    /**
     * Test that a local custom address does not get proxified when correctly
     * configured.
     *
     * @return void
     */
    public function testNoProxifyLocalAddress()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666'
            ],
            [],
            [
                'localAddressesRegEx' => $this->localAddressesRegEx
            ]
        );

        $localAddress = 'http://solr.internal';
        $client = new \Laminas\Http\Client($localAddress);
        $client->setAdapter(new \Laminas\Http\Client\Adapter\Test());
        $client = $service->proxify($client);
        $this->assertInstanceOf(
            'Laminas\Http\Client\Adapter\Test',
            $client->getAdapter(),
            sprintf('Failed to proxify %s', $localAddress)
        );
    }

    /**
     * Test that an external address still gets proxified when a custom local
     * regular expression is configured.
     *
     * @return void
     */
    public function testProxifyExternalAddress()
    {
        $service = new Service(
            [
                'proxy_host' => 'localhost',
                'proxy_port' => '666'
            ],
            [],
            [
                'localAddressesRegEx' => $this->localAddressesRegEx
            ]
        );

        $externalAddress = 'http://solr.external';
        $client = new \Laminas\Http\Client($externalAddress);
        $client->setAdapter(new \Laminas\Http\Client\Adapter\Test());
        $client = $service->proxify($client);
        $this->assertInstanceOf(
            'Laminas\Http\Client\Adapter\Proxy',
            $client->getAdapter(),
            sprintf('Failed to proxify %s', $externalAddress)
        );
    }

    /**
     * Test for runtime exception.
     *
     * @expectedException \VuFindHttp\Exception\RuntimeException
     *
     * @return void
     */
    public function testRuntimeException()
    {
        $service = new Service();
        $service->get('http://example.tld');
    }

    /**
     * Test isAssocArray with mixed keys.
     *
     * @return void
     */
    public function testIsAssocArrayWithMixedKeys()
    {
        $arr = [];
        $arr[] = 'foo';
        $arr['foo'] = 'bar';
        $this->assertTrue(Service::isAssocParams($arr));
    }

    /**
     * Test default settings.
     *
     * @return void
     */
    public function testDefaults()
    {
        $service = new Service([], ['foo' => 'bar']);
        $client = $service->createClient();
        $clientConfig = $this->getProperty($client, 'config');
        $this->assertEquals($clientConfig['foo'], 'bar');
    }

    /**
     * Test timeout setting.
     *
     * @return void
     */
    public function testTimeout()
    {
        $service = new Service();
        $client = $service->createClient(null, \Laminas\Http\Request::METHOD_GET, 67);
        $clientConfig = $this->getProperty($client, 'config');
        $this->assertEquals($clientConfig['timeout'], 67);
    }

    /**
     * Test defaults with Curl adapter.
     *
     * @return void
     */
    public function testCurlAdapterDefaults()
    {
        $service = new Service(
            [],
            ['adapter' => '\Laminas\Http\Client\Adapter\Curl']
        );
        $client = $service->createClient('http://example.tld:8080');
        $adapter = $client->getAdapter();
        $this->assertInstanceOf('Laminas\Http\Client\Adapter\Curl', $adapter);
        $config = $adapter->getConfig();
        $this->assertTrue(empty($config['curloptions']));
    }

    /**
     * Test defaults with Curl adapter.
     *
     * @return void
     */
    public function testCurlAdapterFollowLocation()
    {
        $service = new Service(
            [],
            [
                'adapter' => '\Laminas\Http\Client\Adapter\Curl',
                'curloptions' => [
                    52 => '1'
                ]
            ]
        );
        $client = $service->createClient('http://example.tld:8080');
        $adapter = $client->getAdapter();
        $this->assertInstanceOf('Laminas\Http\Client\Adapter\Curl', $adapter);
        $config = $adapter->getConfig();
        $this->assertEquals(
            '1', $config['curloptions'][CURLOPT_FOLLOWLOCATION] ?? null
        );
    }

    /**
     * Return protected or private property.
     *
     * Uses PHP's reflection API in order to modify property accessibility.
     *
     * @param object|string $object   Object or class name
     * @param string        $property Property name
     *
     * @throws \ReflectionException Property does not exist
     *
     * @return mixed
     */
    protected function getProperty($object, $property)
    {
        $reflectionProperty = new \ReflectionProperty($object, $property);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($object);
    }
}
