<?php 
/**
 * �̻��˽ӿ������ʵ���࣬�������ϸ���׽����ѯ��ϸ��
 *
 */
 class QueryResultItem
{
	/**
	 * ������ˮ��
	 */
	private $iSerialNumber = '';
	
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
	 * Ĭ�Ϲ��캯��
	 *
	 */
	public function __construct()
	{
	
	}
	public function _constructQueryResultItem($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iNo=$xml->getValueNoNull('No');
		$this->iPayAccountNo=$xml->getValueNoNull('PayAccount');
		$this->iPayAccountName=$xml->getValueNoNull('PayAccountName');
		$this->iReceiveAccountNo=$xml->getValueNoNull('ReceiveAccount');
		$this->iReceiveAccountName=$xml->getValueNoNull('ReceiveAccountName');
		$this->iPurpose=$xml->getValueNoNull('Purpose');
		$this->iStatus=$xml->getValueNoNull('Status');
		$this->iFailReason=$xml->getValueNoNull('PayAccount');
		$this->iPayAmount=$xml->getValueNoNull('PayAmount')	;
	}
	/**
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = $iSerialNumber;
	}

	/**
	 * @return the $iNo
	 */
	public function getNo() {
		return $this->iNo;
	}

	/**
	 * @param string $iNo
	 */
	public function setNo($iNo) {
		$this->iNo = $iNo;
	}

	/**
	 * @return the $iPayAccountNo
	 */
	public function getPayAccountNo() {
		return $this->iPayAccountNo;
	}

	/**
	 * @param string $iPayAccountNo
	 */
	public function setPayAccountNo($iPayAccountNo) {
		$this->iPayAccountNo = $iPayAccountNo;
	}

	/**
	 * @return the $iPayAccountName
	 */
	public function getPayAccountName() {
		return $this->iPayAccountName;
	}

	/**
	 * @param string $iPayAccountName
	 */
	public function setPayAccountName($iPayAccountName) {
		$this->iPayAccountName = $iPayAccountName;
	}

	/**
	 * @return the $iReceiveAccountNo
	 */
	public function getReceiveAccountNo() {
		return $this->iReceiveAccountNo;
	}

	/**
	 * @param string $iReceiveAccountNo
	 */
	public function setReceiveAccountNo($iReceiveAccountNo) {
		$this->iReceiveAccountNo = $iReceiveAccountNo;
	}

	/**
	 * @return the $iReceiveAccountName
	 */
	public function getReceiveAccountName() {
		return $this->iReceiveAccountName;
	}

	/**
	 * @param string $iReceiveAccountName
	 */
	public function setReceiveAccountName($iReceiveAccountName) {
		$this->iReceiveAccountName = $iReceiveAccountName;
	}

	/**
	 * @return the $iPurpose
	 */
	public function getPurpose() {
		return $this->iPurpose;
	}

	/**
	 * @param string $iPurpose
	 */
	public function setPurpose($iPurpose) {
		$this->iPurpose = $iPurpose;
	}

	/**
	 * @return the $iPayAmount
	 */
	public function getPayAmount() {
		return $this->iPayAmount;
	}

	/**
	 * @param number $iPayAmount
	 */
	public function setPayAmount($iPayAmount) {
		$this->iPayAmount = $iPayAmount;
	}

	/**
	 * @return the $iStatus
	 */
	public function getStatus() {
		return $this->iStatus;
	}

	/**
	 * @param string $iStatus
	 */
	public function setStatus($iStatus) {
		$this->iStatus = $iStatus;
	}

	/**
	 * @return the $iFailReason
	 */
	public function getFailReason() {
		return $this->iFailReason;
	}

	/**
	 * @param string $iFailReason
	 */
	public function setFailReason($iFailReason) {
		$this->iFailReason = $iFailReason;
	}

	
}
?>