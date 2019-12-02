<?php
require_once("twitteroauth/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

function getDefaultFollowList()
{
	return ['BoiseState', 'JUMPboise'];
}

function parseFollowList($followText)
{
	return preg_split("/[\s]+/", trim($followText));
}

function printTweet($tweet)
{
	echo '<div class="tweet">';
	echo '<img src="' . $tweet->user->profile_image_url . '">' . '<span class="tweet_username">' . $tweet->user->name . '</span><span class="tweet_screenname">@' . $tweet->user->screen_name . '</span>';
	$text = $tweet->full_text;
	if (isset($tweet->entities->urls)) {
		foreach ($tweet->entities->urls as $urlObject) {
			$url = $urlObject->url;
			$text = str_replace($url, '<a href="' . $url . '">' . $url . '</a>', $text);
		}
	}
	echo '<div>' . $text . '</div>';
	if (isset($tweet->extended_entities->media[0]->video_info->varients[0]->url)) {
		$video_link = $tweet->extended_entities->media[0]->video_info->variants[0]->url;
		echo 'Video: <a href="' . $video_link . '">' . $video_link . '</a>';
	}
	else if (isset($tweet->entities->media[0]->media_url)) {
		echo '<img src="' . $tweet->entities->media[0]->media_url . '">';
	}
	echo '</div>';
}

function compareTweetTimes($a, $b)
{
	$a_date = new DateTime($a->created_at);
	$b_date = new DateTime($b->created_at);
	
	return $a_date < $b_date;
}

function showTweets()
{
	$notweets = 10; //how many tweets you want to retrieve
	$consumer_key = "rzbOBfYr7nZ3H9hUyyyEmUsyH";
	$consumer_secret = "9I4iJfIAqEj5WfRZBFipr6I2xIHnYpefRfj27sDElGkBWmNOSY"; 
	$oauth_token = "1180557972058996736-NqqiXgqi4SgAjNtzDP0bpXtBLhxdYi"; 
	$oauth_token_secret = "KGprhLcFCyGfzx6vjVoiF0ODmhvDqQsqZlXhqoAfI7Hxd"; 

	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
	$tweet_list = [];

	foreach ($_SESSION['follow'] as $follow)
	{
		$tweets = $connection->get("statuses/user_timeline", ["screen_name" => $follow, "count" => $notweets, "tweet_mode" => "extended"]);

		if (isset($tweets->errors)) {
			echo '<div class="error">Could not find a twitter account named ' . $follow . '</div>';
		}
		else {
			foreach ($tweets as $tweet) {
				if (isset($tweet->id)) {
					$tweet_list[] = $tweet;
				}
			}
		}
	}

	usort($tweet_list, "compareTweetTimes");
	
	foreach ($tweet_list as $tweet) {
		printTweet($tweet);
	}	
}

?>