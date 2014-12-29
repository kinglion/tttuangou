<?php 
/**
 * 商户端接口软件包实体类，代表网上支付平台对商户提交交易的响应。
 */
class B2CAgentSignResult extends TrxResponse
{
	/**
	 * 构造B2CAgentSignResult对象，并使用网上支付平台的委托扣款签约解约结果的信息初始对象的属性。
	 * @param aMessage 网上支付平台的委托扣款签约解约结果的信息
	 * @throws TrxException 无法辨识网上支付平台的委托扣款签约解约结果的信息。
	 */
	public function __construct($aMessage)
	{
		try {
		$tLogWriter=new LogWriter();
		$tLogWriter->logNewLine('TrustPayClient PHP 交易开始==========================');
		$tLogWriter->logNewLine('接收到的结果通知：\n['.$aMessage.']');
		//1、还原经过base64编码的信息
		$tMessage=base64_decode($aMessage);
		$tLogWriter->logNewLine('经过Base64解码后的签约/解约结果通知：\n['.$tMessage.']');
		//2、取得经过签名验证的报文
		$tLogWriter->logNewLine('验证签约/解约结果通知的签名：');
		$tResult=MerchantConfig::verifySign($tMessage);
		$tLogWriter->logNewLine('验证通过！\n 经过验证的签约/解约结果通知：\n['.$tResult.']');
		//3、使用经过签名验证的报文初始对象本身
		$this->init($tResult);
			//finally php5.5
			if(!$tLogWriter)
			{
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('PayResultLog'));
			}
		}
		catch (TrxException $e)
		{
			$this->setReturnCode($e->getCode());
			$this->setErrorMessage($e->getMessage().'-'.$e->getDetailMessage());
			$tLogWriter->logs('验证失败！\n');
			//finally php5.5
			if(!$tLogWriter)
			{
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('PayResultLog'));
			}
		}
	}
}
?>