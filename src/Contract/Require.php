<?php
namespace Ass\Contract;
use Attribute as Attribute;
#[Attribute(Attribute::TARGET_METHOD)]
final class Require
{
    public function __construct(
        public ?int $min = null,
        public ?int $max = null,
    ){}
}