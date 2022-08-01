<?php
/**
 * 作者:大橙子
 * 网址:https://amujie.com
 * QQ:1570457334
 */
// 请勿修改此文件
error_reporting(0);

if (isset($_POST['tao'])) {
    $mojia = moJiaPath('mojia');
    $taoke = moJiaDaTaoKe('https://openapi.dataoke.com/api/goods/get-goods-list', array('pageSize' => '50', 'cids' => $mojia['home']['taoke']['type'], 'juHuaSuan' => $mojia['home']['taoke']['qiang'] == 1 ? 1 : '', 'taoQiangGou' => $mojia['home']['taoke']['qiang'] == 2 ? 1 : '', 'tmall' => $mojia['home']['taoke']['qiang'] == 3 ? 1 : '', 'tchaoshi' => $mojia['home']['taoke']['qiang'] == 4 ? 1 : '', 'goldSeller' => $mojia['home']['taoke']['qiang'] == 5 ? 1 : '', 'haitao' => $mojia['home']['taoke']['qiang'] == 6 ? 1 : '', 'specialId' => $mojia['home']['taoke']['brand'], 'sort' => $mojia['home']['taoke']['sort'], 'version' => $mojia['home']['taoke']['ver'], 'appKey' => $mojia['other']['taoke']['key']), $mojia['other']['taoke']['secret']);
    if (file_put_contents(moJiaPath('path') . 'application/extra/mojiatao.php', '<?php ' . PHP_EOL . 'return ' . var_export(array_slice($taoke['data']['list'], 0, $mojia['home']['taoke']['num']), true) . ';')) {
        die(json_encode(array('msg' => '更新成功')));
    } else {
        die(json_encode(array('msg' => '更新失败')));
    }
} elseif (isset($_POST['time'])) {
    if (file_put_contents(moJiaPath('path') . 'runtime/temp/' . md5('mojia') . '.php', '<?php ' . PHP_EOL . 'return ' . var_export(time(), true) . ';')) {
        die(json_encode(array('msg' => '更新成功')));
    } else {
        die(json_encode(array('msg' => '更新失败')));
    }
} elseif (isset($_POST['agent'])) {
    die(moJiaCurlGet($_POST['agent']));
} elseif (isset($_POST['addr'])) {
    die(json_encode(array('msg' => md5($_SERVER['SERVER_ADDR']))));
} elseif (isset($_POST['key'])) {
    $output = moJiaCurlGet(@$_POST['key']);
    parse_str(parse_url(@$_POST['key'], PHP_URL_QUERY));
    die($output ? $output : json_encode(dns_get_record($name, DNS_TXT)));
} elseif (isset($_POST['url'])) {
    $mojia = moJiaPath('mojia');
    $url = $mojia['other']['share']['host'] ? $mojia['other']['share']['host'] . parse_url(@$_POST['url'], PHP_URL_PATH) : @$_POST['url'];
    preg_match_all(($mojia['other']['share']['regex'] ? $mojia['other']['share']['regex'] : '/(.*)/i'), moJiaCurlGet($mojia['other']['share']['apis'] . rawurlencode($url)), $match);
    die(json_encode(array('msg' => str_replace('\\', '', $match[1][0]))));
} elseif (isset($_GET['pic'])) {
    header('Content-Type: image/jpeg; charset=utf-8');
    $time = isset($_GET['time']) ? $_GET['time'] : 5;
    $curl = curl_init($_GET['pic']);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $time);
    curl_setopt($curl, CURLOPT_TIMEOUT, $time);
    $output = curl_exec($curl);
    curl_close($curl);
    die($output);
}
