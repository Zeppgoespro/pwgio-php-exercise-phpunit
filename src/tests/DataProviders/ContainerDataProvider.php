<?php

declare(strict_types=1);

namespace Tests\DataProviders;

class ContainerDataProvider
{

  public static function resolveTypeCases(): array
  {
    return [
      # Missing type hint scenario
      ['Tests\Unit\WithoutTypeHinting'],
      # Union type scenario
      ['Tests\Unit\WithUnionTypes']
    ];
  }

}