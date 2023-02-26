# SQL_Injection 모의해킹

이 예시는 SQL_Injection 공격에 대한 모의해킹을 실습해보는 예시이며, 로그인과 게시판 형태의 form에서 여러가지 기법을 이용하여 SQL_Injection을 수행합니다.


## 로그인 화면

[로그인화면 사진]


위 웹페이지에서는 로그인 기능을 제공하며, 아이디와 비밀번호를 입력한 뒤 로그인 버튼을 누르면 해당 정보를 토대로 데이터베이스에서  
유저 정보를 가져와 비교하여 로그인 성공여부를 결정합니다.


### 기본 SQL_Injection 공격
다음과 같이 id 입력란에 **'** 를 입력하여 SQL_Injection 공격에 취약한지 확인합니다.

[취약확인 사진 ,  오류발생 사진]

오류가 발생하여 SQL_Injection에 취약점이 있는것으로 짐작할 수 있습니다.

다음은 위의 로그인 폼에서 사용되는 취약한 로그인 쿼리입니다.
``` html
$query = "SELECT * FROM users WHERE id='$id' AND pw='$pw'";
```
다음과 같이 id 입력란에 **'or 1=1 #** 을 입력하면 쿼리에는 
```sql
SELECT * FROM users WHERE id=''or 1=1 #' AND pw='$pw'
```
위와같이 입력되게 되며 쿼리의 조건문이 항상 참이되어 모든 사용자의 정보를 가져올 수 있게되며, 후속 조건문에 의하여 결과값의 가장 첫번째 값인 admin으로 로그인 할 수 있습니다.

[인젝션 사진, 로그인성공 사진]

### Blind_SQL_Injection 공격

## 게시판 화면

[게시판 화면 사진]

위 웹페이지에서는 게시판 기능을 제공하며, 게시글 검색기능을 제공하고 글쓰기를 통하여 첨부파일 포함한 글을 올릴수 있습니다.

### UNION-Based SQL_Injection

게시글 검색에 사용되는 쿼리는 다음과 같으며, 기존의 예시들과 같은 방법으로 SQL_Injection 공격을 수행할 수 있습니다.

``` html
$query = "select * from board where subject LIKE '%$search%'";
```

**1. 컬럼의 개수 찾기**

검색란에 `' UNION SELECT ALL 1,2,3,... # ` 을 입력하여 숫자를 증가시켜 가며 입력하여 컬럼의 개수를 찾습니다.

[컬럼개수 찾기 사진]

**2. 테이블 이름 찾기**

검색란에 `' UNION SELECT ALL 1,table_name,3,4,5,6 FROM information_schema.tables WHERE table_schema=database()#` 을 입력하여 테이블의 이름을 찾습니다.

[테이블 이름찾기 사진]

**3. 원하는 테이블의 컬럼 이름 찾기**

검색란에 2번에서 얻은 테이블 이름을 이용하여 
`' UNION SELECT ALL 1,column_name,3,4,5,6 FROM information_schema.columns where table_name='테이블 이름'#` 을 입력하여 컬럼의 이름을 찾습니다.

[테이블 컬럼 이름찾기 사진]


**4. 해당 컬럼 데이터 얻기**

3번에서 얻은 컬럼의 이름을 바탕으로 각 데이터를 얻을 수 있습니다. `' UNION SELECT ALL 1,id,3,pw,5,6 FROM users#`

[데이터 얻은 사진]

