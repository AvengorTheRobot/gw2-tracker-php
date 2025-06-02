<?php
namespace GW2Tracker\UpdateAccountInfo;
class UpdateAccountInfoController {
  protected UpdateAccountInfo $UpdateAccountInfo;

  public function __construct(UpdateAccountInfo $UpdateAccountInfo) {
    $this->UpdateAccountInfo = $UpdateAccountInfo;
  }

  public function __invoke() {
    echo "Updating account info...\n";
    //$this->UpdateAccountInfo->updateBankContents();
    $this->UpdateAccountInfo->updateMaterialStorage();
    echo "Done updating account info...\n";
  }
}