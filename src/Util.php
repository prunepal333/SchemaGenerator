<?php
namespace Ass;
use ReflectionProperty as ReflectionProperty;
use ReflectionClass as ReflectionClass;
use ReflectionAttribute as ReflectionAttribute;
class Util
{
    public static function getSubClasses(string $parent): array
    {
        return array_reduce(get_declared_classes(), function($subclasses, $class) use ($parent) {
            if (is_subclass_of($class, $parent)){
                $subclasses[] = $class;
            }
            return $subclasses;
        }, []);
    }
    public static function getEntities(string $parent = null): array{
        if ($parent === null){
            $classes = get_declared_classes();
        }else{
            $classes = self::getSubClasses($parent);
        }

        return array_reduce($classes, function($entities, $class) {
            $reflector = new ReflectionClass($class);
            if (self::classHasAttribute($reflector, "Entity")){
                $entities[] = $class;
            }
            return $entities;
        },[]);
    }
    public static function propertyHasAttribute(ReflectionProperty $property, string $attr): bool
    {
        foreach($property->getAttributes() as $attribute)
        {
            if ($attribute->getName() === $attr) return true;
        }
        return false;
    }
    public static function classHasAttribute(ReflectionClass $class, string $attr): bool
    {
        foreach($class->getAttributes() as $attribute)
        {
            if ($attribute->getName() === $attr) return true;
        }
        return false;
    }
    public static function attributeHasArgument(ReflectionAttribute $attribute, string $arg): bool
    {
        foreach($attribute->getArguments() as $argname => $argval){
            if ($argname === $arg)  return true;
        }
        return false;
    }
    public static function propertyGetAttribute(ReflectionProperty $property, string $attr): ?ReflectionAttribute
    {
        foreach ($property->getAttributes() as $attribute){
            if ($attribute->getName() === $attr)  return $attribute;
        }
        return null;
    }
    public static function classGetAttribute(ReflectionClass $class, string $attr): ?ReflectionAttribute 
    {
        foreach ($class->getAttributes() as $attribute) {
            if ($attribute->getName() === $attr) return $attribute;
        }
        return null;
    }
    public static function attributeGetArgumentValue(ReflectionAttribute $attr, string $arg): mixed
    {
        $args = $attr->getArguments();
        foreach($args as $argname => $argval){
            if($arg == $argname) return $argval;
        }
        return null;
    }
}