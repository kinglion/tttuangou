<?php 
/**
 * �̻��˽ӿ������ҵ�����࣬�����̻��ύ֧������Ĵ���
 */
class FundPaymentRequest extends TrxRequest
{
	/** ��Ʒ���ࣺ��ʵ����Ʒ�������IP��������MP3��... */
	const PRD_TYPE_ONE       =   "1";
	
	/** ��Ʒ���ࣺʵ����Ʒ */
	const PRD_TYPE_TWO       =   "2";
	
	/** ֧�����ͣ�ũ�п�֧�� */
	const PAY_TYPE_ABC       =   "1";
	
	/** ֧�����ͣ����ʿ�֧�� */
	const PAY_TYPE_INT       =   "2";
	
	/** ֪ͨ�̻����ͣ�URL֪ͨ */
	const NOTIFY_TYPE_URL    =   "0";
	
	/** ֪ͨ�̻����ͣ�������֪ͨ */
	const NOTIFY_TYPE_SERVER =   "1";
	
	/** ֧������ش���ַ��󳤶� */
	const RESULT_NOTIFY_URL_LEN = 200;
	
	/** �̻���ע��Ϣ��󳤶� */
	const MERCHANT_REMARKS_LEN  = 200;
	
	/** �������� 1 ����֧�� 2 ������ */
	const TRX_OPEN_ACCOUNT = "1";
	
	const TRX_BUY_FUND = "2";
	
	/** �������� */
	private $iOrder           = null;
	
	/** ��Ʒ���� */
	private  $iProductType    = self::PRD_TYPE_ONE;
	
	/** ֪ͨ�̻����� */
	private $iNotifyType      = self::NOTIFY_TYPE_URL;
	
	/** ֧������ */
	private $iPaymentType     = self::PAY_TYPE_ABC;
	
	/** ֧������ش���ַ */
	private $iResultNotifyURL = '';
	
	/** �̻���ע��Ϣ TrxRequest�Ѷ���Ϊprotected
	private $iMerchantRemarks = '';
	*/
	
	/** �������� 1 ������2 �����깺*/
	private $iTrxSubType = '';
	
	/** ֤������*/
	private $iCertificateNo = '';
	
	/** ֤������*/
	private $iCertificateType = '';
	
	/** �����˺�*/
	private $iBankCardNo = '';
	
	/**
	 * ����FundPaymentRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	public function constructFundPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
		$this->setPaymentType($xml->getValueNoNull('PaymentType'));
		$this->setProductType($xml->getValueNoNull('ProductType'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setMerchantRemarks($xml->getValueNoNull('MerchantRemarks'));
		$this->setBankCardNo($xml->getValueNoNull('BankCardNo'));
		$this->setTrxSubType($xml->getValueNoNull('TrxSubType'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
	 */
	protected function checkRequest() 
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$tMessage='<TrxRequest>'.
				  '<TrxType>'.TrxType::TRX_TYPE_FUND_PAY_REQ.'</TrxType>'.
				  $ord->getXMLDocument(1).
				  '<ProductType>'.$this->iProductType.'</ProductType>'.
				  '<PaymentType>'.$this->iPaymentType.'</PaymentType>'.
				  '<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
				  '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
				  '<MerchantRemarks>'.$this->iMerchantRemarks.'</MerchantRemarks>'.
				  '<TrxSubType>'.$this->iTrxSubType.'</TrxSubType>'.
				  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
				  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
				  '<BankCardNo>'.$this->iBankCardNo.'</BankCardNo>'.
				  '</TrxRequest>';
		return $tMessage;
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * ֧��������Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	 protected function getRequestMessage() 
	 {
	 	$order=new Order();
	 	$order->__constructXMlDocument($this->iOrder);
	 	if($this->iOrder==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������Ϣ');
	 	if($this->iProductType==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨��Ʒ���࣡');
	 	if($this->iResultNotifyURL==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨֧������ش���ַ��');
	 	if(!$order->isValid())
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������Ϣ���Ϸ���');
	 	if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��Ʒ���಻�Ϸ���');
	 	if($this->iPaymentType != self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����Ͳ��Ϸ���');
	 	if($this->iNotifyType != self::NOTIFY_TYPE_SERVER && $this->iNotifyType != self::NOTIFY_TYPE_URL)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����֪ͨ���Ͳ��Ϸ���');
	 	if(!DataVerifier::isValidURL($this->iResultNotifyURL))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
	 	if(!strlen(trim($this->iResultNotifyURL)))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
	 	//getBytes
	 	if(strlen(trim($this->iResultNotifyURL))>self::RESULT_NOTIFY_URL_LEN)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�̻���ע��Ϣ���Ϸ���');
	 	if($this->iTrxSubType!=self::TRX_BUY_FUND && $this->iTrxSubType!=self::TRX_OPEN_ACCOUNT)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������������Ϣ���Ϸ���');
	 	if(strlen(trim($this->iBankCardNo))==0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		return new TrxResponse($aResponseMessage);
	 }
	/**
	 * @return the $iOrder
	 */
	public function getOrder() {
		return $this->iOrder;
	}

	/**
	 * @param NULL $iOrder
	 */
	public function setOrder($iOrder) {
		$this->iOrder = $iOrder;
	}

	/**
	 * @return the $iProductType
	 */
	public function getProductType() {
		return $this->iProductType;
	}

	/**
	 * @param string $iProductType
	 */
	public function setProductType($iProductType) {
		$this->iProductType = $iProductType;
	}

	/**
	 * @return the $iNotifyType
	 */
	public function getNotifyType() {
		return $this->iNotifyType;
	}

	/**
	 * @param string $iNotifyType
	 */
	public function setNotifyType($iNotifyType) {
		$this->iNotifyType = $iNotifyType;
	}

	/**
	 * @return the $iPaymentType
	 */
	public function getPaymentType() {
		return $this->iPaymentType;
	}

	/**
	 * @param string $iPaymentType
	 */
	public function setPaymentType($iPaymentType) {
		$this->iPaymentType = $iPaymentType;
	}

	/**
	 * @return the $iResultNotifyURL
	 */
	public function getResultNotifyURL() {
		return $this->iResultNotifyURL;
	}

	/**
	 * @param string $iResultNotifyURL
	 */
	public function setResultNotifyURL($iResultNotifyURL) {
		$this->iResultNotifyURL = $iResultNotifyURL;
	}

	/**
	 * @return the $iTrxSubType
	 */
	public function getTrxSubType() {
		return $this->iTrxSubType;
	}

	/**
	 * @param string $iTrxSubType
	 */
	public function setTrxSubType($iTrxSubType) {
		$this->iTrxSubType = $iTrxSubType;
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

	/**
	 * @return the $iBankCardNo
	 */
	public function getBankCardNo() {
		return $this->iBankCardNo;
	}

	/**
	 * @param string $iBankCardNo
	 */
	public function setBankCardNo($iBankCardNo) {
		$this->iBankCardNo = $iBankCardNo;
	}


	
}
?>