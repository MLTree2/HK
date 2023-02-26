# 웹 서버 생성
- 전체적인 웹 서버 생성은 [__해당 Blog__](https://blog.lael.be/post/11072)를 참조하여 생성하였습니다.
- 취약점 생성을 위하여 아파치 설정 파일(/etc/apache2/apache2.conf)중 ***Options Indexes FollowSymLinks*** 를 추가하였습니다.

# 파일 구성

## [board.php](#board.php)
- 게시판을 구현한 php 소스코드입니다.

## changepw.php
- 비밀번호 변경을 위한 페이지입니다.

## changepw_do.php
- 입력받은 비밀번호를 실질적으로 변경하는 부분입니다.

## connect.php
- DB 연결을 위해 include하는 php입니다.

## login_check.php
- 입력받은 id와 pw를 이용하여 실질적으로 로그인을 처리하는 부분입니다.

## login2.php
- 로그인 페이지입니다.

## logout.php
- 로그아웃 기능을 수행하는 페이지입니다.

## view.php
- 게시글을 확인하는 기능을 수행하는 페이지입니다.

## write.php
- 게시글 작성을 위한 페이지입니다. 제목, 내용, 첨부파일 작성을 위한 기능을 제공합니다.

## write_save.php
- DB에 작성한 글을 저장하는 부분입니다. write.php에서 작성한 게시글 내용을 DB에 저장합니다.
