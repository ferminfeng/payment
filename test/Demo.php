<?php
/**
 * User: Fermin
 * Date: 2017/08/18
 * Time: 16:00
 */

namespace app\api\controller;

use app\common\model\Payment as PaymentModel;

class Payment
{

    /*
      唤起支付

        官方文档地址
            https://docs.open.alipay.com/api_1/alipay.trade.app.pay
            https://docs.open.alipay.com/api_1/alipay.trade.wap.pay
            https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1

        参数说明：
            payment_name:   支付名称
            payment_amount: 支付金额，单位元
            out_sn:         商户订单号
            payment_way:    支付方式
                                alipay_app  支付宝App
                                alipay_h5   支付宝H5
                                alipay_pc   支付宝PC
                                wxpay_app   微信App
                                wxapy_h5    微信H5
            order_type:     订单类型，不同的业务会生成不同的订单，会存在不同的业务逻辑，可通过这个参数区分，便于在接收异步通知时分开处理业务逻辑

        返回说明:
            array('code' => '', 'msg' => '','data' => '')
                code:
                    1:请求成功，支付参数在data内，注意：当为支付宝H5以及支付宝PC唤起支付时直接输出返回参数内data的数据即可，data参数内为from表单代码，它会自动提交
                    负值:请求失败
                msg:提示语
                data:code=1时为支付参数，code为其他值时为空
     */
    public function payment()
    {
        $data = [
            'payment_name'   => '测试支付',
            'payment_amount' => '15',
            'out_sn'         => '201708181743020003',
            'payment_way'    => 'wxpay_app',
            'order_type'     => 'test',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->payment($data);
        var_dump($res);
    }

    /*
      查询支付结果
        通过商户订单号(out_sn)、支付流水号(trade_no)查询支付结果，两者传一即可，其他留空

        官方文档地址
            https://docs.open.alipay.com/api_1/alipay.trade.query/
            https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_2

        请求参数
            payment_way: 支付方式
                            alipay_app  支付宝App
                            alipay_h5   支付宝H5
                            alipay_pc   支付宝PC
                            wxpay_app   微信App
                            wxapy_h5    微信H5
            out_sn:      商户订单号
            trade_no:    支付流水号

        返回参数
            array('code' => '', 'msg' => '','data' => '')
            code:
                1:支付成功
                他值：请查看msg
            msg:提示语
            data:接口返回值
        */
    public function searchPaymentResult()
    {
        $param = [
            'payment_way' => 'wxpay_app',
            'out_sn'      => '201708181743020003',
            'trade_no'    => '2017081817430200030700',
        ];

        $model_payment = new PaymentModel();
        $res = $model_payment->searchPaymentResult($param);
        if ($res['code'] == '1') {
            //支付成功
        } else {
            echo $res['msg'];
        }
    }

    /*
    支付宝单笔退款查询
        通过商户订单号(out_sn)、支付流水号(trade_no)、退款批次号(batch_no)查询单笔退款


        官方文档地址
        https:/docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query

        请求参数
            out_sn:      商户订单号与支付流水号必填一个
            trade_no:    支付流水号与商户订单号必填一个
            batch_no:    退款批次号

        返回参数
            array('code' => '', 'msg' => '','data' => '')
                code:
                    1:支付成功
                    其他值：请查看msg
                msg:提示语
                data:接口返回值
     */
    public function aliPaySearchRefund()
    {
        $param = [
            'out_sn'   => '201708181743020003',
            'trade_no' => '2017081817430200030700',
            'batch_no' => '20170818001',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->aliPaySearchRefund($param);
        if ($res['code'] == '1') {
            //退款成功
        } else {
            echo $res['msg'];
        }
    }

    /*
     支付宝单笔退款

     官方文档地址
     https://docs.open.alipay.com/api_1/alipay.trade.refund/


     请求参数
         out_sn:          商户订单号与支付流水号必填一个
         trade_no:        支付流水号与商户订单号必填一个
         batch_no:        退款批次号
         refund_amount:   退款金额
         refund_reason:   退款备注

     返回参数
         array('code' => '', 'msg' => '','data' => '')
         code:
            1:支付成功
            其他值：请查看msg
         msg:提示语
         data:接口返回值
     */
    public function aliPayRefund()
    {
        $param = [
            'out_sn'        => '201708181743020003',
            'trade_no'      => '2017081817430200030700',
            'batch_no'      => '退款批次号',
            'refund_amount' => '0.01',
            'refund_reason' => '退款备注',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->aliPayRefund($param);
        if ($res['code'] == '1') {
            //退款成功
        } else {
            echo $res['msg'];
        }

    }

    /*
     微信单笔退款查询

     官方文档地址
     https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_5


     请求参数
         refund_no:         微信生成的退款单号
         out_sn:            商户订单号与支付流水号必填一个
         trade_no:          支付流水号与商户订单号必填一个
         batch_no:          退款批次号
         payment_way:       支付方式
                                 wxpay_app  微信App
                                 wxapy_h5  微信H5

     返回参
         array('code' => '', 'msg' => '','data' => '')
         code:
             1:支付成功
             其他值：请查看msg
         msg:提示语
         data:接口返回值
     */
    public function wxSearchRefund()
    {
        $param = [
            'refund_no'   => '2017081813245613',
            'out_sn'      => '201708181743020003',
            'trade_no'    => '2017081817430200030700',
            'batch_no'    => '20170818001',
            'payment_way' => 'wxpay_app',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->wxSearchRefund($param);
        if ($res['code'] == '1') {
            //退款成功
        } else {
            echo $res['msg'];
        }
    }

    /*
     微信单笔退款

     官方文档地址
     https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_4


     请求参数
        total_fee:       支付总金额，单位元
        refund_amount:   退款金额，单位元
        trade_no:        支付流水号
        payment_way:     支付方式
                            wxpay_app   微信App
                            wxapy_h5    微信H5
        返回参数
        array('code' => '', 'msg' => '','data' => '')
            code:
                1:支付成功
                其他值：查看msg
            msg:提示语
            data:接口返回值
     */
    public function wxRefund()
    {
        $param = [
            'total_fee'     => '5',
            'refund_amount' => '2',
            'trade_no'      => '2017081817430200030700',
            'payment_way'   => 'wxpay_app',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->wxRefund($param);
        if ($res['code'] == '1') {
            //退款成功
        } else {
            echo $res['msg'];
        }
    }

    /**
        查询对账单下载地址

        官方文档地址
        https://docs.open.alipay.com/api_15/alipay.data.dataservice.bill.downloadurl.query
        https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_6

        请求参数
            ali_date:       支付宝日期格式 年-月-日 2017-03-06
            wx_date:        微信日期格式 年月日 20170306
            payment_way:    支付方式
                        alipay_app  支付宝App
                        alipay_h5   支付宝H5
                        alipay_pc   支付宝PC
                        wxpay_app   微信App
                        wxapy_h5    微信H5
     */
    public function getBillDownload()
    {

        $param = [
            'ali_date'    => '2017-03-06',
            'wx_date'     => '20170306',
            'payment_way' => '...',
        ];
        $model_payment = new PaymentModel();
        $res = $model_payment->getBillDownload($param);
        if ($res['code'] == '1') {
            //查询成功
        } else {
            echo $res['msg'];
        }
    }



    /*********************************************************************************************/
    /*********************************************************************************************/
    /*********************************************************************************************/
    /*************************          以下为支付异步通知DEMO           ****************************/
    /*********************************************************************************************/
    /*********************************************************************************************/
    /*********************************************************************************************/

    /**
     * 接收支付宝支付异步通知
     *
     * passback_params为自定义返回参数，在唤起支付时定义
     */
    public function AliPayNotify()
    {

        $notify_data = $_POST;

        parse_str(urldecode($notify_data['passback_params']), $passback_params);

        //支付宝验签
        $aop = new \fyflzjz\payment\AlipayAop\AopClient();
        $notify_result = $aop->rsaCheckV1($notify_data);
        if ($notify_result) {
            //区分异步通知状态 当trade_status=TRADE_SUCCESS时表明支付成功
            if ($notify_data['trade_status'] == 'TRADE_SUCCESS') {

                //修改交易状态
                $param = [
                    'out_sn'         => $notify_data['out_trade_no'],
                    'trade_no'       => $notify_data['trade_no'],
                    'payment_amount' => $notify_data['total_amount'],
                    'payment_time'   => $notify_data['gmt_payment'],
                    'payment_way'    => $passback_params['payment_way'],
                    'payment_type'   => $passback_params['payment_type'],
                ];
                $result = $this->updatePaymentInfo($param);

                if ($result) {
                    exit('success');
                }
            }
        } else {
            //验签失败
            exit('fail');
        }

    }

    /**
     * 接收微信APP支付异步通知
     */
    public function wxAppNotify()
    {
        //验签
        $new_content = file_get_contents("php://input");

        $weiXinPay = new \fyflzjz\payment\Wxpay\WxPay();
        $notify_info = $weiXinPay->check_notify();

        //验签失败 返回消息给微信服务器
        if (!$notify_info) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '签名失败']);
        }

        //attach为自定义返回参数，在唤起支付时定义
        $attach = [];
        if (isset($notify_info['attach'])) {
            parse_str(urldecode($notify_info['attach']), $attach);
        }

        //转换支付时间
        $payment_time = isset($notify_info['time_end']) ? date('Y-m-d H:i:s', strtotime($notify_info['time_end'])) : '';

        //支付状态验证
        if ($notify_info['result_code'] != 'SUCCESS' || $notify_info['return_code'] != 'SUCCESS' || !$notify_info['transaction_id']) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '支付状态错误']);
        }

