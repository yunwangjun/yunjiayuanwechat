<?php
// demo.php - 演示如何使用 Elasticsearch 搜索服务

echo "ThinkPHP Elasticsearch 搜索服务演示\n";
echo "=====================================\n\n";

// 显示可用方法
echo "1. 可用功能:\n";
echo "   - createArticleIndex() : 创建文章索引\n";
echo "   - addArticle(\$article) : 添加文章\n";
echo "   - searchArticles(\$keyword, \$page, \$size) : 搜索文章\n";
echo "   - batchIndexArticles(\$articles) : 批量添加文章\n";
echo "   - advancedSearch(\$conditions) : 高级搜索\n\n";

echo "2. 使用示例:\n";
echo '   $article = [' . "\n";
echo "       'id' => 1,\n";
echo "       'title' => 'ThinkPHP Elasticsearch 集成',\n";
echo "       'content' => '这是一个关于如何在ThinkPHP中集成Elasticsearch的教程',\n";
echo "       'author' => 'Developer',\n";
echo "       'created_at' => date('c')\n";
echo "   ];\n";
echo "   \$searchService = new \\app\\services\\ArticleSearchService();\n";
echo "   \$result = \$searchService->addArticle(\$article);\n\n";

echo "3. API 接口:\n";
echo "   GET  /api/search/articles?keyword=xxx&page=1&size=10\n";
echo "   POST /api/search/articles\n";
echo "   POST /api/search/articles/batch\n";
echo "   POST /api/search/articles/advanced\n";
echo "   POST /api/search/index\n\n";

echo "4. 项目结构:\n";
echo "   /app/controller/SearchController.php - 控制器\n";
echo "   /services/SearchService.php - 搜索服务\n";
echo "   /services/ArticleSearchService.php - 文章搜索服务\n";
echo "   /config/elasticsearch.php - ES配置\n";
echo "   /route/app.php - 路由配置\n\n";

echo "注意: 请确保 Elasticsearch 服务已启动并正确配置 .env 文件中的连接参数。\n";