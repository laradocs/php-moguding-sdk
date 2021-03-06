# ðèèä¸ SDK
[![Total Downloads](https://poser.pugx.org/laradocs/moguding/d/total.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Stable Version](https://poser.pugx.org/laradocs/moguding/v/stable.svg)](https://packagist.org/packages/laradocs/moguding)
[![Latest Unstable Version](https://poser.pugx.org/laradocs/moguding/v/unstable.svg)](https://packagist.org/packages/laradocs/moguding)
[![License](https://poser.pugx.org/laradocs/moguding/license.svg)](https://packagist.org/packages/laradocs/moguding)
[![StyleCI](https://github.styleci.io/repos/447994762/shield?branch=master)](https://github.styleci.io/repos/447994762?branch=master)
[![Test](https://github.com/laradocs/php-moguding-sdk/actions/workflows/test.yml/badge.svg)](https://github.com/laradocs/php-moguding-sdk/actions/workflows/test.yml)

ðèèä¸èªå¨ç­¾å°|æå¡ç»ä»¶

## äº¤æµ

[äº¤æµç¾¤](https://qm.qq.com/cgi-bin/qm/qr?k=zbymM6W3sUh11Sjx9ZVDo8vbwL2YpWkL&jump_from=webapi) ID: 253228619

## PHP çæ¬

PHP éè¦ 8.0 æä»¥ä¸çæ¬

## å®è£

```php
composer require laradocs/moguding
```

### æ´æ°

```
composer update laradocs/moguding
```

## ç¨æ³

### è·åç¨æ·ä¿¡æ¯

```php
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\LoginParam;
use Laradocs\Moguding\Params\Login;

$moguding = new Moguding();
$user = $mogiding->getUserProfile(new LoginParam(
    new Login('æä½ç³»ç»(android/ios)', 'ææºå·ç ', 'å¯ç ')
));

var_dump($user); // è§ è¿åç¤ºä¾
```

è¿åç¤ºä¾(éè¦æ°æ®)ï¼

```php
[
    "token"    => 'xxxxxx',
    "userId"   => 'ç¨æ·ID',
    "userType" => 'student',
    .
    .
    .
]
```

### è·åè®¡ååè¡¨

```php
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\UserParam;
use Laradocs\Moguding\Params\User;

$moguding = new Moguding();
$plans = $moguding->getPlanList(new UserParam(
    new User($user['token'], $user['userId'], $user['userType'])
));

var_dump($plans); // è§ è¿åç¤ºä¾
```

è¿åç¤ºä¾(éè¦æ°æ®)ï¼

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

### è·åæå¡ä¿¡æ¯


ð ä¸ç¥éèªå·±æå¨çç»çº¬åº¦ç¹å»ð [ç»çº¬åº¦æ¥è¯¢ - åæ æ¾åç³»ç»](https://jingweidu.bmcx.com)

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
        new Address('æå¨çä»½', 'æå¨åå¸(ç´è¾å¸çåå­¦ä¼  null å°±è¡)', 'è¯¦ç»å°å', 'ç»åº¦', 'çº¬åº¦', 'æå¨å½å®¶(é»è®¤ï¼ä¸­å½)'),
        $plans[0]['planId'],
        'æä½ç³»ç»(android/ios)',
        'æå¡ç±»å(START/END)', // START: ä¸ç­ END: ä¸ç­
        'å¤æ³¨(éå¿å¡«)'
    )
))

var_dump($save); // è§ è¿åç¤ºä¾
```

è¿åç¤ºä¾(éè¦æ°æ®)ï¼

```
[
    "createTime"   => "2022-01-15 07:08:49",
    "attendanceId" => "xxxxxxxxxxxxxxxxxxx",
    .
    .
    .
]
```

### éç¥æ¨é

#### Server é±

å¨ä½¿ç¨æ­¤åè½ä¹åï¼ä½ éè¦å» [Server é±](https://sct.ftqq.com) æ³¨åè´¦å·ï¼ç¶åè·å SendKeyã

```php
use Laradocs\Moguding\Plugins\ServerChan;

$message = new ServerChan('SendKey');
$message->title('æ¨éæ é¢') // å¿é¡»
        ->desp('æ¨éæ­£æ') // éå¿é¡»
        ->channel(['æ¨ééé']) // éå¿é¡»
        ->send(); // åééç¥
```

## åä½

å¦ææ¨æ³åä¸æ­¤é¡¹ç®ï¼è¯·ç¹å»å³ä¸è§ç `Fork` æé®ï¼æä»¬å±åç»´æ¤æ­¤é¡¹ç®ã

## Project supported by JetBrains

Many thanks to Jetbrains for kindly providing a license for me to work on this and other open-source projects.

[![JetBrains](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/laradocs)
