<?php

abstract class PoloneixPDO
{
  const USERNAME='poloneix';
  const PASSWORD='p0l0n3ix';
  const HOST='localhost';
  const DB='poloneix';

  private function getConnection()
  {
            $username = self::USERNAME;
            $password = self::PASSWORD;
            $host = self::HOST;
            $db = self::DB;
            $connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);
            return $connection;
  }

  protected function queryList($sql, $args)
  {
            $connection = $this->getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute($args);
            return $stmt;
  }
}

?>
