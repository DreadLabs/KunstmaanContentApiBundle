<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace DreadLabs\KunstmaanContentApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $this->markTestSkipped();
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
