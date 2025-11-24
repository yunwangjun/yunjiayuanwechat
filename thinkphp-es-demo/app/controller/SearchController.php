<?php
// app/controller/SearchController.php
namespace app\controller;

use app\BaseController;
use app\services\ArticleSearchService;
use think\Request;

class SearchController extends BaseController
{
    protected $searchService;
    
    public function __construct()
    {
        $this->searchService = new ArticleSearchService();
    }
    
    // 创建文章索引
    public function createIndex()
    {
        try {
            $result = $this->searchService->createArticleIndex();
            return json(['success' => true, 'message' => 'Index created successfully', 'data' => $result]);
        } catch (\Exception $e) {
            return json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // 添加文章
    public function addArticle(Request $request)
    {
        $article = $request->param();
        
        // 验证必要字段
        if (empty($article['id']) || empty($article['title']) || empty($article['content'])) {
            return json(['success' => false, 'message' => 'Missing required fields']);
        }
        
        try {
            $result = $this->searchService->addArticle($article);
            return json(['success' => true, 'message' => 'Article added successfully', 'data' => $result]);
        } catch (\Exception $e) {
            return json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // 搜索文章
    public function searchArticles(Request $request)
    {
        $keyword = $request->param('keyword', '');
        $page = (int)$request->param('page', 1);
        $size = (int)$request->param('size', 10);
        
        if ($page < 1) $page = 1;
        if ($size < 1 || $size > 100) $size = 10;
        
        try {
            $result = $this->searchService->searchArticles($keyword, $page, $size);
            return json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            return json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // 高级搜索
    public function advancedSearch(Request $request)
    {
        $conditions = $request->param();
        
        try {
            $result = $this->searchService->advancedSearch($conditions);
            return json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            return json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // 批量添加文章
    public function batchAddArticles(Request $request)
    {
        $articles = $request->param('articles');
        
        if (empty($articles) || !is_array($articles)) {
            return json(['success' => false, 'message' => 'Invalid articles data']);
        }
        
        try {
            $result = $this->searchService->batchIndexArticles($articles);
            return json(['success' => true, 'message' => 'Articles indexed successfully', 'data' => $result]);
        } catch (\Exception $e) {
            return json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}