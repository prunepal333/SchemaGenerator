<?php
namespace Ass\Model;
require_once "../bootstrap.php";
use Ass\Mapping\Set;
use Ass\Mapping\Get;
use Ass\Mapping\Entity;
use Ass\Mapping\Column;

#[Entity]
class Medicine extends Model
{
    #[Get]
    #[Column]
    private int $id;
    #[Get, Set]
    #[Column(name: 'name', type: 'string', length: 40, unique: true, nullable: false, auto: true)]
    private string $name;
    public function find(int $id): ?self
    {
        global $conn;
        // $statement = $conn->prepare("SELECT (id, name) FROM Medicine WHERE id = ?");
        // $resultSet = $statement->executeQuery();
        // $medicine = $resultSet->fetchAssociative();
        // if (!$medicine)
        // {
        //     return null;
        // }
        // $conn->select('Medicine', []);
        dd($conn);
        // $this->id = $medicine['id'];
        // $this->name = $medicine['name'];
        return $this;
    }
    public function save(): int
    {
        if (!isset($this->name) || empty($this->name))
        {
            throw new \Exception("name field must not be empty!\n");
        }
        global $conn;
        $statement = $conn->prepare("INSERT INTO Medicines (name) VALUES(?)");
        $statement->bindValue(1, $this->name);
        return $statement->executeStatement();
        $GLOBALS['conn']->insert('Medicines', ['name' => $this->name]);
    }
}
// $reflector = new \ReflectionClass(Medicine::class);
// foreach($reflector->getProperties() as $property){
//     print "Attribute of " . $property;
//     print join(", ", $property->getAttributes());