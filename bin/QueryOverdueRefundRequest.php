<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class QueryOverdueRefundRequest extends TrxRequest
{
	/** 批量流水号 */
	private $iSerialNumber = "";
	
	/**
	 * 构造QueryOverdueRefundRequest对象
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
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_QUERYOVERDUEREFUND.'</TrxType>'.
			 '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
			 '</TrxRequest>';
		return $str;
	}

	/**
	 * 订单查询请求信息是否合法
	 * @throws TrxException: 订单查询请求不合法
	 */
	protected function checkRequest() 
	{
		if(!$this->iSerialNumber)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定批量流水号！');
		if(count(DataVerifier::stringToByteArray($this->iSerialNumber)) >30)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批量流水号不合法！');	
		/*汗
		if (iSerialNumber.getBytes().length > 30)
			throw new TrxException(TrxException.TRX_EXC_CODE_1101, TrxException.TRX_EXC_MSG_1101, "支付结果回传网址不合法！");
			*/
	}
	/**
	 * 回传交易响应对象。
	 * @return 交易报文信息
	 */
	protected function constructResponse($aResponseMessage)
    {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}
	/**
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = trim($iSerialNumber);
	}

}
/*
$tqorRequest=new QueryOverdueRefundRequest();
$tqorRequest->setSerialNumber('001');
echo $tqorRequest->getRequestMessage();
if(!$tqorRequest->checkRequest())
echo 'ok';
echo $tqorRequest->getSerialNumber();
*/
?>