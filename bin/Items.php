<?php 
class Items
{
	/** 第三方账单号 */
	private $iCBPOrderNo = '';
	
	/** 支付状态*/
	private $iStatus= '';
	
	/** 客户所选择银行号*/
	private $iPayBankNo= '';
	
	/**  
	 * [支付状态],[客户所选择银行号
	 * 构造Items对象，并给定对象[第三方账单号]]属性。
	 * @param aCBPOrderNo   第三方账单号
	 */
	public function __construct($aCBPOrderNo)
	{
		$this->setCBPOrderNo($aCBPOrderNo);
	}
	/**
	 * 用XML字符串初始对象的属性。
	 * @param aXMLDocument 初始对象的XML字符串。
	 */
	public function constructItems($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCBPOrderNo($xml->getValueNoNull('CBPOrderNo'));
	}
	
	/**
	 * 取得对象的XML文件
	 * @return XML文件
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