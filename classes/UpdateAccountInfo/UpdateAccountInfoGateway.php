<?php
namespace GW2Tracker\UpdateAccountInfo;
use GuzzleHttp\Client;
use PDO;
use PDOException;

class UpdateAccountInfoGateway {
  protected Client $Client;
  protected PDO $PDO;

  protected string $gw2APIKey;

  public function __construct(Client $Client, PDO $PDO) {
    $this->Client = $Client;
    $this->PDO = $PDO;
    $this->gw2APIKey = getenv('GW2_API_KEY');
  }

  public function getBankContents():array{
    $response = $this->Client->get('/v2/account/bank', [
      'base_uri' => 'https://api.guildwars2.com',
      'headers' => [
        'Authorization' => "Bearer {$this->gw2APIKey}",
        'Accept' => 'application/json'
      ]
    ]);
    $contents = $response->getBody()->getContents();
    $statusCode = $response->getStatusCode();
    $bankItems = json_decode($contents, true);
    return $bankItems;
  }

  public function purgeBankContents():void{
    $query = "DELETE FROM bank_items";
    try{
      $stmt = $this->PDO->prepare($query);
      $stmt->execute();
    }
    catch(PDOException $e){
      var_dump($e->getMessage());
      exit();
    }
  }

  public function updateBankContents(array $bankItems):void{
    $query = "INSERT INTO bank_items (item_id, count,charges,binding)
              VALUES (:item_id, :count, :charges, :binding)";
    $stmt = $this->PDO->prepare($query);
    foreach($bankItems as $item){
      if(!$item){continue;}
      $queryBindings = array(
        ':item_id' => $item['id'],
        ':count' => $item['count'],
        ':charges' => $item['charges'] ?? NULL,
        ':binding' => $item['binding'] ?? NULL
      );
      $stmt->execute($queryBindings);
    }
  }

  public function getMaterialStorage():array{
    $response = $this->Client->get('/v2/account/materials', [
      'base_uri' => 'https://api.guildwars2.com',
      'headers' => [
        'Authorization' => "Bearer {$this->gw2APIKey}",
        'Accept' => 'application/json'
      ]
    ]);
    $contents = $response->getBody()->getContents();
    $statusCode = $response->getStatusCode();
    $materials = json_decode($contents, true);
    return $materials;
  }

  public function purgeMaterialStorage():void{
    $query = "DELETE FROM material_storage";
    try{
      $stmt = $this->PDO->prepare($query);
      $stmt->execute();
    }
    catch(PDOException $e){
      var_dump($e->getMessage());
      exit();
    }
  }

  public function updateMaterialStorage(array $materials):void{
    $query = "INSERT INTO material_storage (item_id, count)
              VALUES (:item_id, :count)";
    $stmt = $this->PDO->prepare($query);
    try {
      foreach ($materials as $material) {
        if (!$material) {
          continue;
        }
        $queryBindings = array(
          ':item_id' => $material['id'],
          ':count' => $material['count']
        );
        $stmt->execute($queryBindings);
      }
    }
    catch(PDOException $e){
      echo "{$material['id']} threw an error \n";
    }
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