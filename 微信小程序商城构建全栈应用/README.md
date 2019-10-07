# 导语
- 整体思路与编程思想 AOP 面向切面编程
- 具体的编程知识与技巧 TP5 小程序 数据库

# 课程内容与产品技术点
- ThinkPHP 5
    - 编写业务逻辑
    - 访问数据库
    - 向客户端提供数据
- MySQL
    - 数据存储
    - 数据表设计
    - 与业务精密集合
- 微信
    - 支付
    - 善于借鉴与模仿，学习微信接口设计
- 小程序
    - 直接与用户交互
    - 体验很重要

# 课程流程
- 服务端：
    - thinkPHP 5 + MySQL构建REST API
- 客户端：
    向服务端请求数据，完成自身行为逻辑
- CMS：
    向服务端请求数据，实现发货与发送微信消息

## 总结CMS的功能
两大类
- 基础数据的curd操作，比如添加商品，删除商品类目。
- 特殊操作，比如实现发送微信消息。

# 课程特点
- 通用适合互联网公司良好结构的产品
- 三端分离（客户端，服务端，数据管理分离）或 多端分离
- 基于REST API
- 基于Token令牌管理权限
- 一套架构适配 iOS Android 小程序 单页面
- 理解 MVC
- AOP 面向切面编程思想在真实项目中的应用
- 使用 ORM 的方式与数据库交互
- MySQL 数据表设计与数据冗余的合理利用
- 用面向对象的思维方式构建前端代码 （`ES6` `Class`&`Module`）

# 知识与技术
- ThinkPHP 5
    - Web框架三大核心功能（路由 控制器 模型）
    - 验证器 读取器 缓存 全局异常处理
    - ORM：模型与关联模型
- 微信
    - 微信小程序
    - 微信登录
    - 微信支付（预订单、支付库存量检查与回调通知处理）
    - 微信模板消息
- MySQL
    - 数据库表设计
    - 数据冗余的合理应用
    - 事务与锁在订单（库存量）检查中的应用
- 还有很多零碎的小知识 ...

# 前置知识
- PHP与面向对象的相关知识 OOP
- ThinkPHP 基本知识
- 关系型数据库 MySQL 基本使用
- 小程序常用 API
- 小程序账号

# 产品矩阵
**`网站`** **`iOS`** **`Android`** **`微信` -> `H5` -> `公众号`** **`小程序`**

# 项目独立命名
- 服务器程序：`Zerg`
- 客户端小程序：`Protoss`
- CMS：`Terran`

# **tp5 路由 - 「小知识」**
> eg: /application/route.php 
lilnk: [路由定义](https://www.kancloud.cn/manual/thinkphp5/118030)

```php
<?php

use think\Route;

// Route::rule('test/r','test/index/route','GET|POST', ['https'=>true]);
Route::get('test/r/:id','test/index/route');
```

# **tp5 验证 `Validate` - 「小知识」**
- 独立验证

```php
<?php
    
    // 独立验证
    
    $data = [
        'name' => 'vendor12345',
        'email' => 'vendorqq.com'
    ];

    $validate = new Validate([
        'name' => 'require|max:10',
        'email' => 'email'
    ]);

    $ret = $validate->batch()->check($data);
    dump($ret);
    dump($validate->getError());

```

- 验证器

建立验证器模块：`/test/validate/TestValidate`
```php
<?php
namespace app\test\validate;

use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email',
    ];
}
```

控制器使用方式：
```php
/**
 * 验证器 示例
 * @link /test/index/tmp_checkout_best
 */
public function tmp_checkout_best()
{
    $data = [
        'name' => 'vendor12345',
        'email' => 'vendorqq.com'
    ];

    $validate = new TestValidate();

    $ret = $validate->batch()->check($data);
    dump($ret);
    dump($validate->getError());
}
```

# 什么是REST
Representational State Transfer : 表述性状态转移
一种风格 约束 设计理念

#### HTTP动词 （幂等性、资源安全性）
POST：创建
PUT：更新
GET：查询
DELETE：删除

状态码：404 400 200 201 202 401 403 500
错误码：自定义的错误ID号
统一描述错误：错误码、错误信息、当前URL

使用Token令牌来授权和验证身份

版本控制

测试环境和生产环境分开

# 关于异常分类
- 由于用户行为导致的异常 通常不记录日志 需要向用户返回具体信息
- 服务器自身异常（代码错误方面）需要记录日志 不向客户端返回具体原因

# 自定义错误码（分类）
| 错误码 |  描述错误  |
| ------------ | ------------ |
|  999  |  未知错误  |
|  1  |  通用错误  |
|  2  |  商品类错误  |
|  3  |  主题类错误  |
|  4  |  Banner类错误  |
|  5  |  类目类错误  |
|  6  |  用户类错误  |
|  8  |  订单类错误  |
|    |    |
|  10000  |  通用参数错误  |
|  10001  |  资源未找到  |
|  10002  |  未授权（令牌不合法）  |
|  10003  |  尝试非法操作（自己的令牌操作其他人数据）  |
|  10004  |  授权失败（第三方应用账号登录失败）  |
|  10005  |  授权失败（服务器缓存异常）  |
|    |    |
|  20000  |  请求商品不存在  |
|  30000  |  请求主题不存在  |
|  40000  |  Banner不存在  |
|  50000  |  类目不存在  |
|  60000  |  用不不存在  |
|  60001  |  用户地址不存在  |
|  80000  |  订单不存在  |
|  80001  |  订单中的商品不存在，可能已被删除  |
|  80002  |  订单还未支付，却尝试发货  |
|  80003  |  订单已支付  |
|    |    |
|  ...  |  ...  |


