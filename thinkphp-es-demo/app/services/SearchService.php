<?php
// app/services/SearchService.php
namespace app\services;

use Elasticsearch\ClientBuilder;

class SearchService
{
    protected $client;
    
    public function __construct()
    {
        $config = config('elasticsearch');
        $this->client = ClientBuilder::create()
            ->setHosts([$config['host'] . ':' . $config['port']])
            ->build();
    }
    
    // 创建文章索引
    public function createArticleIndex()
    {
        $params = [
            'index' => 'articles',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word', // 使用中文分词器
                            'search_analyzer' => 'ik_smart'
                        ],
                        'content' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word'
                        ],
                        'author' => ['type' => 'keyword'],
                        'created_at' => ['type' => 'date']
                    ]
                ]
            ]
        ];
        
        return $this->client->indices()->create($params);
    }
    
    // 添加文档
    public function addArticle($article)
    {
        $params = [
            'index' => 'articles',
            'id'    => $article['id'],
            'body'  => [
                'title' => $article['title'],
                'content' => $article['content'],
                'author' => $article['author'],
                'created_at' => $article['created_at']
            ]
        ];
        
        return $this->client->index($params);
    }
    
    // 搜索文档
    public function searchArticles($keyword, $page = 1, $size = 10)
    {
        $params = [
            'index' => 'articles',
            'body'  => [
                'from' => ($page - 1) * $size,
                'size' => $size,
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['title^3', 'content'], // title权重更高
                        'type' => 'best_fields'
                    ]
                ],
                'highlight' => [
                    'fields' => [
                        'title' => new \stdClass(),
                        'content' => new \stdClass()
                    ]
                ]
            ]
        ];
        
        $response = $this->client->search($params);
        
        // 处理结果
        $results = [];
        foreach ($response['hits']['hits'] as $hit) {
            $result = $hit['_source'];
            $result['highlight'] = $hit['highlight'] ?? [];
            $results[] = $result;
        }
        
        return [
            'total' => $response['hits']['total']['value'],
            'data' => $results
        ];
    }
    
    // 批量索引文章
    public function batchIndexArticles($articles)
    {
        $params = ['body' => []];
        
        foreach ($articles as $article) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'articles',
                    '_id' => $article['id']
                ]
            ];
            
            $params['body'][] = [
                'title' => $article['title'],
                'content' => $article['content'],
                'author' => $article['author'],
                'created_at' => $article['created_at']
            ];
        }
        
        return $this->client->bulk($params);
    }
    
    // 复杂搜索
    public function advancedSearch($conditions)
    {
        $must = [];
        
        if (!empty($conditions['keyword'])) {
            $must[] = [
                'multi_match' => [
                    'query' => $conditions['keyword'],
                    'fields' => ['title^3', 'content']
                ]
            ];
        }
        
        if (!empty($conditions['author'])) {
            $must[] = ['term' => ['author' => $conditions['author']]];
        }
        
        if (!empty($conditions['start_date'])) {
            $must[] = [
                'range' => [
                    'created_at' => ['gte' => $conditions['start_date']]
                ]
            ];
        }
        
        $params = [
            'index' => 'articles',
            'body' => [
                'query' => ['bool' => ['must' => $must]]
            ]
        ];
        
        return $this->client->search($params);
    }
}