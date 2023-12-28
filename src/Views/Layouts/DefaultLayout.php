<?php
namespace App\Views\Layouts;

final class DefaultLayout {
	public function __construct(
		private string $title = '',
		private string $body = '',
	) {}

	public static function construct(
		string $title = '',
		string $body = '',
	): static {
		return new DefaultLayout($title, $body);
	}

	public function body(string $body): static {
		$this->body = $body;
		return $this;
	}

	public function title(string $title): static {
		$this->title = $title;
		return $this;
	}

	public function render(): string {
		return <<<EOF
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset='utf-8'/>
					<meta name='viewport' content='width=device-width,initial-scale=1'/>
					<title>{$this->title}</title>
				</head>
				<body>
					{$this->body}
				</body>
			</html>
		EOF;
	}
}
