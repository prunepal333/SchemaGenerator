<?php
namespace Ass;
use ReflectionClass;
use Exception;

use function preg_match;
use function strcasecmp;
use function lcfirst;
use function count;
use function gettype;

class Base
{
    private ReflectionClass $reflector;
    public function __construct()
    {
        $this->reflector = new ReflectionClass(get_class($this));
    }
    /**
     * A fallback method in PHP which is called when the method
     * is not explicitly defined in the object's scope
     */
    public function __call($name, $args)
    {
        if (preg_match("/get(\S+)/", $name, $matches))
        {
            $propName = lcfirst($matches[1]);
            echo $propName;
            if ($this->reflector->hasProperty($propName))
            {
                $property  = $this->reflector->getProperty($propName);
                foreach($property->getAttributes() as $attribute)
                {
                    if (strcasecmp("get", $attribute->getName()) === 0){
                        //actual work is done here...
                        return $property->getValue($this);
                    }   
                }
                throw new \Exception("Getter is not defined!\n");
            }
            throw new \Exception("Property is not defined!\n");
        }
        else if (preg_match("/set(\S+)/", $name, $matches))
        {

            $propName = lcfirst($matches[1]);
            if ($this->reflector->hasProperty($propName)){
                $property = $this->reflector->getProperty($propName);
                foreach($property->getAttributes() as $attribute)
                {
                    if (strcasecmp("set", $attribute->getName()) === 0){
                        if (count($args) != 1){
                            throw new Exception("Expected 1 argument, but " . count($args) . " provided");
                        }
                        if (strcasecmp($property->getType()->getName(),gettype($args[0])) !== 0)
                        {
                            throw new Exception("Expected argument of type ". $property->getType()->getName() . ", but " . gettype($args[0]) . " provided");   
                        }
                        $property->setValue($this, $args[0]);
                        return $this;
                    }
                }
                throw new Exception("Setter is not defined!\n");
            }
            throw new Exception("Property is not defined!\n");
        }
        else{
            
            throw new Exception("Method is not defined!");
        }
    }
}
