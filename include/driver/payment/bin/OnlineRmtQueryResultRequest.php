<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class OnlineRmtQueryResultRequest extends TrxRequest
{
	/**
	 * ������ˮ��
	 */
	private $iSerialNumber = '';

	/**
	 * ����˺�
	 */
	private $iPayAccount = '';
	
	/**
	 * �տ�˺�
	 */
	private $iReceiveAccount = '';
	
	/**
	 * ��ʼ����
	 */
	private $iStartTime = '';
	
	
	private $iEndTime = '';

	/**
	 * ��ע
	 */
	private $iRemark = '';
	
	/**
	 * ����OnlineRmtQueryResultRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * ���ϸ���׽����ѯ��Ϣ�Ƿ�Ϸ�
	 */
	protected function checkRequest()
	{
		//1.������ˮ�ź��տ�˺Ų���ͬʱΪ��
		if(!$this->iSerialNumber && !$this->iReceiveAccount)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'������ˮ�ź��տ�˺�ͬʱΪ��');
		//2.У����ʼ���ںϷ���
		if(!DataVerifier::isValidDate($this->iStartTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��ʼ���ڸ�ʽ����ȷ');
		//3.У���ֹ���ںϷ���
		if(!DataVerifier::isValidDate($this->iEndTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��ֹ���ڸ�ʽ����ȷ');
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	 protected function getRequestMessage() 
	 {
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_ONLINERMTQUERYRESULT.'</TrxType>'.
			 '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
			 '<ReceiveAccount>'.$this->iReceiveAccount.'</ReceiveAccount>'.
			 '<StartTime>'.$this->iStartTime.'</StartTime>'.
			 '<EndTime>'.$this->iEndTime.'</EndTime>'.
			 '</TrxRequest>';
		return $str;
			 
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	
	
	public function getSerialNumber()
	{
		return $this->iSerialNumber;
	}
	
	public function setSerialNumber($tSerialNumber)
	{
		$this->iSerialNumber=trim($tSerialNumber);
	}	
	public function getPayAccount()
	{
		return $this->iPayAccount;
	}
	
	public function setPayAccount($tPayAccount)
	{
		$this->iPayAccount=trim($tPayAccount);
	}	
	public function getReceiveAccount()
	{
		return $this->iReceiveAccount;
	}
	
	public function setReceiveAccount($tReceiveAccount)
	{
		$this->iReceiveAccount=$tReceiveAccount;
	}
	
	public function getStartTime()
	{
		return $this->iStartTime;
	}
	
	public function setStartTime($tStartTime)
	{
		$this->iStartTime=$tStartTime;
	}
	public function getEndTime()
	{
		return $this->iStartTime;
	}
	
	public function setEndTime($tEndTime)
	{
		$this->iEndTime=$tEndTime;
	}
	
	public function getRemark()
	{
		return $this->iRemark;
	}
	
	public function setRemark($tRemark)
	{
		$this->iRemark = $tRemark;
	}
	
}

?>