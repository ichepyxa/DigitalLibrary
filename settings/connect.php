<?php

class Connect
{
  private string $host;
  private string $port;
  private string $db;
  private string $user;
  private string $pass;
  private string $charset = 'utf8';
  private string $dsn;
  private null|array $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];
  public PDO $connection;


  public function __construct()
  {
    require 'config.php';

    $this->host = $config['host'];
    $this->port = $config['port'];
    $this->db = $config['database'];
    $this->user = $config['username'];
    $this->pass = $config['password'];

    $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;port=$this->port";

    try {
      $this->connection = new PDO($this->dsn, $this->user, $this->pass, $this->options);
    } catch (PDOException $exception) {
      die('Не удалось подключиться: ' . $exception->getMessage());
    }
  }

  /**
   * Method which get all data from table
   * @param string $tableName
   * @return array|false
   */
  public function getAllTableData(string $tableName): array|false
  {
    $query = $this->connection->prepare("SELECT * FROM $tableName");
    $query->execute();

    if (!$query) {
      return false;
    }

    $result = $query->fetchAll();
    return $result;
  }

  /**
   * Method which get data by id from table
   * @param string $tableName
   * @param int $id
   * @param string $columnIdName
   * @return array|false
   */
  public function getDataByIdFromTable(string $tableName, int $id, string $columnIdName = 'id'): false|array
  {
    $query = $this->connection->prepare("SELECT * FROM $tableName WHERE $columnIdName = :id");
    $query->execute(['id' => $id]);

    if (!$query) {
      return false;
    }

    $result = $query->fetch();
    return $result;
  }

  /**
   * Method which get data on column
   * @param string $tableName
   * @param string $columnName
   * @param string $value
   * @return false|array
   */
  public function getDataOnColumn(string $tableName, string $columnName, string $value, int $count = 0): false|array
  {
    $query = $this->connection->prepare("SELECT * FROM $tableName WHERE $columnName = :$columnName");
    $query->execute([$columnName => $value]);

    if (!$query || $query->rowCount() == 0) {
      return false;
    }

    $result = $query->fetchAll();

    if ($count > 0 && $count != 1) {
      return array_slice($result, 0, $count);
    }

    return $count == 1 ? $result[0] : $result;
  }

  /**
   * Method which preparing query
   * @param array $data
   * @return string
   */
  private function queryPreparing(array $data): string
  {
    $set = '';
    $columns = array_keys($data);

    foreach ($columns as $column) {
      $set .= "`" . str_replace("`", "``", $column) . "`" . "=:$column, ";
    }

    return substr($set, 0, -2);
  }

  /**
   * Method which insert data into table
   * @param string $tableName
   * @param array $data
   * @return bool
   */
  public function insertData(string $tableName, array $data): bool
  {
    $preparingQuery = $this->queryPreparing($data);
    $query = $this->connection->prepare("INSERT INTO $tableName SET $preparingQuery");
    $query->execute($data);

    if (!$query) {
      return false;
    }

    return true;
  }

  /**
   * Method which updata data into table
   * @param string $tableName
   * @param array $data
   * @param int $id
   * @param string $columnIdName
   * @return bool
   */
  public function updateData(string $tableName, array $data, int $id, string $columnIdName = 'id'): bool
  {
    $preparingQuery = $this->queryPreparing($data);
    $query = $this->connection->prepare("UPDATE $tableName SET $preparingQuery WHERE $columnIdName = :id");
    $query->execute(["id" => $id, ...$data]);

    if (!$query) {
      return false;
    }

    return true;
  }

  /**
   * Method which delete data by id from table
   * @param string $tableName
   * @param int $id
   * @param string $columnIdName
   * @return bool
   */
  public function deleteData(string $tableName, int $id, string $columnIdName = 'id'): bool
  {
    $query = $this->connection->prepare("DELETE FROM $tableName WHERE $columnIdName = :id");
    $query->execute(['id' => $id]);

    if (!$query) {
      return false;
    }

    return true;
  }
}

$connect = new Connect();

?>