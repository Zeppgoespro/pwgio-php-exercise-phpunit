<?php

namespace Tests\Unit;

class WithUnionTypes
{

  public function __construct(public string|null $variable)
  {
  }

}