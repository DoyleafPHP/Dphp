# Dphp框架核心文件

## route.php      路由配置文件
 **路由规则**
 * 单个路由
 * 组路由
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
     ['GET','[/]','~'] # 或
     ['GET','[/]','']
     # 请求User类的actionIndex方法，并传入包含了id的参数
     ['POST','[/{id:\d+}]','~/add']
     ```