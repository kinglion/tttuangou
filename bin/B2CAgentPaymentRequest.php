<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class B2CAgentPaymentRequest extends TrxRequest
{
	
	/**请求日期 */
	private $iRequestDate = "";
	
	/**请求时间 */
	private $iRequestTime = "";
	
	/**订单号 */
	private $iOrderNo = "";
	
	/**订单有效期 */
	private $iExpiredDate = 30;
	
	/**证件号码 */
	private $iCertificateNo = "";
	
	/**账单币种*/
	private $iCurrency = "";
	
	/**账单金额*/
	private $iAmount= "";
	
	/**商品编号*/
	private $iProductId = "";
	
	/**商品名称*/
	private $iProductName = "";
	
	/**商品数量*/
	private $iQuantity = "";
	
	/**签约协议号*/
	private $iAgentSignNo = "";
	
	/**
	 * 构造B2CAgentPaymentRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 初始B2CAgentPaymentRequest对象
	 */
	public function constructB2CAgentPaymentRequest($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setExpiredDate($xml->getValueNoNull('ExpiredDate'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCurrency($xml->getValueNoNull('Currency'));
		$this->setAmount($xml->getValueNoNull('Amount'));
		$this->setProductId($xml->getValueNoNull('ProductId'));
		$this->setProductName($xml->getValueNoNull('ProductName'));
		$this->setQuantity($xml->getValueNoNull('Quantity'));
		$this->setAgentSignNo($xml->getValueNoNull('AgentSignNo'));
	}
	
	
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_B2C_AgentPayment_REQ.'</TrxType>'.
			 '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
			 '<ExpiredDate>'.$this->iExpiredDate.'</ExpiredDate>'.
			 '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			 '<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
			 '<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
			 '<Currency>'.$this->iCurrency.'</Currency>'.
			 '<Amount>'.$this->iAmount.'</Amount>'.
			 '<ProductId>'.$this->iProductId.'</ProductId>'.
			 '<ProductName>'.$this->iProductName.'</ProductName>'.
			 '<Quantity>'.$this->iQuantity.'</Quantity>'.
			 '<AgentSignNo>'.$this->iAgentSignNo.'</AgentSignNo>'.
			 '</TrxRequest>';
		return $str;	 
	}
	protected function checkRequest()
	{
		//1.验证是否为空
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单号不合法');
		if(!DataVerifier::isValidString($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单日期不合法');
		if(!DataVerifier::isValidString($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单时间不合法');
		if(!DataVerifier::isValidString($this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'客户证件号码不合法');
		if(!DataVerifier::isValidString($this->iAgentSignNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'签约协议号不合法');
		if(!DataVerifier::isValidString($this->iCurrency))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'账单币种不合法');
		if(!DataVerifier::isValidString($this->iAmount))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'账单金额不合法');
		if(!DataVerifier::isValidString($this->iProductId))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'商品编号不合法');
		if(!DataVerifier::isValidString($this->iProductName))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'商品名称不合法');
		if(!DataVerifier::isValidString($this->iQuantity))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'商品数量不合法');
		//2.校验定单日期合法性
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单日期格式不正确');
		//3.校验定单时间合法性
		if(!DataVerifier::isValidTime($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单时间格式不正确');
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
	 * @return the $iRequestDate
	 */
	public function getRequestDate() {
		return $this->iRequestDate;
	}

	/**
	 * @param string $iRequestDate
	 */
	public function setRequestDate($iRequestDate) {
		$this->iRequestDate = $iRequestDate;
	}

	/**
	 * @return the $iRequestTime
	 */
	public function getRequestTime() {
		return $this->iRequestTime;
	}

	/**
	 * @param string $iRequestTime
	 */
	public function setRequestTime($iRequestTime) {
		$this->iRequestTime = $iRequestTime;
	}

	/**
	 * @return the $iOrderNo
	 */
	public function getOrderNo() {
		return $this->iOrderNo;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = $iOrderNo;
	}

	/**
	 * @return the $iExpiredDate
	 */
	public function getExpiredDate() {
		return $this->iExpiredDate;
	}

	/**
	 * @param number $iExpiredDate
	 */
	public function setExpiredDate($iExpiredDate) {
		$this->iExpiredDate = $iExpiredDate;
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
	 * @return the $iCurrency
	 */
	public function getCurrency() {
		return $this->iCurrency;
	}

	/**
	 * @param string $iCurrency
	 */
	public function setCurrency($iCurrency) {
		$this->iCurrency = $iCurrency;
	}

	/**
	 * @return the $iAmount
	 */
	public function getAmount() {
		return $this->iAmount;
	}

	/**
	 * @param string $iAmount
	 */
	public function setAmount($iAmount) {
		$this->iAmount = $iAmount;
	}

	/**
	 * @return the $iProductId
	 */
	public function getProductId() {
		return $this->iProductId;
	}

	/**
	 * @param string $iProductId
	 */
	public function setProductId($iProductId) {
		$this->iProductId = $iProductId;
	}

	/**
	 * @return the $iProductName
	 */
	public function getProductName() {
		return $this->iProductName;
	}

	/**
	 * @param string $iProductName
	 */
	public function setProductName($iProductName) {
		$this->iProductName = $iProductName;
	}

	/**
	 * @return the $iQuantity
	 */
	public function getQuantity() {
		return $this->iQuantity;
	}

	/**
	 * @param string $iQuantity
	 */
	public function setQuantity($iQuantity) {
		$this->iQuantity = $iQuantity;
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
		$this->iAgentSignNo = $iAgentSignNo;
	}


	
}
?>