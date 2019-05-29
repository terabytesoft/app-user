<?php

return [
    // aplication:
	'app.id' => 'my-project-user',
    'app.name' => 'My Project Basic',
    // db:
    'db.dns' => 'mysql:host=localhost;dbname=ModuleUser;charset=utf8',
    'db.username' => 'root',
    'db.password' => '',
    // debug:
    'debug.enabled' => false,
    'debug.allowedIPs' => ['127.0.0.1', '::1', '*', '192.168.1.108'],
    // mailer:
    'mailer.useFileTransport' => true,
    // translator:
    'i18n.locale' => 'en',
    'i18n.encoding' => 'UTF-8',
    'translator.basePath' => '@app/user/messages',
    'translator.sourceLanguage' => 'en',
];
