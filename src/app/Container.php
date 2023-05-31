<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use App\Exception\Container\ContainerException;

class Container implements ContainerInterface
{

  private array $entries = [];

  public function get(string $id)
  {
    if ($this->has($id)):
      $entry = $this->entries[$id];

      if(is_callable($entry)):
        return $entry($this);
      endif;

      # return $this->resolve($entry);
      $id = $entry;
    endif;

    return $this->resolve($id); # AUTOWIRING STARTS HERE
  }

  public function has(string $id): bool
  {
    return isset($this->entries[$id]);
  }

  public function set(string $id, callable|string $concrete): void
  {
    $this->entries[$id] = $concrete;
  }

  public function resolve(string $id) # AUTOWIRING
  {
    # 1. Inspect the class that we are trying to get from container.
    $reflection_class = new \ReflectionClass($id); # REFLECTION API

    if (! $reflection_class->isInstantiable()):
      throw new ContainerException('Class "' . $id . '" is not instantiable');
    endif;

    # 2. Inspect the constructor of the class.
    $constructor = $reflection_class->getConstructor();

    if (! $constructor):
      #$reflection_class->newInstance();
      return new $id;
    endif;

    # 3. Inspect the constructor parameters (dependencies).
    $parameters = $constructor->getParameters();

    if (! $parameters ):
      return new $id;
    endif;

    # 4. If the constructor parameter is a class then try to resolve that class using the container.
    $dependencies = array_map(function (\ReflectionParameter $param) use ($id) {
      $name = $param->getName();
      $type = $param->getType();

      if (! $type):
        throw new ContainerException('Failed to resolve class "' . $id . '" because parameter"' . $name . '" is missing a type hint');
      endif;

      if ($type instanceof \ReflectionUnionType):
        throw new ContainerException('Failed to resolve class "' . $id . '" because of union type for parameter"' . $name . '"');
      endif;

      if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()):
        return $this->get($type->getName());
      endif;

      throw new ContainerException('Failed to resolve class "' . $id . '" because of invalid parameter"' . $name . '"');

    }, $parameters);

    return $reflection_class->newInstanceArgs($dependencies);
  }

}