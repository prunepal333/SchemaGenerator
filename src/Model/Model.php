<?php
namespace Ass\Model;
use Ass\Base;
abstract class Model extends Base
{
    abstract public function find(int $id);
    abstract public function save();
}