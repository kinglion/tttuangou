<?php 
class Items
{
	/** �������˵��� */
	private $iCBPOrderNo = '';
	
	/** ֧��״̬*/
	private $iStatus= '';
	
	/** �ͻ���ѡ�����к�*/
	private $iPayBankNo= '';
	
	/**  
	 * [֧��״̬],[�ͻ���ѡ�����к�
	 * ����Items���󣬲���������[�������˵���]]���ԡ�
	 * @param aCBPOrderNo   �������˵���
	 */
	public function __construct($aCBPOrderNo)
	{
		$this->setCBPOrderNo($aCBPOrderNo);
	}
	/**
	 * ��XML�ַ�����ʼ��������ԡ�
	 * @param aXMLDocument ��ʼ�����XML�ַ�����
	 */
	public function constructItems($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCBPOrderNo($xml->getValueNoNull('CBPOrderNo'));
	}
	
	/**
	 * ȡ�ö����XML�ļ�
	 * @return XML�ļ�
	 */
	public function getXMLDocument()
	{
		$tXML='<Item>'.
			  '<CBPOrderNo>'.$this->iCBPOrderNo.'</CBPOrderNo>'.
			  '</Item>';
		return $tXML;
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
	 * @return the $iPayBankNo
	 */
	public function getPayBankNo() {
		return $this->iPayBankNo;
	}

	/**
	 * @param string $iPayBankNo
	 */
	public function setPayBankNo($iPayBankNo) {
		$this->iPayBankNo = $iPayBankNo;
	}

}
?>