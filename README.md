## 基于ThinkPHP的Alipay和WeChat的支付、退款、支付查询SDK

## 安装
```shell
composer require fyflzjz/payment
```

## 支持的支付、查询、退款方法
### 1、支付宝
- 电脑支付
- 手机网站支付
- APP支付
- 查询支付结果
- 支付宝单笔退款查询
- 支付宝单笔退款
- 查询对账单下载地址
- 异步通知处理

### 2、微信
- 手机网站支付
- APP支付
- 查询支付结果
- 微信单笔退款查询
- 微信单笔退款
- 查询对账单下载地址
- 异步通知处理

## 使用方法
将test/Demo.php放在框架controller内，将PaymentModel.php放在框架model内，并更改命名空间和引用路径
- 具体使用方法见test/Demo.php


## 添加env配置
```php
//支付宝Aop配置
[AliPayAop]
app_id = ''
rsa_public_key = ''
rsa_private_key = ''

//微信支付JsApi配置
[WxPayJsApi]
app_id = ''
mch_id = ''
key = ''
app_secret = ''

//微信支付App配置
[WxPayApp]
app_id = ''
mch_id = ''
key = ''
app_secret = ''
```