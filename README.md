# 🍄蘑菇丁 SDK
[![Total Downloads](https://poser.pugx.org/laradocs/moguding/d/total.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Stable Version](https://poser.pugx.org/laradocs/moguding/v/stable.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Unstable Version](https://poser.pugx.org/laradocs/moguding/v/unstable.svg)](https://packagist.org/packages/laradocs/moguding)
[![License](https://poser.pugx.org/laradocs/moguding/license.svg)](https://packagist.org/packages/laradocs/moguding)

🍄蘑菇丁自动签到|打卡组件

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

注：只要是返回的数据全部都是数组

如果没有数据会返回 空数组

请不要使用 isArray 来判断是不是登录失败等一系列操作。

敏感数据我会用 xx/xxx 代替，并不是返回的真实数据。

参数和返回的具体重要数据请往下看！！！


```php
use Laradocs\Moguding\Client;

$factory = new Client();
/**
 * 用户登录
 * 
 * @param string $device android|ios
 * @param string $phone 手机号码
 * @param string $password 密码
 * 
 * @return array
 */
$user = $factory->login ( $device, $phone, $password );
// 登录成功返回的重要数据
[
    "userId"   => "xxx",
    "token"    => "xxx",
    "userType" => "student" // 这里教师账号返回的应该是 teacher，我没测试过
]

/**
 * 获取计划
 * 
 * @param string $token $user['token'] // 用户登录后返回的数据
 * @param string $userType $user['userType'] // 同上
 * @param int $userId $user['userId'] // 同上
 * 
 * @return array
 */
$getPlan = $factory->getPlan ( $token, $userType, $userId );
// 获取计划返回的重要数据
// 注：这里是二维数组，可以用 foreach 遍历。
// 基本上都可以用 [0]['planId'] 取出来
// 如果是要符合大众就用 foreach 吧，特殊情况特殊处理。
[
    [
        "planId" => "xxx",
    ]
]

/**
 * 打卡保存
 * 
 * @param string $token $user['token'] // 这个是用户登录返回的数据
 * @param string $userId $user['userId'] // 同上
 * @param string $province 省 // 千万要打全 例如：上海市 / 江西省
 * @param string $city 市 // 千万要打全 例如：上海市（直辖市这里有个细节，也可以直接用 $province 变量） / 南昌市
 * @param string $address 详细地址（国家省市地址）可以在蘑菇丁上面看定位，直辖市的话就不要加省或市(例：国家省/市xx区地址)省和市二选一
 * @param float $longitude 经度 // 下面有说明
 * @param float $latitude 纬度 // 下面有说明
 * @param string $type START|END「START: 上班|END: 下班」
 * @param string $device android|ios
 * @param string $planId $getPlan['planId'] // 这个是获取计划返回的
 * @param string $description 备注（非必填）
 * @param string $country 国家（默认是中国）
 * 
 * @return array
 */
$save = $factory->save (
    $token,
    $userId,
    $province,
    $city,
    $address,
    $longitude,
    $latitude,
    $type,
    $device,
    $planId,
    $description,
    $country
);
// 打卡保存返回的数据
[
    "createTime" => "2022-01-15 07:08:49"
    "attendanceId" => "xxxxxxxxxxxxxxxxxxxxxxxx"
]
```

 📍 不知道自己所在的经纬度点击👉 [经纬度查询 - 坐标拾取系统](https://jingweidu.bmcx.com)

一般输入市区就可以了，例如 `南昌`（后面不要加 `市`）

---

> 新功能：Server 酱 - 消息通知

[Server 酱](https://sct.ftqq.com) 是一款「手机」和「服务器」、「智能设备」之间的通信软件。

说人话？就是从服务器、路由器等设备上推消息到手机的工具。

用法：

```php
/**
 * Server 酱 - 消息通知
 * 
 * @params string $title 标题
 * @params string $desp 后文
 * 
 * @return void
 */
$factory->sct_send ( SendKey, $title, $desp );
```

## 说明

如果有需要更改国家同学可以这么做：

```php
$save = $factory->save (
    ...
    '', // 使用 ''｜"" 做占位符
    '菲律宾'
);
```

如有其它疑问或问题，请在 **[Issues](https://github.com/laradocs/php-moguding-sdk/issues)** 提出。

## 协作

如果您想参与此项目，请点击右上角的 `Fork` 按钮，我们共同维护此项目。
