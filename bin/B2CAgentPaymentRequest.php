<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class B2CAgentPaymentRequest extends TrxRequest
{
	
	/**�������� */
	private $iRequestDate = "";
	
	/**����ʱ�� */
	private $iRequestTime = "";
	
	/**������ */
	private $iOrderNo = "";
	
	/**������Ч�� */
	private $iExpiredDate = 30;
	
	/**֤������ */
	private $iCertificateNo = "";
	
	/**�˵�����*/
	private $iCurrency = "";
	
	/**�˵����*/
	private $iAmount= "";
	
	/**��Ʒ���*/
	private $iProductId = "";
	
	/**��Ʒ����*/
	private $iProductName = "";
	
	/**��Ʒ����*/
	private $iQuantity = "";
	
	/**ǩԼЭ���*/
	private $iAgentSignNo = "";
	
	/**
	 * ����B2CAgentPaymentRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * ��ʼB2CAgentPaymentRequest����
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
		//1.��֤�Ƿ�Ϊ��
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�������ڲ��Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'����ʱ�䲻�Ϸ�');
		if(!DataVerifier::isValidString($this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�ͻ�֤�����벻�Ϸ�');
		if(!DataVerifier::isValidString($this->iAgentSignNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'ǩԼЭ��Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iCurrency))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�˵����ֲ��Ϸ�');
		if(!DataVerifier::isValidString($this->iAmount))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�˵����Ϸ�');
		if(!DataVerifier::isValidString($this->iProductId))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'��Ʒ��Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iProductName))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'��Ʒ���Ʋ��Ϸ�');
		if(!DataVerifier::isValidString($this->iQuantity))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'��Ʒ�������Ϸ�');
		//2.У�鶨�����ںϷ���
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
		//3.У�鶨��ʱ��Ϸ���
		if(!DataVerifier::isValidTime($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ʱ���ʽ����ȷ');
	}
	/**
	 * �ش�������Ӧ����
	 * @return ���ױ�����Ϣ
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