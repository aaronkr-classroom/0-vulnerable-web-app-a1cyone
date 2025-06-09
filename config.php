<?php
// 보안 설정 로드(환경 변수 or 외부 설정 파일)
require_once __DIR__.'/config-var.php';

//Connection to database
 
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 연결 오류 처리
if (!$db){
    // 에러 로그 파일에 기록 (웹 사용자에게는 노출되지 않음)
    error_log("DB connection failed: ".mysqli_connect_error());

    // 사용자에게는 일반적인 오류 메시지만 표시
    die("내부 서버 오류입니다 잠시 후 다시 시도해 보세요.");
}
?>
