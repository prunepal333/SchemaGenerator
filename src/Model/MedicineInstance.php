<?php
namespace Ass\Model;
use Ass\Mapping\{Column, Entity, Get, Set};
#[Entity]
class MedicineInstance extends Model
{
    #[Get]
    #[Column]
    private ?int $id;

    #[Get,Set]
    #[Column]
    private ?int $medicineId;
    
    #[Get,Set]
    #[Column]
    private ?int $dosage;

    #[Get,Set]
    #[Column]
    private ?int $quantity;

    public function __construct(){}
    
    public function find(int $id){

        global $conn;
        $statement = $conn->prepare("SELECT * FROM MedicineInstance WHERE id=?");
        $statement->bindValue(1, $id);
        $resultSet = $statement->executeQuery();
        $medicineInstance = $resultSet->fetchAllAssociative();
        
        /**
         * Hardcoding the key of the medicineInstance
         * might result into the bug if table attribute's name differs from the 
         * property's name.
         * FIX ON PRODUCTION
         */
        
        $this->id = $medicineInstance['id'];
        $this->medicineId = $medicineInstance['medicineId'];
        $this->dosage = $medicineInstance['dosage'];
        $this->quantity = $medicineInstance['quantity'];
    }
    public function save(){
        global $conn;
        // dd($conn);
    }

}