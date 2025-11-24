<?php
// route/app.php
use think\facade\Route;

// 搜索相关路由
Route::group('api', function () {
    Route::get('search/articles', 'SearchController/searchArticles');
    Route::post('search/articles', 'SearchController/addArticle');
    Route::post('search/articles/batch', 'SearchController/batchAddArticles');
    Route::post('search/articles/advanced', 'SearchController/advancedSearch');
    Route::post('search/index', 'SearchController/createIndex');
});