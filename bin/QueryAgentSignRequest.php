<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class QueryAgentSignRequest extends TrxRequest
{
	/** 签约协议号 */
	private $iAgentSignNo = '';
	
	/**
	 * 构造QueryAgentSignRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_QUERYAGENTSIGN.'</TrxType>'.
			 '<AgentSignNo>'.$this->iAgentSignNo.'</AgentSignNo>'.
			 '</TrxRequest>';
		return $str;
	}
	/**
	 * 委托扣款签约查询请求信息是否合法
	 * @throws TrxException: 查询请求不合法
	 */
	protected function checkRequest()
	{
		if(strlen($this->iAgentSignNo) == 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定签约协议号！');
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
	 * @return the $iAgentSignNo
	 */
	public function getAgentSignNo() {
		return $this->iAgentSignNo;
	}

	/**
	 * @param string $iAgentSignNo
	 */
	public function setAgentSignNo($iAgentSignNo) {
		$this->iAgentSignNo = trim($iAgentSignNo);
	}


	
}
?>