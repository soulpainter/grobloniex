<?php

require_once('PoloneixPDO.php');

class TradingHistoryPDO extends PoloneixPDO
{
  public function fetchTotalOwnedByCurrency($currency)
  {
    $args = array('buy', 'exchange', $currency, '2017-01-15');

    $sql = 'SELECT th.currency, sum(th.amount) as totalPurchased, count(*) as totalPurchases, sum(th.rate)/count(*) as avgPurchaseRate
            FROM TradingHistory th
            WHERE th.type = ?
            AND th.category = ?
            AND th.currency = ?
            AND th.date > ?';
    $result = $this->queryList($sql,$args);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function fetchDaysBoughtByCurrency($currency)
  {
    $args = array('buy', 'exchange', $currency, '2017-01-15');

    $sql = 'SELECT DISTINCT DATE_FORMAT(date, "%Y-%m-%d") as date
            FROM TradingHistory th
            WHERE th.type = ?
            AND th.category = ?
            AND th.currency = ?
            AND th.date > ?';
    $result = $this->queryList($sql,$args);
    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    $dates = [];
    foreach($row as $day)
    {
      $dates[] = $day['date'];
    }

    return $dates;
  }

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

  public function fetchAllOwnedCurrencies()
  {
    $sql = "SELECT DISTINCT th.currency FROM TradingHistory th WHERE th.type = 'buy' AND th.category = 'exchange' AND th.date > '2017-01-15'";
    $result = $this->queryList($sql,array());
    $list = $result->fetchAll(PDO::FETCH_ASSOC);

    $array = [];
    foreach($list as $row)
    {
      $array[] = $row['currency'];
    }
    return $array;
  }

}

?>
