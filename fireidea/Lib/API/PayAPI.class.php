<?php
//来自TP论坛内pangdan118分享的支付宝支付接口
//data:2012-1-31添加
//author:xuchanglong
//此处只是拷贝，并未修改，稍晚进行整理
class PayAPI
{
	public function _initialize() {
		Vendor('Alipay.Corefunction');
		Vendor('Alipay.Notify');
		Vendor('Alipay.Service');
		Vendor('Alipay.Submit');
		Vendor('Alipay.Alipayconfig');
    }
	
    function alipayto($out_trade_no,$subject,$body,$total_fee,$show_url,$extra_common_param)
    {
        C('TOKEN_ON', false);
        $aliapy_config = alicofings();
         
        $subject = $subject;
        $body = $body;
        $total_fee = $total_fee;
		
        $paymethod = '';
        $defaultbank = '';
        $anti_phishing_key = '';
        $exter_invoke_ip = '';
        $royalty_type = "";
        $royalty_parameters = "";

        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "payment_type" => "1",
            "partner" => trim($aliapy_config['partner'],
			"_input_charset" => trim(strtolower($aliapy_config['input_charset'])), 
			"seller_email" => trim($aliapy_config['seller_email']), 
			"return_url" => trim($aliapy_config['return_url']),
			"notify_url" => trim($aliapy_config['notify_url']), 
			"out_trade_no" => $out_trade_no, 
			"subject" => $subject, 
			"body" => $body, 
			"total_fee" => $total_fee, 
			"paymethod" => $paymethod, 
			"defaultbank" => $defaultbank, 
			"anti_phishing_key" => $anti_phishing_key, 
			"exter_invoke_ip" => $exter_invoke_ip,
			"show_url" => $show_url, 
			"extra_common_param" => $extra_common_param, 
			"royalty_type" => $royalty_type, 
			"royalty_parameters" => $royalty_parameters
		);
		//入库
        $d = D('Order');
        $d->create();
        $d->user_id = $_SESSION["UserID"];
        $d->total_fee = $total_fee;
        $d->order_id = $out_trade_no;
        $d->creat_time = time();
        $d->trde_status = 0;
        if (false !== $d->add())
        {
            $alipayService = new AlipayService($aliapy_config);
            $html_text = $alipayService->create_direct_pay_by_user($parameter);
            $this->assign('alipay', $html_text);
            $this->assign('total_fee', $total_fee);
            $this->display();
        }
        else
        {
            $this->error('系统错误暂时不能充值，请联系在线客服!');
        }
    }

    public function returnurl()
    {
        $aliapy_config = alicofings();
        $alipayNotify = new AlipayNotify($aliapy_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result)
        { //验证成功
            $out_trade_no = $_GET['out_trade_no']; //获取订单号
            $trade_no = $_GET['trade_no']; //获取支付宝交易号
            $total_fee = $_GET['total_fee']; //获取总价格
            $d = D('Order');
            $result = $d->where("order_id='.$trade_no.'")->select();
            $status = $result[0]['trde_statuse'];

            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS')
            {

                if ($status == 0)
                {
                    $d->create();
                    $d->trde_status = 1;
                    $d->alipay_trade_no;
                    $d->total->fee = $total_fee;
                }
            }
            else
            {
				//echo "trade_status=" . $_GET['trade_status'];
                $this->assign('msg', '充值失败!');
            }

            echo "验证成功<br />";
            echo "trade_no=" . $trade_no;
        }
        else
        {
            $this->assign('msg', '验证失败');
        }

        $this->display();
    }

    public function notifyurl()
    {
        $aliapy_config = alicofings();
        $alipayNotify = new AlipayNotify($aliapy_config);
        $verify_result = $alipayNotify->verifyNotify();

        if ($verify_result)
        { 
			//验证成功
            $out_trade_no = $_POST['out_trade_no']; //获取订单号
            $trade_no = $_POST['trade_no']; //获取支付宝交易号
            $total_fee = $_POST['total_fee']; //获取总价格

            if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS')
            { //交易成功结束
                echo "success"; //请不要修改或删除
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else
            {
                echo "success"; //其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else
        {
			//验证失败
            echo "fail";

			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    function alicofings()
    {
        $aliapy_config['partner'] = '2088302763';
        $aliapy_config['key'] = 'm8ve6f5x1d90hjl5e95';//安全检验码，以数字和字母组成的32位字符
        $aliapy_config['seller_email'] = 'qiyunnetwork@vip.163.com';//签约支付宝账号或卖家支付宝帐户

		//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		//return_url的域名不能写成http://localhost/create_direct_pay_by_user_php_utf8/return_url.php ，否则会导致return_url执行无效
        $aliapy_config['return_url'] = 'http://www.x.com/order/returnurl.html';

		//服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        $aliapy_config['notify_url'] = 'http://www.gudashi.com/order/notifyurl.html';

        $aliapy_config['sign_type'] = 'MD5';//签名方式 不需修改
        $aliapy_config['input_charset'] = 'utf-8';//字符编码格式 目前支持 gbk 或 utf-8
        $aliapy_config['transport'] = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        return $aliapy_config;
    }
}
?>