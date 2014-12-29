<?php 
/**
 * �̻��˽ӿ������ʵ���࣬�������ϸ���׽����ѯ�����
 *
 */
class QueryResult
{
	/**
	 * ��ѯ�����ϸ��ΪQueryResultItem���������
	 */
	private $iQueryResultItems = array();
	
	/**
	 * ������ˮ��
	 */
	private $iSerialNumber = '';
	
	/**
	 * ����ʱ��
	 */
	private $iTrnxTime = '';
	
	/**
	 * ������ˮ��
	 */
	private $iNo = '';
	
	/**
	 * ����˺�
	 */
	private $iPayAccountNo = '';
	
	/**
	 * �������
	 */
	private $iPayAccountName = '';
	
	/**
	 * �տ�˺�
	 */
	private $iReceiveAccountNo = '';
	
	/**
	 * �տ����
	 */
	private $iReceiveAccountName = '';
	
	/**
	 * ��;
	 */
	private $iPurpose = '';
	
	/**
	 * ������
	 */
	private $iPayAmount = 0;

	/**
	 * ����״̬
	 */
	private $iStatus = '';

	/**
	 * ʧ��ԭ��
	 */
	private $iFailReason = '';
	/**
	 * ����QueryResult����
	 *
	 */
	public function __construct()
	{
	
	}
	/**
	 * ��ʹ��XML�ļ���ʼQueryResult��������ԡ�
	 * @param $aXMLDocument ��ʼ�����XML�ļ���
	 */
	public function constructQueryResult($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iNo=$xml->getValueNoNull('No');
		$this->iSerialNumber=$xml->getValueNoNull('SerialNumber');
		$this->iTrnxTime=$xml->getValueNoNull('TrnxTime');
		$this->iPayAccountNo=$xml->getValueNoNull('PayAccount');
		$this->iPayAccountName=$xml->getValueNoNull('PayAccountName');
		$this->iReceiveAccountNo=$xml->getValueNoNull('ReceiveAccount');
		$this->iReceiveAccountName=$xml->getValueNoNull('ReceiveAccountName');
		$this->iPurpose=$xml->getValueNoNull('Purpose');
		$this->iStatus=$xml->getValueNoNull('Status');
		$this->iFailReason=$xml->getValueNoNull('FailReason');
		$this->iPayAmount=$xml->getValueNoNull('PayAmount');
		$this->iQueryResultItems=$xml->getValueArray('BatchItem');
	}
	/**
	 * ������ѯ�����ϸ
	 * @param aQueryResultItem ��ѯ�����ϸ��QueryResultItem������
	 * @return ������
	 */
	public function addQueryResultItem($aQueryResultItem)
	{
		if(!$this->iQueryResultItems)
		{
			$this->iQueryResultItems= array();
			$this->iQueryResultItems[0]=$aQueryResultItem;
		}
		else
		{
			array_push($this->iQueryResultItems, $aQueryResultItem);
		}
	}
	
	public function  getQueryResultItems()
	{
		return $this->iQueryResultItems;
	}
	
	public function getSerialNumber()
	{
		return $this->iSerialNumber;
	}
	
	public function setSerialNumber($tSerialNumber)
	{
		$this->iSerialNumber=trim($tSerialNumber);
	}
	
	public function getTrnxTime()
	{
		return $this->iTrnxTime;
	}
	
	public function setTrnxTime($tTrnxTime)
	{
		$this->iTrnxTime=$tTrnxTime;
	}
	
	public function getNo()
	{
		return $this->iNo;
	}
	
	public function setNo($tNo)
	{
		$this->iNo=trim($tNo);
	}
	
	public function getPayAccountNo()
	{
		return $this->iPayAccountNo;
	}
	
	public function setPayAccountNo($tPayAccountNo)
	{
		$this->iPayAccountNo = trim($tPayAccountNo);
	}
	public function getPayAccountName()
	{
		return $this->iPayAccountName;
	}
	
	public function setPayAccountName($tPayAccountName)
	{
		$this->iPayAccountName=trim($tPayAccountName);
	}
	public function getReceiveAccountNo()
	{
		return $this->iReceiveAccountNo;
	}
	public function setReceiveAccountNo($tReceiveAccountNo)
	{
		$this->iReceiveAccountNo=trim($tReceiveAccountNo);
	}
	public function getReceiveAccountName()
	{
		return $this->iReceiveAccountName;
	}
	
	public function setReceiveAccountName($tReceiveAccountName)
	{
		$this->iReceiveAccountName=trim($tReceiveAccountName);
	}
	
	public function getPurpose()
	{
		return $this->iPurpose;
	}
	
	public function setPurpose($tPurpose)
	{
		$this->iPurpose=trim($tPurpose);
	}
	
	public function getPayAmount()
	{
		return $this->iPayAmount;
	}
	
	public function setPayAmount($tPayAmount)
	{
		$this->iPayAmount=trim($tPayAmount);
	}
	public function getStatus()
	{
		return $this->iStatus;
	}
	public function setStatus($tStatus)
	{
		$this->iStatus=trim($tStatus);
	}
	public function getFailReason()
	{
		return $this->iFailReason;
	}
	public function setFailReason($tFailReason)
	{
		$this->iFailReason=trim($tFailReason);
	}
}
?>