# 모의해킹의 목적

본 프로젝트의 목적은 웹 애플리케이션의 보안 취약점을 찾고, 개선할 수 있는 방안을 모색하는 것입니다.

이를 위해, 현재 프로젝트에서는 일부 취약점을 일부러 만들어서 모의해킹을 수행하였습니다. 
# 사용한 도구와 기술
- Burp Suite Community Edition
- Ubuntu Server 22.04.1 TLS
- Apache 2.4.52
- PHP 8.1.2
# 모의해킹 웹 서버 파일
## 파일 구성

- board.php
- changepw.php
- changepw_do.php
- connect.php
- login_check.php
- login2.php
- logout.php
- view.php
- write.php
- write_save.php

# 모의 해킹에 사용된 취약점
## [SQL Injection](https://github.com/MLTree2/HK/tree/master/webH/1.%20SQL_Injection)
- 로그인 환경과 게시판환경에서의 SQL Injection을 이용하여 DB 정보 탈취
## [XSS(Cross-Site Scripting)](https://github.com/MLTree2/HK/tree/master/webH/2.%20XSS)
- 게시판에서의 XSS 취약점을 이용한 사용자 쿠키 탈취후 공격자 서버로 전송
## [File Upload](https://github.com/MLTree2/HK/tree/master/webH/3.%20File%20Upload)
- 게시판에서의 파일 업로드기능을 이용하여 웹쉘 업로드
## [CSRF(Cross-Site Request Forgery)](https://github.com/MLTree2/HK/tree/master/webH/4.%20CSRF)
- 게시판의 취약점을 이용하여 비밀번호변경 페이지를 이용하여 사용자의 비밀번호를 변경
