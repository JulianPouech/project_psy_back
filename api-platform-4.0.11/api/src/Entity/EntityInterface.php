<?php

namespace App\Entity;

interface EntityInterface
{
    /**
    * @return array<string,mixed>
    **/
    public function getVisible(): array;
}
