<?php
namespace Ass;
error_reporting(E_ALL);
// echo get_include_path();
require_once "../bootstrap.php";
use Doctrine\DBAL\Schema\Schema;
use function array_diff;
use function scandir;
class SchemaGenerator
{
    private Schema $schema;
    public function __construct(){
        $this->schema = new Schema();
    }
    public function run($class)
    {
        global $dbType,
                $conn;
        $reflector = new \ReflectionClass($class);
        if (!Util::classHasAttribute($reflector, "Ass\Mapping\Entity")) return;
        $entityName = Util::attributeGetArgumentValue(Util::classGetAttribute($reflector, 'Ass\Mapping\Entity'), '') ?? $reflector->getName();
        $myTable = $this->schema->createTable($entityName);
        foreach($reflector->getProperties() as $property)
        {
            if(!Util::propertyHasAttribute($property, "Column")) continue;
            
            $columnAttribute = Util::propertyGetAttribute($property, "Column");

            $columnName = Util::attributeGetArgumentValue($columnAttribute, "name") ?? $property->getName();
            $myTable->addColumn($columnName, $dbType[$property->getType()->getName()]);
            // if (Util::attributeHasArgument($columnAttribute, "primary")){
            //     $primaryAttrs[] = Util::attributeGetArgumentValue($columnAttribute, "primary") ?? false;
            // }
            // if (Util::attributeHasArgument($columnAttribute, "unique")){
            //     $uniqueAttrs[] = Util::attributeGetArgumentValue($columnAttribute, "unique") ?? false;
            // }
            // if (Util::attributeHasArgument($columnAttribute, "notnull")){
            // }
            // $uniqueAttributes[] = $property->getName();
        }
        // exit;
        // $myTable->addColumn("id", "integer", ["unsigned" => true]);
        // $myTable->addColumn("name", "string", ["length" => 32]);
        // $myTable->setPrimaryKey(["id"]);
        // $myTable->addUniqueIndex(["name"]);
        
        $queries = $this->schema->toSql(new \Doctrine\DBAL\Platforms\MySQL80Platform());

        foreach($queries as $query){
            $conn->executeQuery($query);
        }
    }
}
function includeFiles($dir)
{
    $dirs = array_diff(scandir($dir), array('.', '..'));
    foreach($dirs as $file)
    {
        include_once $dir . DIRECTORY_SEPARATOR .  $file;
    }
    // $classes = get_declared_classes();
}
includeFiles(__DIR__ . DIRECTORY_SEPARATOR . "Model");

$dbType = array(
    'int' => 'integer',
    'string' => 'string',
    'float' => 'float',
    'double' => 'double',
    'array' => 'json',
    'resource' => 'blob'
);

$sg = new SchemaGenerator();
// foreach(Util::getEntities(Model::class) as $model)
var_dump(get_declared_classes());
foreach(array_diff(scandir(__DIR__ . DIRECTORY_SEPARATOR . "Model/"), array('.', '..')) as $filename)
{
    include_once $model . ".php";
    $model = substr($filename, 0, strrpos($filename, "."));
    $sg->run("\\Ass\Model\\". $model);
}
echo "Finished!\n";
echo "New Finished!\n";