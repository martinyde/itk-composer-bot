<?php

/*

REQUIREMENTS

* A custom slash command on a Slack team
* A web server running PHP5 with cURL enabled

USAGE

* Place this script on a server running PHP5 with cURL.
* Set up a new custom slash command on your Slack team: 
  http://my.slack.com/services/new/slash-commands
* Under "Choose a command", enter whatever you want for 
  the command. /isitup is easy to remember.
* Under "URL", enter the URL for the script on your server.
* Leave "Method" set to "Post".
* Decide whether you want this command to show in the 
  autocomplete list for slash commands.
* If you do, enter a short description and usage hint.

*/

$ch = curl_init("https://hooks.slack.com/services/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");
$user_agent = "Slackipedia/1.0 (https://github.com/mccreath/slackipedia; mccreath@gmail.org)";
$wiki_lang = "en";

# Grab some of the values from the slash command, create vars for post back to Slack
$command = $_POST['command'];
$token = $_POST['token'];
$channel = $_POST['channel_id'];
print_r($_POST);

$fields = array();

slack($fields, $channel);

// (string) $message - message to be passed to Slack
// (string) $icon - You can set up custom emoji icons to use with each message
function slack($fields, $channel) {
  $data = "payload=" . json_encode(array(
      'channel' => $channel,
      'text' =>  'Ipsum',
      'icon_emoji'    =>  ':knife_fork_plate:',
      'username' => 'test',
      'mrkdwn' => true,
      'attachments' => array(array (
        'title' => 'Test',
        'fallback' => 'Fallback',
        'color' => '#1e528a',
        'fields' => $fields,
        'image_url' => '',
        'footer' => 'Footer',
        'ts' => time(),
      )),
    ));

  // You can get your webhook endpoint from your Slack settings

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);

  return $result;
} 