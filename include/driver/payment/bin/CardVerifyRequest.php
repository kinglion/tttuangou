<?php 
class CardVerifyRequest extends TrxRequest
{
	/** 商户通知URL*/
	private $iResultNotifyURL = null;
	
	/** 证件号码*/
	private $iCertificateNo = '';
	
	/** 证件类型*/
	private $iCertificateType = '';
	
	
	/**
	 * 构造CardVerifyRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * 初始化CardVerifyRequest对象属性
	 */
	public function constructCardVerifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 信息是否合法
     * @throws TrxException: 请求不合法
	 */
	protected function checkRequest() 
	{
		if(strlen(trim($this->iCertificateNo)) ==0 || strlen((trim($this->iCertificateType))) == 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
		if(strlen(trim($this->iResultNotifyURL)) == 0)
			throw  new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 		  '<TrxType>'.TrxType::TRX_TYPE_CARD_VERIFY_REQ.'</TrxType>'.
	 	 		  '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
	 	 		  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
	 	 		  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
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
	 * @return the $iResultNotifyURL
	 */
	public function getResultNotifyURL() {
		return $this->iResultNotifyURL;
	}

	/**
	 * @param NULL $iResultNotifyURL
	 */
	public function setResultNotifyURL($iResultNotifyURL) {
		$this->iResultNotifyURL = $iResultNotifyURL;
	}

	/**
	 * @return the $iCertificateNo
	 */
	public function getCertificateNo() {
		return $this->iCertificateNo;
	}

	/**
	 * @param string $iCertificateNo
	 */
	public function setCertificateNo($iCertificateNo) {
		$this->iCertificateNo = $iCertificateNo;
	}

	/**
	 * @return the $iCertificateType
	 */
	public function getCertificateType() {
		return $this->iCertificateType;
	}

	/**
	 * @param string $iCertificateType
	 */
	public function setCertificateType($iCertificateType) {
		$this->iCertificateType = $iCertificateType;
	}


	
}
?>