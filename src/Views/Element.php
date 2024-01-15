<?php
namespace App\Views;

use Lib\Arr;
use Lib\SMap;
use Stringable;

class Element implements Stringable {
	/**
	 * @param SMap<string, string> $properties
	 * @param Arr<string> $children
	 */
	public function __construct(
		private string $tag = 'div',
		private SMap $properties = new SMap(),
		private Arr $children = new Arr(),
	) {}

	/**
	 * @param SMap<string, string> $properties
	 * @param Arr<string> $children
	 */
	public static function construct(
		string $tag = 'div',
		SMap $properties = new SMap(),
		Arr $children = new Arr(),
	): static {
		return new static($tag, $properties, $children);
	}

	public function __toString(): string {
		$props = $this->properties
			->entries()
			->map(fn($x) => "{$x[0]}='{$x[1]}'")
			->join(' ');

		$children = $this->children->join(' ');

		if ($children)
			return "<{$this->tag} {$props}>{$children}</{$this->tag}>";
		else
			return "<{$this->tag} {$props}/>";
	}

	public function tag(string $x): static {
		$this->tag = $x;
		return $this;
	}

	public function prop(string $k, string $v): static {
		$this->properties->set($k, $v);
		return $this;
	}

	public function child(string $x): static {
		$this->children->add($x);
		return $this;
	}

	/** @param array<string, bool> $classes */
	public function classes(array $classes): static {
		$arr = new Arr();
		foreach ($classes as $k => $v) {
			if ($v) $arr->add($k);
		}
		$this->prop('class', $arr->join(' '));
		return $this;
	}
}
