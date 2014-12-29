<?php 
/**
 * 商户端接口软件包实体类，代表网上付款交易结果查询结果。
 *
 */
class QueryResult
{
	/**
	 * 查询结果明细。为QueryResultItem对象的数组
	 */
	private $iQueryResultItems = array();
	
	/**
	 * 付款流水号
	 */
	private $iSerialNumber = '';
	
	/**
	 * 交易时间
	 */
	private $iTrnxTime = '';
	
	/**
	 * 付款流水号
	 */
	private $iNo = '';
	
	/**
	 * 付款方账号
	 */
	private $iPayAccountNo = '';
	
	/**
	 * 付款方户名
	 */
	private $iPayAccountName = '';
	
	/**
	 * 收款方账号
	 */
	private $iReceiveAccountNo = '';
	
	/**
	 * 收款方户名
	 */
	private $iReceiveAccountName = '';
	
	/**
	 * 用途
	 */
	private $iPurpose = '';
	
	/**
	 * 付款金额
	 */
	private $iPayAmount = 0;

	/**
	 * 交易状态
	 */
	private $iStatus = '';

	/**
	 * 失败原因
	 */
	private $iFailReason = '';
	/**
	 * 构造QueryResult对象
	 *
	 */
	public function __construct()
	{
	
	}
	/**
	 * 并使用XML文件初始QueryResult对象的属性。
	 * @param $aXMLDocument 初始对象的XML文件。
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
	 * 新增查询结果明细
	 * @param aQueryResultItem 查询结果明细（QueryResultItem）对象
	 * @return 对象本身
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