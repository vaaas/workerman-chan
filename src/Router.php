<?php
namespace App;

use App\Controllers\AttachmentController;
use App\Controllers\IndexController;
use App\Controllers\StaticController;
use Lib\Http\Router as BaseRouter;

class Router extends BaseRouter {
	public function __construct(
		IndexController $indexController,
		StaticController $staticController,
		AttachmentController $attachmentController,
	) {
		parent::__construct();

		$this
			->get('/', [$indexController, 'index'])
			->get('/favicon.ico', [$staticController, 'serve'])
			->get('/attachments/*', [$attachmentController, 'getAttachment'])
			->get('/thumbnails/*', [$attachmentController, 'getThumbnail']);
	}
}
