<?php 
class CardBalanceRequest extends TrxRequest
{
	/**加密报文*/
	private $iMsg    = null;
	
	/**
	 * 构造CardBalanceRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 信息是否合法
     * @throws TrxException: 请求不合法
	 */
	protected function checkRequest() 
	{
		// TODO Auto-generated method stub
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 	 '<TrxType>'.TrxType::TRX_TYPE_CRADBALANCE_REQ.'</TrxType>'.
	 	 	 '<Msg>'.$this->iMsg.'</Msg>'.
	 	 	 '</TrxRequest>';
	 	return $tMessage;
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
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
	/**
	 * @return the $iMsg
	 */
	public function getMsg() {
		return $this->iMsg;
	}

	/**
	 * @param NULL $iMsg
	 */
	public function setMsg($iMsg) {
		$this->iMsg = $iMsg;
	}


	
}
?>