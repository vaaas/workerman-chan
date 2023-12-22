<?php

namespace Lib\DependencyInjection;

use Exception;
use IContainer;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

class Container implements IContainer {
	private static ?Container $instance = null;

	/**
	 * @param array<class-string, class-string> $interfaces
	 * @param array<class-string, object> $instances
	 */
	private function __construct(
		private array $interfaces = [],
		private array $instances = [],
	) {}

	public static function getInstance(): IContainer {
		if (is_null(self::$instance))
			self::$instance = new Container();
		return self::$instance;
	}

	/**
	 * @param class-string $interface
	 * @param class-string $implementation
	 */
	public function register(string $interface, string $implementation): Container {
		$this->interfaces[$interface] = $implementation;
		return $this;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 */
	public function construct(string $class): object {
		if ($this->has($class))
			/** @var T */
			return $this->get($class);

		$reflection = new ReflectionClass($class);

		if ($reflection->isInterface()) {
			$interface = $class;
			if (!$this->isRegistered($interface))
				throw new Exception("Interface $interface does not have a registered implementation");
			/** @var class-string */
			$class = $this->getImplementation($interface);
		} else
			$interface = null;

		$constructor = $reflection->getConstructor();
		/** @var T */
		$instance =
			is_null($constructor)
			? new $class()
			: new $class(array_map($this->constructFromParameter(...), $constructor->getParameters()));

		$this->add($class, $instance);
		if ($interface)
			$this->add($interface, $instance);

		return $instance;
	}

	private function constructFromParameter(ReflectionParameter $x): object {
		$type = $x->getType();
		if (!$type)
			throw new Exception('No type hint found');
		if (!($type instanceof ReflectionNamedType))
			throw new Exception('Union and intersection types are not supported');
		/** @var class-string */
		$class = $type->getName();
		return $this->construct($class);
	}

	public function call(callable $f): mixed {
		return $f();
	}

	public function has(string $class): bool {
		return array_key_exists($class, $this->instances);
	}

	/** @param class-string $interface */
	public function isRegistered(string $interface): bool {
		return array_key_exists($interface, $this->interfaces);
	}

	/**
	 * @param class-string $interface
	 * @return ?class-string
	 */
	public function getImplementation(string $interface): ?string {
		return $this->interfaces[$interface];
	}

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return ?T
	 */
	public function get(string $class): ?object {
		/** @var ?T */
		return $this->instances[$class];
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
}
