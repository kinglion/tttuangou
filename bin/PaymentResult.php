<?php 
/**
 * �̻��˽ӿ������ʵ���࣬��������֧��ƽ̨���̻��ύ���׵���Ӧ��
 */
class PaymentResult extends TrxResponse
{
	/**
	 * ����PaymentResult���󣬲�ʹ������֧��ƽ̨��֧���������Ϣ��ʼ��������ԡ�
	 * @param aMessage ����֧��ƽ̨��֧���������Ϣ
	 * @throws TrxException �޷���ʶ����֧��ƽ̨��֧���������Ϣ��
	 */
	public function __construct($aMessage)
	{
		try {
		 $tLogWriter=new LogWriter();
		 $tLogWriter->logNewLine('TrustPayClient PHP ���׿�ʼ==========================');
		 $tLogWriter->logNewLine('���յ���֧�����֪ͨ��\n['.$aMessage.']');
		 //1����ԭ����base64�������Ϣ
		 $tMessage=base64_decode($aMessage);
		 $tLogWriter->logNewLine('����Base64������֧�����֪ͨ��\n['.$tMessage.']');
		 //2��ȡ�þ���ǩ����֤�ı���
		 $tLogWriter->logNewLine('��֤֧�����֪ͨ��ǩ����');
		 $tResult=MerchantConfig::verifySign(new XMLDocument($tMessage));
		 $tLogWriter->logNewLine('��֤ͨ����\n ������֤��֧�����֪ͨ��\n['.$tResult.']');
		 //3��ʹ�þ���ǩ����֤�ı��ĳ�ʼ������
		 $this->init($tResult);
		 //finally
		 if($tLogWriter!=null)
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
			//finally
			$tLogWriter->logNewLine('���׽���==================================================');
			$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('PayResultLog'));
		}
	}
}
?>