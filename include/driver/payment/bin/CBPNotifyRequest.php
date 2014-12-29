<?php 
class CBPNotifyRequest extends TrxRequest
{
	/** 第三方账单号 */
	private $iCBPOrderNo = '';
	
	/** 支付状态    1:成功、2:失败、3:其他  */
	private $iStatus = '';
	
	/** 支付日期 */
	private $iPayDate = '';
	
	/** 支付银行编号  */
	private $iPayBankNo = '';
	
	/** 网上支付平台交易网址 */
	private  $iTrustPayCBPTrxURL = '';
	
	/** 商户通过浏览器提交网上第三方支付平台交易网址 */
	private $iTrustPayIECBPTrxURL = '';
	
	/**
	 * 构造CBPNotifyRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * 初始 CBPNotifyRequest 对象的属性。使用XML字符串。
	 */
	public function construstCBPNotifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCBPOrderNo($xml->getValueNoNull('CBPOrderNo'));
		$this->setStatus($xml->getValueNoNull('Status'));
		$this->setPayDate($xml->getValueNoNull('PayDate'));
		$this->setPayBankNo($xml->getValueNoNull('PayBankNo'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 请求信息是否合法
     * @throws TrxException: 请求不合法
	 */
	protected function checkRequest() 
	{
		if(!$this->iCBPOrderNo)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定第三方账单号！');
		if($this->iStatus!='1'&&$this->iStatus!='2'&&$this->iStatus!='3'&&$this->iStatus==null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'支付状态不合法！');
		if(!DataVerifier::isValidDateTime($this->iPayDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付日期格式不正确');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<CBPOrderNo>'.$this->iCBPOrderNo.'</CBPOrderNo>'.
	 	 		  '<Status>'.$this->iStatus.'</Status>'.
	 	 		  '<PayDate>'.$this->iPayDate.'</PayDate>'.
	 	 		  '<PayBankNo>'.$this->iPayBankNo.'</PayBankNo>';
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
	 	$tTrxResponse=new TrxResponse();
	 	$xmlRes=new XMLDocument($aResponseMessage);
	 	$value=$xmlRes->getValueNoNull('NotifyStatus');
	 	if($value)
	 		$tTrxResponse=$tTrxResponse->initWithCodeMsg(TrxResponse::RC_SUCCESS, '农行接收通知成功');
	 	elseif (!$value)
	 		$tTrxResponse=$tTrxResponse->initWithCodeMsg('0011', '农行接收通知失败');
		return $tTrxResponse;
	 }
	/**
	 * @return the $iCBPOrderNo
	 */
	public function getCBPOrderNo() {
		return $this->iCBPOrderNo;
	}

	/**
	 * @param string $iCBPOrderNo
	 */
	public function setCBPOrderNo($iCBPOrderNo) {
		$this->iCBPOrderNo = $iCBPOrderNo;
	}

	/**
	 * @return the $iStatus
	 */
	public function getStatus() {
		return $this->iStatus;
	}

	/**
	 * @param string $iStatus
	 */
	public function setStatus($iStatus) {
		$this->iStatus = $iStatus;
	}

	/**
	 * @return the $iPayDate
	 */
	public function getPayDate() {
		return $this->iPayDate;
	}

	/**
	 * @param string $iPayDate
	 */
	public function setPayDate($iPayDate) {
		$this->iPayDate = $iPayDate;
	}

	/**
	 * @return the $iPayBankNo
	 */
	public function getPayBankNo() {
		return $this->iPayBankNo;
	}

	/**
	 * @param string $iPayBankNo
	 */
	public function setPayBankNo($iPayBankNo) {
		$this->iPayBankNo = $iPayBankNo;
	}

	/**
	 * @return the $iTrustPayCBPTrxURL
	 */
	public function getTrustPayCBPTrxURL() {
		return $this->iTrustPayCBPTrxURL;
	}

	/**
	 * @param string $iTrustPayCBPTrxURL
	 */
	public function setTrustPayCBPTrxURL($iTrustPayCBPTrxURL) {
		$this->iTrustPayCBPTrxURL = $iTrustPayCBPTrxURL;
	}

	/**
	 * @return the $iTrustPayIECBPTrxURL
	 */
	public function getTrustPayIECBPTrxURL() {
		return $this->iTrustPayIECBPTrxURL;
	}

	/**
	 * @param string $iTrustPayIECBPTrxURL
	 */
	public function setTrustPayIECBPTrxURL($iTrustPayIECBPTrxURL) {
		$this->iTrustPayIECBPTrxURL = $iTrustPayIECBPTrxURL;
	}


	
}
?>