        //修改交易状态
        $param = [
            'out_sn'         => $notify_info['out_trade_no'],
            'trade_no'       => $notify_info['transaction_id'],
            'payment_amount' => $notify_info['total_fee'] / 100,
            'payment_time'   => $payment_time,
            'payment_way'    => $attach['payment_way'],
            'payment_type'   => $attach['payment_type'],
        ];
        $result = $this->updatePaymentInfo($param);

        if ($result) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        } else {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '修改失败']);
        }
    }

    /**
     * 接收微信H5支付异步通知
     */
    public function wxH5Notify()
    {
        //验签
        $new_content = file_get_contents("php://input");

        $weiXinPay = new \fyflzjz\payment\Wxpay\JsApiPay();
        $notify_info = $weiXinPay->check_notify();

        //验签失败 返回消息给微信服务器
        if (!$notify_info) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '签名失败']);
        }

        //attach为自定义返回参数，在唤起支付时定义
        $attach = [];
        if (isset($notify_info['attach'])) {
            parse_str(urldecode($notify_info['attach']), $attach);
        }

        //转换支付时间
        $payment_time = isset($notify_info['time_end']) ? date('Y-m-d H:i:s', strtotime($notify_info['time_end'])) : '';

        //支付状态验证
        if ($notify_info['result_code'] != 'SUCCESS' || $notify_info['return_code'] != 'SUCCESS' || !$notify_info['transaction_id']) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '支付状态错误']);
        }

        //修改交易状态
        $param = [
            'out_sn'         => $notify_info['out_trade_no'],
            'trade_no'       => $notify_info['transaction_id'],
            'payment_amount' => $notify_info['total_fee'] / 100,
            'payment_time'   => $payment_time,
            'payment_way'    => $attach['payment_way'],
            'payment_type'   => $attach['payment_type'],
        ];
        $result = $this->updatePaymentInfo($param);

        if ($result) {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        } else {
            //返回消息给微信服务器
            $weiXinPay->resultXmlToWx(['return_code' => 'FAIL', 'return_msg' => '修改失败']);
        }
    }

    /**
     * 支付宝H5同步通知
     */
    public function aliPayH5Return()
    {
        $notify_data = $_GET;

        //支付宝验签
        $aop = new \fyflzjz\payment\AlipayAop\AopClient();
        $notify_result = $aop->rsaCheckV1($notify_data);
        if ($notify_result) {
            $out_trade_no = $notify_data['out_trade_no'];
            $trade_no = $notify_data['trade_no'];
            //查询是否支付
            $model_payment = new PaymentModel();
            $result = $model_payment->searchPaymentResult(1, $out_trade_no, $trade_no);

            //根据商户订单号等查询订单信息写业务逻辑
        }
    }

    /**
     * 支付宝PC同步通知
     */
    public function aliPayPcReturn()
    {
        $notify_data = $_GET;

        //支付宝验签
        $aop = new \fyflzjz\payment\AlipayAop\AopClient();
        $notify_result = $aop->rsaCheckV1($notify_data);
        if ($notify_result) {
            $out_trade_no = $notify_data['out_trade_no'];
            $trade_no = $notify_data['trade_no'];
            //查询是否支付
            $model_payment = new PaymentModel();
            $result = $model_payment->searchPaymentResult(6, $out_trade_no, $trade_no);

            //根据商户订单号等查询订单信息写业务逻辑

        }
    }

    /**
     * 支付异步通知修改交易状态
     *
     * @param $param
     *
     * @return bool
     */
    private function updatePaymentInfo($param)
    {
        if (!is_array($param)) {
            return false;
        }

        switch ($param['payment_type']) {
            /**
             * 按照payment_type分别写业务逻辑
             */
        }

        //根据业务逻辑处理成功与否返回成功失败
        return true;
    }

}