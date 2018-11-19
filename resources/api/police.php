<?php
require_once("curl.php");

Class Police extends Curl {

  public function __construct() {
    parent::__construct();
    $this->baseUrl = "https://data.police.uk/api/";
    $this->setOpt(CURLOPT_RETURNTRANSFER, true);
  }

  /** Get all forces
    * @return array|false
    */

  public function forces() {
    return $this->call('forces');
  }

  /** Get a specific force
    * @param string force
    * @return array|false
    */

  public function force($force) {
    return $this->call(
      sprintf('forces/%s', urlencode($force))
    );
  }

  /** Get senior officers by force
    * @param string force
    * @return array|false
    */

  public function seniorOfficers($force) {
    return $this->call(
      sprintf('forces/%s/people', urlencode($force))
    );
  }

  /** Get all neighbourhoods by force
    * @param string force
    * @return array|false
    */

  public function neighbourhoods($force) {
    return $this->call(
      sprintf('%s/neighbourhoods', urlencode($force))
    );
  }

  /** Get specific neighbourhood
    * @param string force
    * @param string neighbourhood
    * @return array|false
    */

  public function neighbourhood($force, $neighbourhood) {
    return $this->call(
      sprintf('%s/%s', urlencode($force), urlencode($neighbourhood))
    );
  }

  /** Get neighbourhood team
    * @param string force
    * @param string neighbourhood
    * @return array|false
    */

  public function neighbourhoodTeam($force, $neighbourhood) {
    return $this->call(
      sprintf('%s/%s/people', urlencode($force), urlencode($neighbourhood))
    );
  }

  /** Get neighbourhood priorities
    * @param string force
    * @param string neighbourhood
    * @return array|false
    */

  public function neighbourhoodPriorities($force, $neighbourhood) {
    return $this->call(
      sprintf('%s/%s/priorities', urlencode($force), urlencode($neighbourhood))
    );
  }

  /** Locate neighbourhood by latitude and longitude
    * @param float latitude
    * @param float longitude
    * @return array|false
    */

  public function locateNeighbourhood($latitude, $longitude) {
    return $this->call(
      sprintf('locate-neighbourhood?q=%s,%s', $latitude, $longitude)
    );
  }
}
