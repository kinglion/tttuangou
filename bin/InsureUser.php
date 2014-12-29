<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class InsureUser
{

	/** ���� */
	private $iName;
	/** ֤������ */
	private $iCertificateType;
	/** ֤������ */
	private $iCertificateNo;
	/** ���п��� */
	private $iCardNo;
	/** ��������*/
	const InsureUSER_NAME_LEN = 255;
	/** ֤�����ͳ���*/
	const InsureUSER_CERTIFICATETYPE_LEN = 255;
	/** ֤�����볤��*/
	const InsureUSER_CERTIFICATENO_LEN = 255;
	/** ���п��ų���*/
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
	 * ���������û���Ϣ
	 * @param aName  ����
	 * @param aCertificateType  ֤������
	 * @param aCertificateNo  ֤������
	 * @param aCardNo  ���п���
	 */
	public function constructInsureUserParam($aName,$aCertificateType,$aCertificateNo,$aCardNo)
	{
		$this->setName($aName);
		$this->setCertificateType($aCertificateType);
		$this->setCertificateNo($aCertificateNo);
		$this->setCardNo($aCardNo);
		
	}
	/**
	 * ʹ��XML�ļ���ʼ����InsureUser�����ԡ�
	 * @param aXMLString  ��ʼ�����XML�ļ���<br/>XML�ļ�������<br/>
	 * ��ʼ�����XML�ļ���XML�ļ�������<br/>
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
	 * ȡ�ö����XML�ļ�
	 * @return ��������
	 */
	public function getXMLDocument() {
		$txml='<Name>'.$this->iName.'</Name>'.
			  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			  '<CardNo>'.$this->iCardNo.'</CardNo>';
		return $txml;
	}
	/**
	 * ��������У�飬�����û���Ϣ�Ƿ�Ϸ�
	 * @return �����û���Ϣ�Ƿ�Ϸ�
	 */
	public function isValid()
	{
		if (!$this->iName)return "����Ϊ��";
		if (!$this->iCertificateType )return "֤������Ϊ��";
		if (!$this->iCertificateNo)return "֤������Ϊ��";
		if (!$this->iCardNo)return "���п���Ϊ��";
	
		if (strlen(trim($this->iName)) == 0 )return "����Ϊ��";
		if (strlen(trim($this->iName)) >self::InsureUSER_NAME_LEN)return "��Ʒ��ų���";
		if (strlen(trim($this->iCertificateType)) == 0 )return "֤������Ϊ��";
		if (strlen(trim($this->iCertificateType)) > self::InsureUSER_CERTIFICATETYPE_LEN)return "֤�����ͳ���";
		if (strlen(trim($this->iCertificateNo)) == 0 )return "֤������Ϊ��";
		if (strlen(trim($this->iCertificateNo)) >self:: InsureUSER_CERTIFICATENO_LEN)return "֤�����볬��";
		if (strlen(trim($this->iCardNo)) == 0)return "���п���Ϊ��";
		if (strlen(trim($this->iCardNo)) >self:: InsureUSER_CARDNO_LEN )return "���п��ų���";
	
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