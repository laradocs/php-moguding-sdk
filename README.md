# 🍄蘑菇丁 SDK
[![Total Downloads](https://poser.pugx.org/laradocs/moguding/d/total.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Stable Version](https://poser.pugx.org/laradocs/moguding/v/stable.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Unstable Version](https://poser.pugx.org/laradocs/moguding/v/unstable.svg)](https://packagist.org/packages/laradocs/moguding)
[![License](https://poser.pugx.org/laradocs/moguding/license.svg)](https://packagist.org/packages/laradocs/moguding)
[![StyleCI](https://github.styleci.io/repos/447994762/shield?branch=master)](https://github.styleci.io/repos/447994762?branch=master)
[![Test](https://github.com/laradocs/php-moguding-sdk/actions/workflows/test.yml/badge.svg)](https://github.com/laradocs/php-moguding-sdk/actions/workflows/test.yml)

🍄蘑菇丁自动签到|打卡组件

## 交流

[交流群](https://qm.qq.com/cgi-bin/qm/qr?k=zbymM6W3sUh11Sjx9ZVDo8vbwL2YpWkL&jump_from=webapi) ID: 253228619

## PHP 版本

PHP 需要 8.0 或以上版本

## 安装

```php
composer require laradocs/moguding
```

### 更新

```
composer update laradocs/moguding
```

## 用法

### 获取用户信息

```php
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\LoginParam;
use Laradocs\Moguding\Params\Login;

$moguding = new Moguding();
$user = $mogiding->getUserProfile(new LoginParam(
    new Login('操作系统(android/ios)', '手机号码', '密码')
));

var_dump($user); // 见 返回示例
```

返回示例(重要数据)：

```php
[
    "token"    => 'xxxxxx',
    "userId"   => '用户ID',
    "userType" => 'student',
    .
    .
    .
]
```

### 获取计划列表

```php
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\UserParam;
use Laradocs\Moguding\Params\User;

$moguding = new Moguding();
$plans = $moguding->getPlanList(new UserParam(
    new User($user['token'], $user['userId'], $user['userType'])
));

var_dump($plans); // 见 返回示例
```

返回示例(重要数据)：

```php
[
    [
        "planId" => "xxxxxx",
        .
        .
        .
    ]
]
```

### 获取打卡信息


📍 不知道自己所在的经纬度点击👉 [经纬度查询 - 坐标拾取系统](https://jingweidu.bmcx.com)

```php
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\SaveParam;
use Laradocs\Moguding\Params\Save;
use Laradocs\Moguding\Params\User;
use Laradocs\Moguding\Params\Address;

$moguding = new Moguding();
$save = $moguding->getSaveInfo(new SaveParam(
    new Save(
        new User($user['token'], $user['userId'], $user['userType']),
        new Address('所在省份', '所在城市(直辖市的同学传 null 就行)', '详细地址', '经度', '纬度', '所在国家(默认：中国)'),
        $plans[0]['planId'],
        '操作系统(android/ios)',
        '打卡类型(START/END)', // START: 上班 END: 下班
        '备注(非必填)'
    )
))

var_dump($save); // 见 返回示例
```

返回示例(重要数据)：

```
[
    "createTime"   => "2022-01-15 07:08:49",
    "attendanceId" => "xxxxxxxxxxxxxxxxxxx",
    .
    .
    .
]
```

### 通知推送

#### Server 酱

在使用此功能之前，你需要去 [Server 酱](https://sct.ftqq.com) 注册账号，然后获取 SendKey。

```php
use Laradocs\Moguding\Plugins\ServerChan;

$message = new ServerChan('SendKey');
$message->title('推送标题') // 必须
        ->desp('推送正文') // 非必须
        ->channel(['推送通道']) // 非必须
        ->send(); // 发送通知
```

## 协作

如果您想参与此项目，请点击右上角的 `Fork` 按钮，我们共同维护此项目。

## Project supported by JetBrains

Many thanks to Jetbrains for kindly providing a license for me to work on this and other open-source projects.

[![JetBrains](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/laradocs)
