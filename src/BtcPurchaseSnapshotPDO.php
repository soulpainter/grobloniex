<?php

require_once('PoloneixPDO.php');

class BtcPurchaseSnapshotPDO extends PoloneixPDO
{
  public function fetchAll()
  {
    $sql = 'SELECT DATE_FORMAT(date, "%Y-%m-%d") as date, DATE_FORMAT(date, "%M %D %Y") as fDate, weightedAverage FROM BtcPurchaseSnapshot';
    $result = $this->queryList($sql,array());
    $list = $result->fetchAll(PDO::FETCH_ASSOC);
    return $list;
  }

  public function fetchSingleDayByDate($date)
  {
    $sql = 'SELECT DATE_FORMAT(date, "%Y-%m-%d") as date, DATE_FORMAT(date, "%M %D %Y") as fDate, weightedAverage FROM BtcPurchaseSnapshot WHERE date=\''. $date . '\'';
    $result = $this->queryList($sql,array());
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function fetchAverageBtcByMultipleDates($dates)
  {
    $pdoStr = implode(',', array_fill(0, count($dates), '?'));
    $sql = 'SELECT sum(weightedAverage)/count(date) AS averageBtcPrice FROM BtcPurchaseSnapshot WHERE date IN (' . $pdoStr . ')';
    $result = $this->queryList($sql,$dates);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

}

?>
