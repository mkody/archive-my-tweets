<?php

require_once('includes.php');

if (isset($_GET['secret']) && $_GET['secret'] == TWITTER_CRON_SECRET) {

	// create and backup
	$tb = new ArchiveMyTweets(TWITTER_USERNAME, TWITTER_PASSWORD, DB_NAME, DB_TABLE_PREFIX, DB_HOST, DB_USERNAME, DB_PASSWORD);
	$output = $tb->backup();
	echo '<pre>' . $output . '</pre>';

} else {
	
	echo 'You are not authorized to access this page.';
	
}

?>