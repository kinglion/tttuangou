<?php 
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class InsureOrderItem
{
	/** 保险名称 */
	private $iName;
	
	/** 保险代码 */
	private $iCode;
	
	/** 险种信息*/
	private $iCategory;
	
	/** 销售方式*/
	private $iMode;
	
	/** 投保金额*/
	private $iAmount;
	
	/** 保险名称长度*/
	const InsureORDER_NAME_LEN = 255;
	/** 保险代码长度*/
	const InsureORDER_CODE_LEN = 255;
	/** 险种信息长度*/
	const InsureORDER_CATEGORY_LEN = 255;
	/** 销售方式长度*/
	const InsureORDER_MODE_LEN = 255;
	
	/**
	 * @return the $iName
	 */
	public function getName() {
		return $this->iName;
	}

	/**
	 * @param field_type $iName
	 */
	public function setName($iName) {
		$this->iName = trim($iName);
	}

	/**
	 * @return the $iCode
	 */
	public function getCode() {
		return $this->iCode;
	}

	/**
	 * @param field_type $iCode
	 */
	public function setCode($iCode) {
		$this->iCode = trim($iCode);
	}

	/**
	 * @return the $iCategory
	 */
	public function getCategory() {
		return $this->iCategory;
	}

	/**
	 * @param field_type $iCategory
	 */
	public function setCategory($iCategory) {
		$this->iCategory = trim($iCategory);
	}

	/**
	 * @return the $iMode
	 */
	public function getMode() {
		return $this->iMode;
	}

	/**
	 * @param field_type $iMode
	 */
	public function setMode($iMode) {
		$this->iMode = trim($iMode);
	}

	/**
	 * @return the $iAmount
	 */
	public function getAmount() {
		return $this->iAmount;
	}

	/**
	 * @param field_type $iAmount
	 */
	public function setAmount($iAmount) {
		$this->iAmount = $iAmount;
	}

	public function __construct()
	{
		
	}
	/**
	 * 创建保险用户信息
	 * @param aName 保险名称
	 * @param aCode 保险代码
	 * @param aCategory 险种信息
	 * @param aMode 销售方式
	 */
	public function constructInsureOrderItemParm($aAmount,$aName,$aCode,$aCategory,$aMode)
	{
		$this->setAmount($aAmount);
		$this->setName($aName);
		$this->setCode($aCode);
		$this->setCategory($aCategory);
		$this->setMode($aMode);
	}
	/**
	 *  使用XML文件初始InsureOrderItem对象的属性。
	 * @param aXMLDocument  初始对象的XML文件。<br/>XML文件范例：<br/>
	 * &lt;InsureOrderItem&gt;<br/>
	 * &lt;Amount&gt;397.45&lt;/Amount&gt;<br/>
	 * &lt;Name&gt;wdy&lt;/Name&gt;<br/>
	 * &lt;Code&gt;I&lt;/Code&gt;<br/>
	 * &lt;Category&gt;110023126354364758&lt;/Category&gt;<br/>
	 * &lt;Mode&gt;622845671873621516&lt;/Mode&gt;<br/>
	 * &lt;/InsureOrderItem&gt;<br/>
	 */
	public function constructInsureOrderItem($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setAmount($xml->getValueNoNull('Amount'));
		$this->setName($xml->getValueNoNull('Name'));
		$this->setCode($xml->getValueNoNull('Code'));
		$this->setCategory($xml->getValueNoNull('Category'));
		$this->setMode($xml->getValueNoNull('Mode'));
	}
	/**
	 * 取得对象的XML文件
	 * @return 购买数量
	 */
	public function getXMLDocument()
	{
		$tXml='<InsureOrderItem>'.
			  '<Amount>'.$this->iAmount.'</Amount>'.
			  '<Name>'.$this->iName.'</Name>'.
			  '<Code>'.$this->iCode.'</Code>'.
			  '<Category>'.$this->iCategory.'</Category>'.
			  '<Mode>'.$this->iMode.'</Mode>'.
			  '</InsureOrderItem>';
		return $tXml;
	}
	/**
	 * 基本数据校验，保单明细信息是否合法
	 * @return 保单明细信息是否合法
	 */
	public function isValid()
	{
		if($this->iAmount<=0) return '投保金额小于等于零';
		if(!$this->iName) return '保险名称为空';
		if(!$this->iCode) return '保险代码为空';
		if (!$this->iCategory) return '险种信息为空';
		if(!$this->iMode) return '销售方式为空';
		
		if(strlen(trim($this->iName))==0) return '保险名称为空';
		//长度 getBytes()
		if(strlen(trim($this->iName))>self::InsureORDER_NAME_LEN) return '保险名称超长';
		if(strlen(trim($this->iCode))==0) return '保险代码为空';
		if(strlen(trim($this->iCode))>self::InsureORDER_CODE_LEN) return '保险代码超长';
		if(strlen(trim($this->iCategory))==0) return '险种信息为空';
		if(strlen(trim($this->iCategory))>self::InsureORDER_CATEGORY_LEN) return '险种信息超长';
		if(strlen(trim($this->iMode))==0) return '销售方式为空';
		if(strlen(trim($this->iMode))>self::InsureORDER_MODE_LEN) return '销售方式超长';
		//isvalidamout函数不能超过k小数点后为00？有问题
		if(!DataVerifier::isValidAmount($this->iAmount, 2)) return '投保金额不合法';
		
		return '';
	}
	
}
/*
$ioi=new InsureOrderItem();
//$ioi->constructInsureOrderItemParm(308.00, 'jw', 'I', '110023126354364758', '622845671873621516');
 $xml='<InsureOrderItem><Amount>308.02</Amount><Name>cxl</Name><Code>nice</Code><Category>wow</Category><Mode>aha</Mode><</InsureOrderItem>';
$ioi->constructInsureOrderItem($xml);
echo $ioi->getXMLDocument()."<br/>";
echo $ioi->isValid();
if(!$ioi->isValid()) echo 'true';
*/
?>