<?php 
/**
 * �̻��˽ӿ������ʵ���࣬��������֧��ƽ̨���̻��ύ���׵���Ӧ��
 */
class MerchantCBPReceiverPay 
{
	/**
	 * �̻���־
	 */
	private $iLogWriter = null;
	protected $tMerchantConfig = null;
	
	/** ��Ʒ���� */
	private $iCBPOrderNo     = '';
	
	/** ֪ͨ�̻����� */
	private $iClientIP      = '';
	private $iIsSuppCredit      = '';
	
	private $iOrderDate  = '';
	/** ֧������ */
	private $iResultURL     = '';
	/** ������� */
	private $iOrderAmt = 0;
	
	private $iReturnCode='';
	private $iErrorMsg='';
	
	/**
	 * ����PaymentResult���󣬲�ʹ������֧��ƽ̨��֧���������Ϣ��ʼ��������ԡ�
	 * @param aMessage ����֧��ƽ̨��֧���������Ϣ
	 * @throws TrxException �޷���ʶ����֧��ƽ̨��֧���������Ϣ��
	 */
	public function __construct()
	{
		
	}
	public function constructMerchantCBPReceiverPay($aMessage)
	{	
		try {
			$tLogWriter=new LogWriter();
			$tLogWriter->logNewLine('CBPTrustPayClient PHP��֤ũ��֧��ƽ̨֧������ʼ==========================');
			$tLogWriter->logNewLine('CBP���յ���ũ��֧��ƽ̨֧������\n['.$aMessage.']');
			//1����ԭ����base64�������Ϣ
			$tMessage=base64_decode($aMessage);
			$tLogWriter->logNewLine('����Base64������֧������\n['.$tMessage.']');
			//2��ȡ�þ���ǩ����֤�ı���
			$tLogWriter->logNewLine('��֤֧�������ǩ����');
			$tResult=MerchantConfig::verifySign($tMessage);
			$tLogWriter->logNewLine('��֤ͨ����\n ������֤��֧������\n['.$tResult.']');
			//3��ʹ�þ���ǩ����֤�ı��ĳ�ʼ������
			$this->initCBP($tResult);
			$this->setReturnCode('0000');
			$this->setErrorMsg('���׳ɹ�');
			//finally
			if($tLogWriter!=null)
			{
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			}			
		}
		catch (TrxException $e)
		{
			$tLogWriter->logs('��֤ʧ�ܣ�\n');
			$this->setReturnCode($e->getCode());
			$this->setErrorMsg($e->getMessage().'-'.$e->getDetailMessage());	
			//finally
			if($tLogWriter!=null)
			{
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			}
		}
	}
	protected function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		
		$tOrdId=$xml->getValue('OrdId');
		if($tOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[OrdId]!');
		$this->setOrdId($tOrdId);
		
		$tTransAmount=$xml->getValue('TransAmt');
		if($tTransAmount== null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[TransAmt]!');
		$this->setTransAmt($tTransAmount);
		
		$tOrderDate=$xml->getValue('OrderDate');
		if($tOrderDate == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[OrderDate]!');
		$this->setOrderDate($tOrderDate);
		
		$tClientIP=$xml->getValue('ClientIP');
		if($tClientIP == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[tClientIP]!');
		$this->setClientIP($tClientIP);
		
		$IsSuppCredit=$xml->getValue('IsSuppCredit');		
		if($IsSuppCredit==null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[IsSuppCredit]!');
		$this->setIsSuppCredit($IsSuppCredit);
		$tResultURL=$xml->getValue('ResultURL');
		if($tResultURL == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[ResultURL]!');
		$this->setResultURL($tResultURL);
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
	 * @return the $iClientIP
	 */
	public function getClientIP() {
		return $this->iClientIP;
	}

	/**
	 * @param string $iClientIP
	 */
	public function setClientIP($iClientIP) {
		$this->iClientIP = $iClientIP;
	}

	/**
	 * @return the $iIsSuppCredit
	 */
	public function getIsSuppCredit() {
		return $this->iIsSuppCredit;
	}

	/**
	 * @param string $iIsSuppCredit
	 */
	public function setIsSuppCredit($iIsSuppCredit) {
		$this->iIsSuppCredit = $iIsSuppCredit;
	}

	/**
	 * @return the $iOrderDate
	 */
	public function getOrderDate() {
		return $this->iOrderDate;
	}

	/**
	 * @param string $iOrderDate
	 */
	public function setOrderDate($iOrderDate) {
		$this->iOrderDate = $iOrderDate;
	}

	/**
	 * @return the $iResultURL
	 */
	public function getResultURL() {
		return $this->iResultURL;
	}

	/**
	 * @param string $iResultURL
	 */
	public function setResultURL($iResultURL) {
		$this->iResultURL = $iResultURL;
	}

	/**
	 * @return the $iOrderAmt
	 */
	public function getOrderAmt() {
		return $this->iOrderAmt;
	}

	/**
	 * @param number $iOrderAmt
	 */
	public function setOrderAmt($iOrderAmt) {
		$this->iOrderAmt = $iOrderAmt;
	}

	/**
	 * @return the $iReturnCode
	 */
	public function getReturnCode() {
		return $this->iReturnCode;
	}

	/**
	 * @param string $iReturnCode
	 */
	public function setReturnCode($iReturnCode) {
		$this->iReturnCode = $iReturnCode;
	}

	/**
	 * @return the $iErrorMsg
	 */
	public function getErrorMsg() {
		return $this->iErrorMsg;
	}

	/**
	 * @param string $iErrorMsg
	 */
	public function setErrorMsg($iErrorMsg) {
		$this->iErrorMsg = $iErrorMsg;
	}

}
?>