<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');


class QueryOrderRequest extends TrxRequest
{
	/** 订单号 */
	private $iOrderNo='';
	/** 是否查询详细信息 */
	private $iEnableDetailQuery=false;

	 /**
     * 设定定单号
     * @param aOrderNo 订单号
     * @return 对象本身
     */
	public function setOrderNo($aOrderNo)
	{
		$this->iOrderNo=trim($aOrderNo);
	}
    /**
     * 回传定单号
     * @return 定单号
     */
    public function getOrderNo()
	{
		return $this->iOrderNo;
	}
    /**
     * 设定是否查询订单详细信息
     * @param aEnableDetailQuery 是否查询订单详细信息
     * @return 对象本身
     */
	public function enableDetailQuery($aEnableDetailQuery)
	{
		$this->iEnableDetailQuery=$aEnableDetailQuery;
	}
	 /**
     * 构造QueryOrderRequest对象
     */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	 /**
     * 回传交易报文。
     * @return 交易报文信息
     */
	protected function getRequestMessage()
	{
		$qorMes='';
		if($this->iEnableDetailQuery==true)
		{
			$qorMes= '<TrxRequest>'.
			    '<TrxType>'.TrxType::TRX_TYPE_QUERY.'</TrxType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<QueryDetail>'.'true'.'</QueryDetail>'.
			    '</TrxRequest>';
		}
		else 
		{
			$qorMes='<TrxRequest>'.
			    '<TrxType>'.TrxType::TRX_TYPE_QUERY.'</TrxType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<QueryDetail>0</QueryDetail>'.
			    '</TrxRequest>';
		}
		return $qorMes;
	}
	/**
	*重写TrxRequest中的抽象方法
	
	protected function constructParametersMessage()
	{
		getRequestMessage();
	}
	*/
	 /**
     * 订单查询请求信息是否合法
     * @throws TrxException: 订单查询请求不合法
     */
	protected function checkRequest()
	{
		if(!$this->iOrderNo) 
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1100,'未设定订单号！');
		//原来java有个getBytes()函数  if (iOrderNo.getBytes().length > Order.ORDER_NO_LEN)
		if(strlen(trim($this->iOrderNo))>Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'订单号不合法！');

	}	
    /**
     * 回传交易响应对象。
     * @throws TrxException：组成交易报文的过程中发现内容不合法
     * @return 交易报文信息
     */
	protected function constructResponse($aResponseMessage)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}

}
/*
$qor= new QueryOrderRequest();
$orderno='ON200306300001';
$qor->setOrderNo($orderno);
$qor->enableDetailQuery(false);
$tTrxResponse=new TrxResponse();
$tTrxResponse=$qor->postRequest();
if($tTrxResponse->isSuccess())
echo "success";
else 
	echo 'aaa';
*/

?>