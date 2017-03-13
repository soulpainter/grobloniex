<?php

require_once('PoloneixPDO.php');

class StatsPDO extends PoloneixPDO
{
  public function addRow($sql)
  {
    $args = array();
    $result = $this->queryList($sql,$args);
  }

}

?>
