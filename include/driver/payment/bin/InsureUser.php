<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class InsureUser
{

	/** 姓名 */
	private $iName;
	/** 证件类型 */
	private $iCertificateType;
	/** 证件号码 */
	private $iCertificateNo;
	/** 银行卡号 */
	private $iCardNo;
	/** 姓名长度*/
	const InsureUSER_NAME_LEN = 255;
	/** 证件类型长度*/
	const InsureUSER_CERTIFICATETYPE_LEN = 255;
	/** 证件号码长度*/
	const InsureUSER_CERTIFICATENO_LEN = 255;
	/** 银行卡号长度*/
	const InsureUSER_CARDNO_LEN = 255;
	
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
		$this->iName = $iName;
	}

	/**
	 * @return the $iCertificateType
	 */
	public function getCertificateType() {
		return $this->iCertificateType;
	}

	/**
	 * @param field_type $iCertificateType
	 */
	public function setCertificateType($iCertificateType) {
		$this->iCertificateType = $iCertificateType;
	}

	/**
	 * @return the $iCertificateNo
	 */
	public function getCertificateNo() {
		return $this->iCertificateNo;
	}

	/**
	 * @param field_type $iCertificateNo
	 */
	public function setCertificateNo($iCertificateNo) {
		$this->iCertificateNo = $iCertificateNo;
	}

	/**
	 * @return the $iCardNo
	 */
	public function getCardNo() {
		return $this->iCardNo;
	}

	/**
	 * @param field_type $iCardNo
	 */
	public function setCardNo($iCardNo) {
		$this->iCardNo = $iCardNo;
	}

	public function __construct()
	{
		
	}
	/**
	 * 创建保险用户信息
	 * @param aName  姓名
	 * @param aCertificateType  证件类型
	 * @param aCertificateNo  证件号码
	 * @param aCardNo  银行卡号
	 */
	public function constructInsureUserParam($aName,$aCertificateType,$aCertificateNo,$aCardNo)
	{
		$this->setName($aName);
		$this->setCertificateType($aCertificateType);
		$this->setCertificateNo($aCertificateNo);
		$this->setCardNo($aCardNo);
		
	}
	/**
	 * 使用XML文件初始对象InsureUser的属性。
	 * @param aXMLString  初始对象的XML文件。<br/>XML文件范例：<br/>
	 * 初始对象的XML文件。XML文件范例：<br/>
	 *  &lt;User&gt;<br/>
	 *  &lt;Name&gt;wdy&lt;/Name&gt;<br/>
	 *  &lt;CertificateType&gt;I&lt;/CertificateType&gt;<br/>
	 *  &lt;CertificateNo&gt;110023126354364758&lt;/CertificateNo&gt;<br/>
	 *  &lt;CardNo&gt;622845671873621516&lt;/CardNo&gt;<br/>
	 *  &lt;/User&gt;<br/>
	 */
	public function constructInsureUser($aXMLString)
	{
		$xml=new XMLDocument($aXMLString);
		$this->setName($xml->getValueNoNull('Name'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCardNo($xml->getValueNoNull('CardNo'));
	}
	/**
	 * 取得对象的XML文件
	 * @return 购买数量
	 */
	public function getXMLDocument() {
		$txml='<Name>'.$this->iName.'</Name>'.
			  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			  '<CardNo>'.$this->iCardNo.'</CardNo>';
		return $txml;
	}
	/**
	 * 基本数据校验，保单用户信息是否合法
	 * @return 保单用户信息是否合法
	 */
	public function isValid()
	{
		if (!$this->iName)return "姓名为空";
		if (!$this->iCertificateType )return "证件类型为空";
		if (!$this->iCertificateNo)return "证件号码为空";
		if (!$this->iCardNo)return "银行卡号为空";
	
		if (strlen(trim($this->iName)) == 0 )return "姓名为空";
		if (strlen(trim($this->iName)) >self::InsureUSER_NAME_LEN)return "产品编号超长";
		if (strlen(trim($this->iCertificateType)) == 0 )return "证件类型为空";
		if (strlen(trim($this->iCertificateType)) > self::InsureUSER_CERTIFICATETYPE_LEN)return "证件类型超长";
		if (strlen(trim($this->iCertificateNo)) == 0 )return "证件号码为空";
		if (strlen(trim($this->iCertificateNo)) >self:: InsureUSER_CERTIFICATENO_LEN)return "证件号码超长";
		if (strlen(trim($this->iCardNo)) == 0)return "银行卡号为空";
		if (strlen(trim($this->iCardNo)) >self:: InsureUSER_CARDNO_LEN )return "银行卡号超长";
	
		return '';
	}

}
/*
$iu=new InsureUser();
//$iu->constructInsureUserParam('jw', 'I', '130628198810155026', '6210300027923686');
$xml='<User><Name>jw</Name><CertificateType>I</CertificateType>
<CertificateNo>130628198810155026</CertificateNo><CardNo>622845671873621516</CardNo></User>';
$iu->constructInsureUser($xml);
echo $iu->getCardNo()."<br/>";
echo $iu->getName()."<br/>";
echo $iu->getCertificateNo()."<br/>";
echo $iu->getCertificateType()."<br/>";

if(!$iu->isValid()) echo 'true';
echo $iu->getXMLDocument();
*/
?>