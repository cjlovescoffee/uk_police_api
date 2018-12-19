<?php

require_once('police.php');
require_once('localdb.php');

Class PoliceDB extends Police {
  private $localdb = null;

  public function __construct() {
    $this->localdb = new LocalDB();
    parent::__construct();
  }

  /** Get all forces
    * @return array|false
    */

  public function forces() {
    $this->localdb->prepare("SELECT id, name FROM forces");
    $this->localdb->execute();
    return $this->localdb->allresults();
  }

  /** Get a single force
    * @return array|false
    */

  public function force($force) {
    $this->localdb->prepare("SELECT id, name FROM forces WHERE id = :id");
    $this->localdb->bind(':id', $force);
    $this->localdb->execute();
    return $this->localdb->singleresult();
  }

  /** Get all neighbourhoods by force
    * @param string force
    * @return array|false
    */

  public function neighbourhoods($force) {
    $this->localdb->prepare("SELECT id, name FROM neighbourhoods WHERE `force` = :force");
    $this->localdb->bind(':force', $force);
    $this->localdb->execute();
    return $this->localdb->allresults();
  }

  /** Get specific neighbourhood
    * @param string force
    * @param string neighbourhood
    * @return array|false
    */

  public function neighbourhood($force, $neighbourhood) {
    $this->localdb->prepare("SELECT name, latitude, longitude FROM neighbourhoods WHERE `force` = :force AND id = :neighbourhood");
    $this->localdb->bind(':force', $force);
    $this->localdb->bind(':neighbourhood', $neighbourhood);
    $this->localdb->execute();
    return $this->localdb->singleresult();
  }

  /**
    * Update local forces from remote source
    */

  public function updateForces() {
    $forces = parent::forces();
    if($forces) {
      $this->localdb->prepare("INSERT INTO forces (id, name) VALUES (:id, :name)");
      foreach($forces as $force) {
        $this->localdb->bind(':id', $force['id']);
        $this->localdb->bind(':name', $force['name']);
        $this->localdb->execute();
      }
    }
  }

  /**
    * Update local neighbourhoods from remote source
    */

  public function updateNeighbourhoods() {
    $forces = $this->forces();
    foreach($forces as $force) {
      $force = $force['id'];
      $neighbourhoods = parent::neighbourhoods($force);
      if($neighbourhoods) {
        $this->localdb->prepare("INSERT INTO neighbourhoods (id, name, `force`) VALUES (:id, :name, :force)");
        foreach($neighbourhoods as $neighbourhood) {
          $this->localdb->bind(':name', $neighbourhood['name']);
          $this->localdb->bind(':id', $neighbourhood['id']);
          $this->localdb->bind(':force', $force);
          $this->localdb->execute();
        }
      }
    }
  }

  /**
    * Update local neighbourhood from remote source
    */

  public function updateNeighbourhood($force, $neighbourhood) {
      $this->localdb->prepare("UPDATE neighbourhoods SET latitude = :lat, longitude = :lng WHERE id = :neighbourhood AND `force` = :force");
      $this->localdb->bind(':neighbourhood', $neighbourhood);
      $this->localdb->bind(':force', $force);
      $neighbourhood = parent::neighbourhood($force, $neighbourhood);
      $this->localdb->bind(':lat', $neighbourhood['centre']['latitude']);
      $this->localdb->bind(':lng', $neighbourhood['centre']['longitude']);
      $this->localdb->execute();
  }

  /**
    * Update local searches from remote source
    */

  public function updateSearches($force) {
      $this->localdb->prepare("INSERT INTO searches (`force`, type, involved_person, `datetime`, latitude, longitude, location_id, location_name, gender, age_range, self_defined_ethnicity, officer_defined_ethnicity, legislation, object_of_search, removal_of_more_than_outer_clothing) VALUES (:force, :type, :involved_person, :date_time, :lat, :lng, :location_id, :location_name, :gender, :age_range, :self_defined_ethnicity, :officer_defined_ethnicity, :legislation, :object_of_search, :removal_of_more_than_outer_clothing)");
      $interval = DateInterval::createFromDateString('1 month');
      $period = new DatePeriod($this->first_updated, $interval, $this->last_updated);
      foreach ($period as $dt) {
        $searches = parent::stopAndSearchByForceAndDate($force, $dt->format("Y-m"));
        foreach ($searches as $values) {
          $this->localdb->bind(':force', $force);
          $this->localdb->bind(':type', $values['type']);
          $this->localdb->bind(':involved_person', $values['involved_person']);
          $this->localdb->bind(':date_time', $values['datetime']);
          $this->localdb->bind(':lat', $values['location']['latitude']);
          $this->localdb->bind(':lng', $values['location']['longitude']);
          $this->localdb->bind(':location_id', $values['location']['street']['id']);
          $this->localdb->bind(':location_name', $values['location']['street']['name']);
          $this->localdb->bind(':gender', $values['gender']);
          $this->localdb->bind(':age_range', $values['age_range']);
          $this->localdb->bind(':self_defined_ethnicity', $values['self_defined_ethnicity']);
          $this->localdb->bind(':officer_defined_ethnicity', $values['officer_defined_ethnicity']);
          $this->localdb->bind(':legislation', $values['legislation']);
          $this->localdb->bind(':object_of_search', $values['object_of_search']);
          $this->localdb->bind(':legislation', $values['legislation']);
          $this->localdb->bind(':object_of_search', $values['object_of_search']);
          $this->localdb->bind(':removal_of_more_than_outer_clothing', $values['removal_of_more_than_outer_clothing']);
          $this->localdb->execute();
        }
      }
  }

  /** Get stop & searches by force
    * @param string force
    * @return array|false
    */

  public function stopAndSearchByForce($force) {
    $this->localdb->prepare("SELECT * FROM searches WHERE `force` = :force");
    $this->localdb->bind(':force', $force['id']);
    $this->localdb->execute();
    return $this->localdb->allresults();
  }

  /**
    * Reset local database using schema
    */

  public function reset() {
    $sql = file_get_contents('../resources/api/police.schema.sql');
    $this->localdb->prepare($sql);
    $this->localdb->execute();
  }
}

?>
