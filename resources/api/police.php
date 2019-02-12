<?php
require_once("curl.php");

Class Police extends Curl {
  public $first_updated;
  public $last_updated;

  public function __construct() {
    parent::__construct();
    $this->baseUrl = "https://data.police.uk/api/";
    $this->setOpt(CURLOPT_RETURNTRANSFER, true);
    $this->first_updated = new DateTime("2017-01");
    $this->last_updated = new DateTime($this->lastUpdated()['date']);
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

  /** Get neighbourhood boundary
    * @param string force
    * @param string neighbourhood
    * @return array|false
    */

  public function neighbourhoodBoundary($force, $neighbourhood) {
    return $this->call(
      sprintf('%s/%s/boundary', urlencode($force), urlencode($neighbourhood))
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

  /** Get stop & searches by force and date
    * @param string force
    * @param string date
    * @return array|false
    */

  public function stopAndSearchByForceAndDate($force, $date) {
    return $this->call(
      sprintf('stops-force?force=%s&date=%s', urlencode($force), urlencode($date))
    );
  }

  public function CrimeDates() {
    return $this->call(
      sprintf('crimes-street-dates')
    );
  }

  /** Get last updated month
    * @return DateTime|false
    */

  public function lastUpdated() {
    return $this->call(
      sprintf('crime-last-updated')
    );
  }
}
