<?php
namespace GW2Tracker\UpdateAccountInfo;
use GuzzleHttp\Client;
use PDO;
use PDOException;

class UpdateAccountInfoGateway {
  protected Client $Guzzle;
  protected PDO $PDO;

  public function __construct(Client $guzzle, PDO $PDO) {
    $this->Guzzle = $guzzle;
    $this->PDO = $PDO;
  }

  public function getName():array {
    $query = "SELECT name FROM items LIMIT 5";
    $queryBindings = array();
    try{
      $stmt = $this->PDO->prepare($query);
      $stmt->execute($queryBindings);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      var_dump($e->getMessage());
      exit();
    }
    return $result;
  }
}