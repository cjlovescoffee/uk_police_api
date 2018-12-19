<?php

class Curl {
  protected $baseUrl = null;
  public $curl = null;

  public function __construct() {
    $this->curl = curl_init();
  }

  /** Set an option for curl transfer
    * @access protected
    * @param string option
    * @param mixed value
    */

  protected function setOpt($option, $value) {
    return curl_setopt($this->curl, $option, $value);
  }

  /** Make the call
    * @access protected
    * @param string endpoint
    * @return array|false
    */

  protected function call($endpoint) {
    $call = $this->baseUrl.$endpoint;
    $this->setOpt(CURLOPT_URL, $call);
    $result = curl_exec($this->curl);
    $info = curl_getinfo($this->curl);

    if($info['http_code'] == 200) {
      return json_decode($result, true);
    }
    else {
      die('Error');
      return false;
    }
  }

  public function __destruct() {
    return curl_close($this->curl);
  }
}
