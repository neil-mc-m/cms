<?php
require_once 'bootstrap.php';
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'CMS\\Controllers\\MainController::indexAction');
$app->get('/home', 'CMS\\Controllers\\MainController::indexAction');

$app->get('/login', 'CMS\\Controllers\\SecurityController::logInAction');
$app->get('/admin', 'CMS\\Controllers\\SecurityController::logInAction');

$app->get('/search/{q}', 'CMS\\Controllers\\SearchController::searchAction');
$app->get('/search-results/{contentId}', 'CMS\\Controllers\\SearchController::userAction');
$app->get('/{pageRoute}', 'CMS\\Controllers\\MainController::routeAction');

$app->get('/admin/logout', 'CMS\\Controllers\\SecurityController::logoutAction');

$app->get('/admin/dashboard', 'CMS\\Controllers\\AdminController::dashboardAction');

$app->get('/admin/pages', 'CMS\\Controllers\\PagesController::pagesAction');
$app->get('/admin/view-pages', 'CMS\\Controllers\\PagesController::viewPagesAction');

$app->get('/admin/create-page', 'CMS\\Controllers\\PagesController::createPageAction');
$app->post('/admin/new-page', 'CMS\\Controllers\\PagesController::newPageAction');

$app->get('/admin/delete-page', 'CMS\\Controllers\\PagesController::deletePageAction');
$app->post('/admin/process-delete-page', 'CMS\\Controllers\\PagesController::processDeletePageAction');

$app->get('/admin/view-content', 'CMS\\Controllers\\ContentController::contentAction');
$app->get('/admin/view-single-content/{contentId}', 'CMS\\Controllers\\ContentController::singleContentAction');

$app->get('/admin/create-content', 'CMS\\Controllers\\ContentController::createContentFormAction');
$app->post('/admin/process-content', 'CMS\\Controllers\\ContentController::processContentAction');

$app->get('/admin/delete-content', 'CMS\\Controllers\\ContentController::deleteContentFormAction');
$app->get('/admin/process-delete-content/{contentId}', 'CMS\\Controllers\\ContentController::processDeleteContentAction');

$app->get('/admin/edit-content/{contentId}', 'CMS\\Controllers\\ContentController::editContentAction');
$app->post('/admin/process-edit-content', 'CMS\\Controllers\\ContentController::processEditContentAction');

$app->get('/admin/images', 'CMS\\Controllers\\ImageController::viewImagesAction');
$app->post('/admin/add-image', 'CMS\\Controllers\\ImageController::addImageAction');
$app->get('/admin/upload-image', 'CMS\\Controllers\\ImageController::uploadImageFormAction');

$app->post('/admin/process-imageUpload', 'CMS\\Controllers\\UploadController::processImageUploadAction');

$app->get('/{pageRoute}/{contentId}', 'CMS\\Controllers\\MainController::oneArticleAction');
$app->run();
