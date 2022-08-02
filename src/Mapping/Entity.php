<?php
namespace Ass\Mapping;
use Attribute as Attribute;
#[Attribute(Attribute::TARGET_CLASS)]
final class Entity{
    // public ?int $id = null;
    public function __construct(
        public ?string $name = null
    ){}
}