# Dphp框架核心文件

## route.php      路由配置文件
 **路由规则**
 * 单个路由
    * 使用（配置中的）默认类和默认方法（首页）
    ```
    如：['GET','[/]','']
    ```
    * 指定要调用的方法，默认类
    ```
    如：['POST','/article','/addArt']
    或：['POST','/article','~/addArt']
    ```
    * 指定要调用的类，默认方法（末尾`/`可省略）
    ```
    如：['GET','/admin','admin']
    或：['GET','/admin','admin/']
    ```
    * 指定要调用的类和方法
    ```
    如：['POST','/admin','admin/login']
    ```
 * 组路由（单个写法同上）
 * 组路由应用
   * 统一前缀，
     如：    \
     前缀为 admin，组员为 users，
     则组合后为`adminUsers`
   * Restful API，
     如：
     前缀为 user，
     组员为 GET/POST/PUT/DELETE 四种方法，
     不区分大小写，
     可以通过第三个元素指定要请求的方法，
     ```
     # GET请求User类的（配置中的）默认方法
     ['GET','[/]','~'] # 或
     ['GET','[/]','']
     
     # POST请求User类中的add方法，并传入包含了id的参数
     ['POST','[/{id:\d+}]','~/add']
     ```