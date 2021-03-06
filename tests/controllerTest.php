<?php

namespace AMWhalen\ArchiveMyTweets;

class ControllerTest extends \PHPUnit_Framework_TestCase {

	protected $model;
	protected $view;
	protected $controller;
	protected $paginator;
	protected $latestTweet;
	protected $recentTweets;
	protected $fakeData;

	public function setUp() {

		$this->latestTweet = array(
			'id' => 293780221621067776,
			'user_id' => 14061545,
			'created_at' => '2013-01-22 13:00:37',
			'tweet' => "Archive My Tweets has a new look, and can now import your official twitter archive. https://t.co/e8HDtbYa",
			'source' => '<a href="http://twitterrific.com" rel="nofollow">Twitterrific for Mac</a>',
			'truncated' => 0,
			'favorited' => 0,
			'in_reply_to_status_id' => 0,
			'in_reply_to_user_id' => 0,
			'in_reply_to_screen_name' => 0,
		);
		$this->recentTweets = array($this->latestTweet);

		// mock model
		$this->model = $this->getMockBuilder('AMWhalen\ArchiveMyTweets\Model')
			->disableOriginalConstructor()
			->getMock();

		// model returns array of tweets
		$this->model->expects($this->any())->method('getTweets')->will($this->returnValue($this->recentTweets));

		// model returns latest tweet
		$this->model->expects($this->any())->method('getTweet')->will($this->returnValue($this->latestTweet));

		// by client
		$this->model->expects($this->any())->method('getTweetsByClient')->will($this->returnValue($this->recentTweets));
		$this->model->expects($this->any())->method('getTweetsByClientCount')->will($this->returnValue(1));

		// favorites
		$this->model->expects($this->any())->method('getFavoriteTweets')->will($this->returnValue($this->recentTweets));

		// month
		$this->model->expects($this->any())->method('getTweetsByMonth')->will($this->returnValue($this->recentTweets));
		$this->model->expects($this->any())->method('getTweetsByMonthCount')->will($this->returnValue(1));

		// months
		$this->model->expects($this->any())->method('getTwitterMonths')->will($this->returnValue(array()));

		// clients
		$this->model->expects($this->any())->method('getTwitterClients')->will($this->returnValue(array()));

		// fake config data
		$this->fakeData = array(
			'config' => array(
				'system' => array('baseUrl' => ''),
				'twitter' => array('username' => 'fakeusername', 'name' => 'Fake Name')
			)
		);

		$this->view = new View(dirname(__FILE__).'/../themes/default');
		$this->paginator = new Paginator();
		$this->controller = new Controller($this->model, $this->view, $this->paginator, $this->fakeData);

	}

	public function testRecent() {

		// preconditions: nothing in $_GET params

		ob_start();
		$this->controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-recent'));

	}

	public function testSingle() {

		// preconditions
		$_GET['id'] = 293780221621067776;

		ob_start();
		$this->controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-single'));

	}

	public function testSearch() {

		// preconditions
		$_GET = array();
		$_GET['q'] = 'aardvark';

		$model = $this->model;

		// search
		// calls 0-6 are at the top of the index() controller method
		$model->expects($this->at(7))->method('getSearchResults')->will($this->returnValue($this->recentTweets));
		$model->expects($this->at(8))->method('getSearchResults')->will($this->returnValue(1));

		$controller = new Controller($model, $this->view, $this->paginator, $this->fakeData);

		ob_start();
		$controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-search'));

	}

	public function testMonth() {

		// preconditions
		$_GET = array();
		$_GET['year'] = '2013';
		$_GET['month'] = '01';

		ob_start();
		$this->controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-month'));

	}

	public function testClient() {

		// preconditions
		$_GET = array();
		$_GET['client'] = 'web';

		ob_start();
		$this->controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-client'));

	}

	public function testFavorites() {

		// preconditions
		$_GET = array();
		$_GET['favorites'] = '1';

		ob_start();
		$this->controller->index();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-favorites'));

	}

	public function testStats() {

		// preconditions: none

		ob_start();
		$this->controller->stats();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-stats'));

	}

	public function testNotFound() {

		// note: PHPUnit sends its own headers, so the header(404) can't be tested

		ob_start();
		$this->controller->notFound();
		$output = ob_get_clean();

		$this->assertTrue($this->didFindString($output, 'amt-notfound'));

	}

	/**
	 * Returns true if the string is found in the haystack
	 */
	protected function didFindString($haystack, $needle) {
		return strstr($haystack, $needle) !== false;
	}

}