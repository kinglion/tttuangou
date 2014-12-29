<?php 
class MerchantCBPRefundResult
{
	/** ��Ʒ���� */
	private $iOrdId = '';
	
	/** ֪ͨ�̻����� */
	private $iRefOrdId = '';
	
	/** ֧������ */
	private $iTransType = '';
	/** ������� */
	private $iTransAmt = 0;
	private $iReturnCode='';
	private $iErrorMsg='';
	
	public function __construct()
	{
		
	}
	public function constructMerchantCBPRefundResult($aMessage)
	{
		try
		{
			$tLogWriter=new LogWriter();
			$tLogWriter->logNewLine('CBPTrustPayClient PHP��֤ũ��֧��ƽ̨�˿�����ʼ==========================');
			$tLogWriter->logNewLine('CBP���յ���ũ��֧��ƽ̨�˿�����\n['.$aMessage.']');
			//1����ԭ����base64�������Ϣ
			$tMessage=base64_decode($aMessage);
			$tLogWriter->logNewLine('����Base64�������˿�����\n['.$tMessage.']');
			//2��ȡ�þ���ǩ����֤�ı���
			$tLogWriter->logNewLine('��֤�˿������ǩ����');
			$tResult=MerchantConfig::verifySign($tMessage);
			$tLogWriter->logNewLine('��֤ͨ����\n ������֤���˿�����\n['.$tResult.']');
			//3��ʹ�þ���ǩ����֤�ı��ĳ�ʼ������
			$this->initCBP($tResult);
			$this->setReturnCode('0000');
			$this->setErrorMsg('���׳ɹ�');
			
			if($tLogWriter != null)
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
				
			
		}
		catch (TrxException $e){
			$tLogWriter->logs('��֤ʧ�ܣ�\n');
			$this->setReturnCode($e->getCode());
			$this->setErrorMsg($e->getMessage().'-'.$e->getDetailMessage());
			//finally
			if($tLogWriter != null)
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			
		}
		
	}
	public function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		
		$tOrdId=$xml->getValue('OrdId');
		if($tOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[OrdId]!');
		$this->setOrdId($tOrdId);
		
		$tRefOrdId=$xml->getValue('RefOrdId');
		if($tRefOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[RefOrdId]!');
		$this->setRefOrdId($tRefOrdId);
		
		$tTransType=$xml->getValue('TransType');
		if($tTransType == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[TransType]!');
		$this->setTransType($tTransType);
		
		$tTransAmount=$xml->getValue('TransAmt');
		if($tTransAmount== null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'�޷�ȡ��[TransAmt]!');
		$this->setTransAmt($tTransAmount);
	}
	public function genSignature($i,$RequestMessage)
	{
		$tResponseMesg='';
		try{
			$iLogWriter=new LogWriter();
			$iLogWriter->logNewLine('CBP������֧��ƽ̨��Ӧũ���˿������׿�ʼ==========================');
			//2��ȡ�ý��ױ���
			$iLogWriter->logNewLine('������֧��ƽ̨�˿���Ӧ����');
			$iLogWriter->logNewLine($RequestMessage);
			//3������������ױ���
			$iLogWriter->logNewLine('�����˿���Ӧ���ģ�');
			$tRequestMessage=new XMLDocument($RequestMessage);
			//4���Խ��ױ��Ľ���ǩ��
			$iLogWriter->logNewLine('��Ӧǩ����ı��ģ�');
			$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
			$tTempStringBuffer='<MSG>'.$tRequestMessage.'</MSG>';
			$tResponseMesg=$tTempStringBuffer;
			$iLogWriter->logNewLine('���ظ�ũ��֧��ƽ̨���˿�ģ�\n'.$tResponseMesg);
			$tResponseMesg=base64_encode(DataVerifier::stringToByteArrayGB2312($tResponseMesg));
			$iLogWriter->logNewLine('���ظ�ũ��֧��ƽ̨����Base64���ܵ��˿�ģ�\n'.$tResponseMesg);
			//finally
			if($iLogWriter!=null)
			{
				$iLogWriter->logNewLine('���׽���==================================================');
				$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			}
		}
		catch (TrxException $e)
		{
			if($iLogWriter != null)
				$iLogWriter->logNewLine('������룺['.$e->getCode().']    ������Ϣ��['.$e->getMessage().'-'.$e->getDetailMessage().']');
			throw new TrxException($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());			
		//finally
			  $iLogWriter->logNewLine('���׽���==================================================');
			  $iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			  
		}
		catch (Exception $e)
		{
			if($iLogWriter != null)
				$iLogWriter->logNewLine('������룺['.TrxException::TRX_EXC_CODE_1999.']    ������Ϣ��['.TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage().']');
			throw new TrxException(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage());			
			//finally
			$iLogWriter->logNewLine('���׽���==================================================');
			$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
		}
		
        return $tResponseMesg;
	}
	/**
	 * @return the $iOrdId
	 */
	public function getOrdId() {
		return $this->iOrdId;
	}

	/**
	 * @param string $iOrdId
	 */
	public function setOrdId($iOrdId) {
		$this->iOrdId = $iOrdId;
	}

	/**
	 * @return the $iRefOrdId
	 */
	public function getRefOrdId() {
		return $this->iRefOrdId;
	}

	/**
	 * @param string $iRefOrdId
	 */
	public function setRefOrdId($iRefOrdId) {
		$this->iRefOrdId = $iRefOrdId;
	}

	/**
	 * @return the $iTransType
	 */
	public function getTransType() {
		return $this->iTransType;
	}

	/**
	 * @param string $iTransType
	 */
	public function setTransType($iTransType) {
		$this->iTransType = $iTransType;
	}

	/**
	 * @return the $iTransAmt
	 */
	public function getTransAmt() {
		return $this->iTransAmt;
	}

	/**
	 * @param number $iTransAmt
	 */
	public function setTransAmt($iTransAmt) {
		$this->iTransAmt = $iTransAmt;
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