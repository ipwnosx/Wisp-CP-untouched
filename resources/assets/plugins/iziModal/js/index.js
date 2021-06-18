//default
$(document).on('click', '.open-default', function(event) {
  event.preventDefault();
  $('#modal-default').iziModal('open');
});
$('#modal-default').iziModal();

//options
$(document).on('click', '.open-options', function(event) {
  event.preventDefault();
  $('#modal-options').iziModal('open');
});
$('#modal-options').iziModal({
  headerColor: '#26A69A', //ヘッダー部分の色
  width: '50%', //横幅
  overlayColor: 'rgba(0, 0, 0, 0.5)', //モーダルの背景色
  fullscreen: true, //全画面表示
  transitionIn: 'fadeInUp', //表示される時のアニメーション
  transitionOut: 'fadeOutDown' //非表示になる時のアニメーション
});

//iframe
$(document).on('click', '.open-iframe', function(event) {
  event.preventDefault();
  $('#modal-iframe').iziModal('open', this);
});
$('#modal-iframe').iziModal({
  width: 400, //横幅
  iframe: true, //iframeを利用
  iframeHeight: 300, //iframeの高さ
  iframeURL: 'http://gimmicklog.main.jp/jquery/581/' //iframe内に表示するurl
});

//alert
$('#modal-alert').iziModal({
  headerColor: '#d43838', //ヘッダー部分の色
  width: 400, //横幅
  timeout: 10000, //10秒で非表示
  pauseOnHover: true,　//マウスオーバーでカウントダウン停止
  timeoutProgressbar: true, //プログレスバーの表示
  attached: 'bottom' //アラートの表示位置 top or bottom or　指定なしで中央
});
$(document).on('click', '.open-alert', function (event) {
  event.preventDefault();
  $('#modal-alert').iziModal('open');
});