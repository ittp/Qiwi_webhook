<?php
class Qiwi {
    //API token
    public $token = '';

    //Init class
    function __construct($token)
    {
        $this->token = $token;
    }

    //Get active webhook
    private function get_hook() {
        $answer = json_decode($this->request(
            '/payment-notifier/v1/hooks/active',
            'GET'
        ));
        //If there is an active WebHook, then return its id
        if ($answer->hookId) {
            return $answer->hookId;
        } else {
            return false;
        }
    }
    //Get last webhook url
    public function getLastHookUrl() {
        $answer = json_decode($this->request(
            '/payment-notifier/v1/hooks/active',
            'GET'
        ));
        return $answer->hookParameters->url;
    }
    //Put new hook
    private function put_hook($url) {
        $answer = json_decode($this->request(
            '/payment-notifier/v1/hooks?hookType=1&param='.urlencode($url).'&txnType=0',
            'PUT'
        ));
        return $answer;
    }
    //Delete hook
    private function delete_hook($hook_id) {
        $answer = json_decode($this->request(
            "/payment-notifier/v1/hooks/$hook_id",
            'DELETE'
        ));
        if ($answer->response) return true; else return false;
    }
    //Get hook key
    public function get_hook_key($hook_id) {
        $answer = json_decode($this->request(
            "/payment-notifier/v1/hooks/$hook_id/key",
            'GET'
        ));
        if ($answer->key) return $answer->key; else return false;
    }
    //Add hook
    public function set_hook_url($url) {
        $hook_id = $this->get_hook();
        //Если есть hook, то удаляем его
        if ($hook_id) {
            $this->delete_hook($hook_id);
        }
        return $this->put_hook($url)->hookId;
    }
    //Send test req
    public function send_test_hook() {
        $answer = json_decode($this->request(
            "/payment-notifier/v1/hooks/test",
            'GET'
        ));
        if ($answer->response) return true; else return false;
    }

    private function request($link, $type) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://edge.qiwi.com/$link");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $this->token"
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }
}
?>