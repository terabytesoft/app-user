<?php

return [
    // aplication:
	'app.id' => 'app-user',
    'app.name' => 'app-user',
    // debug
    'debug.allowedIPs' => ['127.0.0.1', '::1', '*'],
    // mailer:
	'mailer.useFileTransport' => true,
    // translator:
    'i18n.locale' => 'en',
    'i18n.encoding' => 'UTF-8',
    'translator.basePath' => '@app/user/messages',
    'translator.sourceLanguage' => 'en',
];
