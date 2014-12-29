<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class IdentityVerifyRequest extends TrxRequest
{
	
	/** ֧������ش���ַ��󳤶� */
	const RESULT_NOTIFY_URL_LEN = 200;
	/** �����֤����ش���ַ */
	private $iResultNotifyURL = '';
	
	/** ���п��� */
	private $iBankCardNo = '';
	
	/** ֤������ */
	private $iCertificateType = '';
	
	/** ֤������ */
	private $iCertificateNo = '';
	
	/** �������� */
	private $iRequestDate ='';
	
	/** ����ʱ�� */
	private $iRequestTime = '';
	
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
	 * ����IdentityVerifyRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * ʹ��XML�ļ���ʼIdentityVerifyRequest��������ԡ�
	 * @param aXML ��ʼ�����XML�ļ���
	 */
	public function constructIdentityVerifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setBankCardNo($xml->getValueNoNull('BankCardNo'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		//???��ô��orderdate��ordertime��Ӧ����RequestDate��RequestTime
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));	
	}
	/**
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣ???orderdate ordertime
	 */
	protected function getRequestMessage()
	{
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_IDENTITY_VERIFY_REQ.'</TrxType>'.
			 '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			 '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			 '<BankCardNo>'.$this->iBankCardNo.'</BankCardNo>'.
			 '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
			 '<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
			 '<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
			 '</TrxRequest>';
		echo '�ش���Ϣ��'.$str;
		return $str;	 	 
	}
	/**
	 * ֧��������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	protected function checkRequest()
	{
		//��֤�Ƿ�Ϊ��
		if(!DataVerifier::isValidString($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'��֤����ش���ַ���Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�������ڲ��Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'����ʱ�䲻�Ϸ�');
		// 1.���鿨�źϷ���
		if(!DataVerifier::isValidBankCardNo($this->iBankCardNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���п��Ų��Ϸ�');
		// 2.����֤�����͡�֤������Ϸ���
		if(!DataVerifier::isValidCertificate($this->iCertificateType, $this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֤�����͡�֤�����벻�Ϸ�');
		// 3.����������URL�Ϸ���
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ش���ַ���Ϸ�');
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��֤����ش���ַ���Ϸ���');
		//4.У�鶨����󳤶�
		//		if (!DataVerifier.isValidString(iOrderNo,ILength.ORDERID_LEN))
		//			throw new TrxException(TrxException.TRX_EXC_CODE_1101,TrxException.TRX_EXC_MSG_1101,"�����ų��ȳ������ƻ�Ϊ��");
		//5.У�鶨�����ںϷ���
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
		//6.У�鶨�����ںϷ���
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
		
}

?>
