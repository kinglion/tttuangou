<?php 
/**
 * �̻��˽ӿ������ʵ���࣬��������֧��ƽ̨���̻��ύ���׵���Ӧ��
 */
class B2CAgentSignResult extends TrxResponse
{
	/**
	 * ����B2CAgentSignResult���󣬲�ʹ������֧��ƽ̨��ί�пۿ�ǩԼ��Լ�������Ϣ��ʼ��������ԡ�
	 * @param aMessage ����֧��ƽ̨��ί�пۿ�ǩԼ��Լ�������Ϣ
	 * @throws TrxException �޷���ʶ����֧��ƽ̨��ί�пۿ�ǩԼ��Լ�������Ϣ��
	 */
	public function __construct($aMessage)
	{
		try {
		$tLogWriter=new LogWriter();
		$tLogWriter->logNewLine('TrustPayClient PHP ���׿�ʼ==========================');
		$tLogWriter->logNewLine('���յ��Ľ��֪ͨ��\n['.$aMessage.']');
		//1����ԭ����base64�������Ϣ
		$tMessage=base64_decode($aMessage);
		$tLogWriter->logNewLine('����Base64������ǩԼ/��Լ���֪ͨ��\n['.$tMessage.']');
		//2��ȡ�þ���ǩ����֤�ı���
		$tLogWriter->logNewLine('��֤ǩԼ/��Լ���֪ͨ��ǩ����');
		$tResult=MerchantConfig::verifySign($tMessage);
		$tLogWriter->logNewLine('��֤ͨ����\n ������֤��ǩԼ/��Լ���֪ͨ��\n['.$tResult.']');
		//3��ʹ�þ���ǩ����֤�ı��ĳ�ʼ������
		$this->init($tResult);
			//finally php5.5
			if(!$tLogWriter)
			{
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('PayResultLog'));
			}
		}
		catch (TrxException $e)
		{
			$this->setReturnCode($e->getCode());
			$this->setErrorMessage($e->getMessage().'-'.$e->getDetailMessage());
			$tLogWriter->logs('��֤ʧ�ܣ�\n');
			//finally php5.5
			if(!$tLogWriter)
			{
				$tLogWriter->logNewLine('���׽���==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('PayResultLog'));
			}
		}
	}
}
?>