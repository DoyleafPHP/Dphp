# Dphp
### **DoyleafPHP,A framework for PHP,by doylee and leaf**
### **一个复古贯彻MVC模式的微型框架**
### **采用GPL3.0开源协议**

---

## 架构模式
采用经典的webMVC架构，突出M层和V层的可重用性，降低C层的作用，还原MVC的本来面目(并没有)。
## 架构方法
使用composer来架构整个框架，提高程序的扩展性，保持组件版本的灵活控制。

使用 **[Packagist / Composer中国全量镜像](https://packagist.phpcomposer.com)**
## 路由
采用开源的nikic/fast-route路由，这个路由自称是最快的路由。
## 入口文件
>/public/index.php
## 安装方式
1. `composer create-project doylee/dphp <你的项目名>`
2. 将config/目录下的`db.php.example`复制出来一份，并重命名为`db.php`
3. 按照说明修改配置

___

## 代码规范
* 类的命名 **必须** 遵循 *StudlyCaps* 大写开头的驼峰命名规范
* 类中的常量所有字母都 **必须** 大写，单词间用 *下划线* 分隔
* 方法名称 **必须** 符合 *camelCase* 式的小写开头驼峰命名规范
* 类的属性命名 可以 遵循：
  * 大写开头的驼峰式 (*$StudlyCaps*)
  * 小写开头的驼峰式 (*$camelCase*)
  * 下划线分隔式 (*$under_score*)
