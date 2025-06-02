<?php

namespace GW2Tracker\UpdateAccountInfo;

class UpdateAccountInfo {
  protected UpdateAccountInfoGateway $UpdateAccountInfoGateway;

  public function __construct(UpdateAccountInfoGateway $UpdateAccountInfoGateway) {
    $this->UpdateAccountInfoGateway = $UpdateAccountInfoGateway;
  }

  public function updateBankContents(){
    $bank = $this->UpdateAccountInfoGateway->getBankContents();
    $this->UpdateAccountInfoGateway->purgeBankContents();
    $this->UpdateAccountInfoGateway->updateBankContents($bank);
  }

  public function updateMaterialStorage(){
    $materialStorage = $this->UpdateAccountInfoGateway->getMaterialStorage();
    $this->UpdateAccountInfoGateway->purgeMaterialStorage();
    $this->UpdateAccountInfoGateway->updateMaterialStorage($materialStorage);
  }
}