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
}

$connect = (new Connect())->connection;

?>