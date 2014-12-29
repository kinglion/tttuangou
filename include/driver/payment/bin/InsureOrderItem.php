<?php 
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class InsureOrderItem
{
	/** �������� */
	private $iName;
	
	/** ���մ��� */
	private $iCode;
	
	/** ������Ϣ*/
	private $iCategory;
	
	/** ���۷�ʽ*/
	private $iMode;
	
	/** Ͷ�����*/
	private $iAmount;
	
	/** �������Ƴ���*/
	const InsureORDER_NAME_LEN = 255;
	/** ���մ��볤��*/
	const InsureORDER_CODE_LEN = 255;
	/** ������Ϣ����*/
	const InsureORDER_CATEGORY_LEN = 255;
	/** ���۷�ʽ����*/
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
	 * ���������û���Ϣ
	 * @param aName ��������
	 * @param aCode ���մ���
	 * @param aCategory ������Ϣ
	 * @param aMode ���۷�ʽ
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
	 *  ʹ��XML�ļ���ʼInsureOrderItem��������ԡ�
	 * @param aXMLDocument  ��ʼ�����XML�ļ���<br/>XML�ļ�������<br/>
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
	 * ȡ�ö����XML�ļ�
	 * @return ��������
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
	 * ��������У�飬������ϸ��Ϣ�Ƿ�Ϸ�
	 * @return ������ϸ��Ϣ�Ƿ�Ϸ�
	 */
	public function isValid()
	{
		if($this->iAmount<=0) return 'Ͷ�����С�ڵ�����';
		if(!$this->iName) return '��������Ϊ��';
		if(!$this->iCode) return '���մ���Ϊ��';
		if (!$this->iCategory) return '������ϢΪ��';
		if(!$this->iMode) return '���۷�ʽΪ��';
		
		if(strlen(trim($this->iName))==0) return '��������Ϊ��';
		//���� getBytes()
		if(strlen(trim($this->iName))>self::InsureORDER_NAME_LEN) return '�������Ƴ���';
		if(strlen(trim($this->iCode))==0) return '���մ���Ϊ��';
		if(strlen(trim($this->iCode))>self::InsureORDER_CODE_LEN) return '���մ��볬��';
		if(strlen(trim($this->iCategory))==0) return '������ϢΪ��';
		if(strlen(trim($this->iCategory))>self::InsureORDER_CATEGORY_LEN) return '������Ϣ����';
		if(strlen(trim($this->iMode))==0) return '���۷�ʽΪ��';
		if(strlen(trim($this->iMode))>self::InsureORDER_MODE_LEN) return '���۷�ʽ����';
		//isvalidamout�������ܳ���kС�����Ϊ00��������
		if(!DataVerifier::isValidAmount($this->iAmount, 2)) return 'Ͷ�����Ϸ�';
		
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