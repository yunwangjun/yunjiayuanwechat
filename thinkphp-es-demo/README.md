# ThinkPHP Elasticsearch 搜索引擎集成

这是一个基于 ThinkPHP 框架的 Elasticsearch 搜索引擎集成示例项目。

## 功能特性

- 文章索引创建
- 文档添加和批量索引
- 基础搜索功能
- 高级搜索（支持多字段、范围、精确匹配等）
- 高亮显示搜索结果
- 分页支持

## 安装依赖

```bash
composer install
```

## 环境配置

复制 `.env.example` 为 `.env` 并配置 Elasticsearch 连接参数：

```env
[ELASTICSEARCH]
ES_HOST = 127.0.0.1
ES_PORT = 9200
ES_SCHEME = http
```

## API 接口

### 1. 创建索引
```
POST /api/search/index
```

### 2. 添加文章
```
POST /api/search/articles
```
参数：
- id: 文章ID
- title: 标题
- content: 内容
- author: 作者
- created_at: 创建时间

### 3. 搜索文章
```
GET /api/search/articles
```
参数：
- keyword: 搜索关键词
- page: 页码（默认1）
- size: 每页数量（默认10）

### 4. 高级搜索
```
POST /api/search/articles/advanced
```
参数：
- keyword: 搜索关键词
- author: 作者
- start_date: 开始日期

### 5. 批量添加文章
```
POST /api/search/articles/batch
```
参数：
- articles: 文章数组

## 使用示例

### 创建索引
```bash
curl -X POST http://localhost:8000/api/search/index
```

### 添加文章
```bash
curl -X POST http://localhost:8000/api/search/articles \
  -H "Content-Type: application/json" \
  -d '{
    "id": 1,
    "title": "ThinkPHP Elasticsearch 集成",
    "content": "这是一个关于如何在ThinkPHP中集成Elasticsearch的教程",
    "author": "Developer",
    "created_at": "2025-01-01T00:00:00Z"
  }'
```

### 搜索文章
```bash
curl "http://localhost:8000/api/search/articles?keyword=elasticsearch&page=1&size=10"
```

## 服务类说明

### SearchService

核心搜索服务类，提供以下功能：
- `createArticleIndex()` - 创建文章索引
- `addArticle($article)` - 添加文章
- `searchArticles($keyword, $page, $size)` - 搜索文章
- `batchIndexArticles($articles)` - 批量索引
- `advancedSearch($conditions)` - 高级搜索

### ArticleSearchService

继承自 SearchService，可扩展特定于文章搜索的功能。

## 配置说明

- 配置文件位于 `config/elasticsearch.php`
- 支持环境变量配置
- 默认使用 ik_max_word 中文分词器

## 注意事项

1. 确保 Elasticsearch 服务正在运行
2. 如需使用中文分词，请安装 IK 分词器插件
3. 根据实际需求调整索引映射配置