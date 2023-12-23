<?php

namespace Lib\DependencyInjection;

use Closure;
use Exception;
use Lib\Arr;
use Lib\DependencyInjection\IContainer;
use Lib\SMap;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

class Container implements IContainer {
	/**
	 * @param SMap<class-string, class-string> $interfaces
	 * @param SMap<class-string, object> $instances
	 */
	public function __construct(
		private SMap $interfaces = new SMap(),
		private SMap $instances = new SMap(),
	) {}

	/**
	 * @param class-string $interface
	 * @param class-string $implementation
	 */
	public function register(string $interface, string $implementation): Container {
		$this->interfaces->set($interface, $implementation);
		return $this;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return IContainer
	 */
	public function add(string $class, object $instance): IContainer {
		$instances[$class] = $instance;
		return $this;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 */
	public function construct(string $class): object {
		if ($this->instances->has($class))
			/** @var T */
			return $this->instances->get($class);

		$reflection = new ReflectionClass($class);

		if ($reflection->isInterface()) {
			$interface = $class;
			if (!$this->interfaces->has($interface))
				throw new Exception("Interface $interface does not have a registered implementation");
			/** @var class-string */
			$class = $this->interfaces->get($interface);
		} else
			$interface = null;

		$constructor = $reflection->getConstructor();
		/** @var T */
		$instance = is_null($constructor)
			? new $class()
			: new $class(...$this->resolveParameters($constructor));

		$this->instances->set($class, $instance);
		if ($interface)
			$this->instances->set($interface, $instance);

		return $instance;
	}

	public function call(Closure $f): mixed {
		$reflection = new ReflectionFunction($f);
		return $f(...$this->resolveParameters($reflection));
	}

	/** @return Arr<object> @params */
	private function resolveParameters(ReflectionFunction | ReflectionMethod $reflection): Arr {
		return Arr::from($reflection->getParameters())->map($this->resolveParameter(...));
	}

	private function resolveParameter(ReflectionParameter $x): object {
		$type = $x->getType();
		if (!$type)
			throw new NoTypeHint($x->getName());
		if (!($type instanceof ReflectionNamedType))
			throw new UnsupportedType($x->getName());
		/** @var class-string */
		$class = $type->getName();
		return $this->construct($class);
	}
}
