function  onSignIn(googleUser) {
    // トークンの取得（サーバーにはこちらを送信）
    let token = googleUser.getAuthResponse().id_token;

    // 接続を解除して、2回目以降の自動ログインを防止
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.disconnect();

    $.ajax({
        url:'http://localhost:8080/oauth/loginCheck.php',
        type:'POST',
        data:{
        'token':token
        }
    })
    // Ajax通信が成功したら発動
    .done( (data) => {
        console.log('aseikou')
        window.location.href = 'http://localhost:8080/oauth/home.php';
    })
    // Ajax通信が失敗したら発動
    .fail( (jqXHR, textStatus, errorThrown) => {
        alert('Ajax通信に失敗しました。');
        console.log("jqXHR          : " + jqXHR.status); // HTTPステータスを表示
        console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラーなどのエラー情報を表示
        console.log("errorThrown    : " + errorThrown.message); // 例外情報を表示
    })
    // Ajax通信が成功・失敗のどちらでも発動
    .always( (data) => {
        console.log("always")
    });

}

//未使用
function  signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        window.location.href = 'http://localhost:8080/oauth/logOut.php';
    });
}

