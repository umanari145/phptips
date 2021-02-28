<?php
session_start();

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    echo 'ログインしました';
} else {
    echo 'ログインできていません。';
}
