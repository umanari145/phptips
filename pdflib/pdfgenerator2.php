<?php

/* ライブラリをインクルードする(TCPDFをインストールしたパスを指定する) */
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$font = new TCPDF_FONTS();
$font1 = $font->addTTFfont('./fonts/helvetica.php');
$pdf->SetFont($font1, '', 12); //フォントをＩＰＡ Ｐゴシック
$pdf->SetMargins(20, 10, true);

//css
$css = '<style>
  	table {
  		text-align: left;
  		width: 100%;"
  	}
	th {
		vertical-align: middle;
		background-color: rgb(153, 153, 153);
		text-align: center;"
	}
	th.num {
		vertical-align: middle;
		background-color: rgb(153, 153, 153);
		text-align: right;"
	}
	td {
		vertical-align: middle;
		text-align: center;"
	}
	td.num {
		vertical-align: middle;
  		text-align: right;
	}
   </style>';
//html content
$html = '<div align="right">No. ＊＊＊</div>'
     . '<div align="left">□□□株式会社御中</div>'
     . '<div align="right">□□□□年□□月□□日<br />'
     . '○○株式会社<br />'
     . '○○支店○○部<br />'
     . 'tel. 030-1111-2222<br />'
     . '日本太郎</div>'
     . '<div style="text-align: center;text-decoration: underline;font-size: 16pt;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;御見積書&nbsp;&nbsp;&nbsp;&nbsp;</div>'
     . '<div>&nbsp;&nbsp;&nbsp;&nbsp;この度は、弊社に見積の機会をお与え下さいまして誠にありがとうございます。下記の通りお見積り申し上げます。<br />'
     . 'ご検討の程よろしくお願い申し上げます。</div>'
     . '<div style="text-align: left;font-size: 13pt;font-weight: bold;">納品場所：□□□□<br />'
     . '納&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期： 2012年05月20日<br />'
     . '本見積有効期限： 本見積提出後2週間</div>'
     . '<div style="text-align: center;">'
     . '<table  border="1" cellpadding="0" cellspacing="0">'
     . '<tbody>'
     . '<tr>'
     . '<th class="num">No</th>'
     . '<th>項目</th>'
     . '<th>単価</th>'
     . '<th>数量</th>'
     . '<th>単位</th>'
     . '<th class="num">金額</th>'
     . '<th>備考</th>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">1</td>'
     . '<td>商品A</td>'
     . '<td>□□</td>'
     . '<td>□□</td>'
     . '<td>個</td>'
     . '<td class="num">□,□□□</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">2</td>'
     . '<td>商品B</td>'
     . '<td>□□</td>'
     . '<td>□□</td>'
     . '<td>箱</td>'
     . '<td class="num">□,□□□</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">3</td>'
     . '<td>商品C</td>'
     . '<td>□□</td>'
     . '<td>□□</td>'
     . '<td>枚</td>'
     . '<td class="num">□,□□□</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">4</td>'
     . '<td>商品D</td>'
     . '<td>□□</td>'
     . '<td>□□</td>'
     . '<td>式</td>'
     . '<td class="num">□,□□□</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '<td class="num">&nbsp;</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '<tr>'
     . '<td colspan="3" rowspan="1">合&nbsp;&nbsp;計</td>'
     . '<td colspan="2" rowspan="1">&nbsp;</td>'
     . '<td class="num">□,□□□</td>'
     . '<td>&nbsp;</td>'
     . '</tr>'
     . '</tbody></table>'
     . '</div>'
     ;
//output
$pdf->writeHTML($css . $html, true, 0, true, 0);
$pdf->Output("test.pdf", "I");
