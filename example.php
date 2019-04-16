<?php
require_once("qiwi.php");

$qiwi = new Qiwi('12543a5b8fbdccf55ffeba9f5391133f'); //Init class by API token


$hook_id = $qiwi->set_hook_url('https://example.com/callback/qiwi'); //Set new hook

$hook_key = $qiwi->get_hook_key('n0h62411-679d-4f97-bf68-5facscfafd4e'); //Get hook key by id

//Send test req
if ($qiwi->send_test_hook()) {
    echo "the test request was successfully sent!";
}
