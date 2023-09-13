Здравствуй, дорогой друг! Это моё самостоятельное выполнение с помощью <b>'PHPUnit'</b> задания из курса <b>'Learn PHP the Right Way'</b> от <b>'Program with Gio'</b>.<br/>

Чтобы запустить у себя, делай следующее:<br/>

1. <b>'git clone'</b> его туда, куда тебе удобно.
2. Переходи в <b>'root'</b>, дальше в <b>'src'</b>, там копируй <b>'.env.example'</b> в <b>'.env'</b>.
3. Заходи в папку <b>'docker'</b> и запускай оттуда Докер - <b>'docker-compose up -d'</b>.
4. Заходи в контейнер <b>'pwgio-app'</b>, там делай <b>'composer install'</b>.
5. Возвращайся в <b>'src'</b>, запускай там командную строку, пиши <b>'./vendor/bin/phpunit tests/Unit/*TESTNAME*.php'</b>, например: <b>'./vendor/bin/phpunit tests/Unit/ContainerTest.php'</b>.

Всё супер!

Если лень всё это делать, просто зайди в папку <b>'1_screenshots'</b>. Там всё есть!
