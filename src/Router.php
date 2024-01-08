<?php
namespace App;

use App\Controllers\AttachmentController;
use App\Controllers\BoardController;
use App\Controllers\IndexController;
use App\Controllers\StaticController;
use Lib\Http\Router as BaseRouter;

class Router extends BaseRouter {
	public function __construct(
		AttachmentController $attachmentController,
		BoardController $boardController,
		IndexController $indexController,
		StaticController $staticController,
	) {
		parent::__construct();

		$this
			->get('/', [$indexController, 'index'])
			->get('/favicon.ico', [$staticController, 'serve'])
			->get('/attachments/*', [$attachmentController, 'getAttachment'])
			->get('/thumbnails/*', [$attachmentController, 'getThumbnail'])
			->get('/*/', [$boardController, 'index']);
	}
}
