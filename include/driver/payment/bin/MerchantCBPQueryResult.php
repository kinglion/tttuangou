<?php 
/**
 * �̻��˽ӿ������ʵ���࣬��������֧��ƽ̨���̻��ύ���׵���Ӧ��
 */
class MerchantCBPQueryResult
{
	/**
	 * �̻���־
	 */
	private $iLogWriter=null;
	protected $tMerchantConfig = null;
	
	/** ��Ӧ��*/
	private $iReturnCode='';
	
	/** ������Ϣ*/
	private $iErrorMsg='';
	
	/** ΪItems�����ArrayList���ϡ�*/
	private $iItems = array();
	
	/**
	 * ����MerchantCBPQueryResult���󣬲�ʹ������֧��ƽ̨��֧����ѯ�������Ϣ��ʼ��������ԡ�
	 * @param aMessage ����֧��ƽ̨��֧���������Ϣ
	 * @throws TrxException �޷���ʶ����֧��ƽ̨��֧���������Ϣ��
	 */
	public function __construct($aMessage)
	{
		try {
		$tLogWriter=new LogWriter();
		$tLogWriter->logNewLine('CBPTrustPayClient Java V2.0����ũ��֧��ƽ̨��ѯ�˵�����ʼ==========================');
		$tLogWriter->logNewLine('CBP���յ���ũ��֧��ƽ̨��ѯ�˵�����\n['.$aMessage.']');
		//1����ԭ����base64�������Ϣ
		$tMessage=base64_decode($aMessage);
		//$tMessage=iconv('gb2312', 'gb2312', $tMessage);
		$tLogWriter->logNewLine('����Base64�����Ĳ�ѯ�˵�����\n['.$tMessage.']');
		//2��ȡ�þ���ǩ����֤�ı���
		$tLogWriter->logNewLine('��֤��ѯ�˵������ǩ����');
		$tResult=MerchantConfig::verifySign($tMessage);
		$tLogWriter->logNewLine('��֤ͨ����\n ������֤�Ĳ�ѯ�˵�����\n['.$tResult.']');
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
			if($tLogWriter!=null)
			{
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));	
			}
		}
	}
	public function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iItems=array();
		$this->iItems=$xml->getValueArray('Item');
	}
	/**
	 * ������ǩ���ı��ĺ������̻�ͨ��ҳ�洫��������ũ��b2c����ʱ���øú�����
	 * @return ǩ����ı���
	 */
	public  function genSignature($i,$RequestMessage)
	{
		
		try {
		$tResponseMesg='';
		$iLogWriter=new LogWriter();	
		$iLogWriter->logNewLine('CBP������֧��ƽ̨��Ӧũ�в�ѯ��������׿�ʼ==========================');
		//2��ȡ�ý��ױ���
		$iLogWriter->logNewLine('������֧��ƽ̨��ѯ�����Ӧ���ģ�');
		$iLogWriter->logNewLine($RequestMessage);
		//3������������ױ���
		$iLogWriter->logNewLine('����������֧��ƽ̨��ѯ�����Ӧ���ģ�');
		$tRequestMessage=new XMLDocument($RequestMessage);
		//4���Խ��ױ��Ľ���ǩ��
		$iLogWriter->logNewLine('��Ӧǩ����ı��ģ�');
		$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
		$tTempStringBuffer='<MSG>'.$tRequestMessage.'</MSG>';
		$tResponseMesg=$tTempStringBuffer;
		$iLogWriter->logNewLine('���ظ�ũ��֧��ƽ̨�Ĳ�ѯ������ģ�\n').$tResponseMesg;
		$tResponseMesg=base64_encode(DataVerifier::stringToByteArrayGB2312($tResponseMesg));
		$iLogWriter->logNewLine('���ظ�ũ��֧��ƽ̨����Base64���ܵĲ�ѯ������ģ�\n'.$tResponseMesg);
		//finally
		if($iLogWriter!=null)
		{
			$iLogWriter->logNewLine('"���׽���==================================================');
			$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
		}
		}
		catch (TrxException $e){
			if($iLogWriter!=null)
				$iLogWriter->logNewLine('������룺['.$e->getCode().']    ������Ϣ��['.$e->getMessage().'-'.$e->getDetailMessage().']');
			throw new TrxException($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());
		}
		catch (Exception $e){
			if($iLogWriter!=null)
				$iLogWriter->logNewLine('������룺['.TrxException::TRX_EXC_CODE_1999).']     ������Ϣ��['.TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage().']';
			throw new TrxException(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage());
		}
		return $tResponseMesg;
	}
	public function  getXMLDocument()
	{
		$str1='<Items>';
		$str2='';
	  	for($i=0;$i<count($this->iItems);$i++)
		{
			$item=new Items();		
			$tOrderItem=$this->iItems[i];
			$item->constructItems($tOrderItem);
			$str2 .= $item->getXMLDocument();		
		}
		$str3='</Items>';
		return $str1.$str2.$str3;
	}
	public function addItem($aItem)
	{
		if(!$this->iItems)
		{
			$this->iItems=array();
			$this->iItems[0]=$aItem;
		}
		else 
		{
			//array_push($this->iItems, $aItem);
			$num=count($this->iItems);
			$this->iItems[num]=$aItem;
		}
	}
	/**
	 * @return the $iItems
	 */
	public function getItems()
	{
		return $this->iItems;
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