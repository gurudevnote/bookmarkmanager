<?php

namespace Myspace\BookmarkBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
		$container = $client->getContainer();
		$doctrine =  $container->get('doctrine');
		$cats = $doctrine
			->getRepository('MyspaceBookmarkBundle:Category')
			->findAll();
		$cat = $cats[0];
		$containText = $cat->getName() . "(".count($cat->getBookmarks()).")";
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');
		//echo "containText = " . $containText;
		//echo $crawler->filter('html:contains("'+$containText+'")')->count();
		//die;

		$this->assertGreaterThan(0, $crawler->filter('html:contains("'+$containText+'")')->count());
		//$this->assertGreaterThan(0, $crawler->filter('html:contains("Hello Fabien")')->count());

        //$this->assertTrue($crawler->filter('html:contains("Microsoft Websites(5)")')->count() > 0);
		//$this->assertTrue($crawler->filter('html:contains("joomla(47)")')->count() > 0);
		//$this->assertTrue($crawler->filter('html:contains("other(273)")')->count() > 0);
    }
	
	/** @dataProvider provideUrls */
	public function testPageIsSuccessful($url)
	{
		$client = self::createClient();
		$client->request('GET', $url);

		$this->assertTrue($client->getResponse()->isSuccessful());
	}

	public function provideUrls()
	{
		return array(
			array('http://127.0.0.1:8000/'),
			array('http://127.0.0.1:8000/api/v1/categories.json'),
			array('http://127.0.0.1:8000/api/v1/categories.xml'),
			array('http://127.0.0.1:8000/api/v1/categories.html'),
			array('http://127.0.0.1:8000/api/v1/bookmarks.json'),
			array('http://127.0.0.1:8000/api/v1/bookmarks.xml'),
			array('http://127.0.0.1:8000/api/v1/bookmarks.html'),
			// ...
		);
	}
	
}
