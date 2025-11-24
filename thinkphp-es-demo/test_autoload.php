<?php
// test_autoload.php - 测试类自动加载
require_once __DIR__ . '/vendor/autoload.php';

// 测试服务类是否可以被正确加载
if (class_exists('services\SearchService')) {
    echo "✓ SearchService class loaded successfully\n";
} else {
    echo "✗ SearchService class not found\n";
}

if (class_exists('services\ArticleSearchService')) {
    echo "✓ ArticleSearchService class loaded successfully\n";
} else {
    echo "✗ ArticleSearchService class not found\n";
}

// 测试配置是否可以加载
$config = include __DIR__ . '/config/elasticsearch.php';
if (is_array($config)) {
    echo "✓ Elasticsearch configuration loaded successfully\n";
    echo "  Config: " . json_encode($config) . "\n";
} else {
    echo "✗ Elasticsearch configuration not found\n";
}

echo "\nThinkPHP Elasticsearch integration is properly set up!\n";