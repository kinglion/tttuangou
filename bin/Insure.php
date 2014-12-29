<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('InsureOrder') or require(dirname(__FILE__).'/InsureOrder.php');
class_exists('InsureUser') or require(dirname(__FILE__).'/InsureUser.php');
class Insure 
{
	/** һ�㱣��֧��*/
	const INSURE_TYPE_COMMON = '1';
	/** �������֧��*/
	const INSURE_TYPE_FINANCING = '2';
	/** ָ��֧��*/
	const INSURE_TYPE_APPOINTED ='3';
	
	/** ����֧������:1һ��֧��,2���֧��,3ָ��֧�� */
	private $iType;
	
	/** ��֤ʧ����Ϣ���̻�url */
	private $iFurl;
	
	/** ������Ϣ  */
	private $insureOrder;
	
	/** �û���Ϣ */
	private $insureUser;
	
	
	/**
	 * @return the $iType
	 */
	public function getType() {
		return $this->iType;
	}

	/**
	 * @return the $iFurl
	 */
	public function getFurl() {
		return $this->iFurl;
	}

	/**
	 * @return the $insureOrder
	 */
	public function getInsureOrder() {
		return $this->insureOrder;
	}

	/**
	 * @return the $insureUser
	 */
	public function getInsureUser() {
		return $this->insureUser;
	}

	/**
	 * @param field_type $iType
	 */
	public function setType($iType) {
		$this->iType = trim($iType);
	}

	/**
	 * @param field_type $iFurl
	 */
	public function setFurl($iFurl) {
		$this->iFurl = trim($iFurl);
	}

	/**
	 * @param field_type $insureOrder
	 */
	public function setInsureOrder($insureOrder) {
		$this->insureOrder = $insureOrder;
	}

	/**
	 * @param field_type $insureUser
	 */
	public function setInsureUser($insureUser) {
		$this->insureUser = trim($insureUser);
	}

	public function __construct()
	{
		
	}
	/**
	 * ʹ��XML�ļ���ʼInsure��������ԡ�
	 * @param aXMLDocument
	 */
	public function constructInsure($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setType($xml->getValueNoNull('Type'));
		$this->setFurl($xml->getValueNoNull('Furl'));
		$this->setInsureOrder($xml->getValueNoNull('Orders'));
		$this->setInsureUser($xml->getValueNoNull('User'));
	}
	/**
	 * ʹ��XML�ļ���ʼInsure��������ԡ�
	 * @param aXMLDocument
	 */
	public function initByString($aInsureString)
	{
		$this->constructInsure($aInsureString);
	}
	/**
	 * ȡ�ö����XML�ļ�
	 * @return ��������
	 */
	public function getXMLDocument()
	{
		$str1='<Insure>'.
			 '<Type>'.$this->iType.'</Type>'.
			 '<Order>'.$this->insureOrder.'</Order>';
		$str2='<Furl>'.$this->iFurl.'</Furl>';
		$str3='<User>'.$this->insureUser.'</User>';
		$str4='</Insure>';
		if($this->iType==self::INSURE_TYPE_COMMON)
			return $str1.$str4;
	   else	if($this->iType==self::INSURE_TYPE_APPOINTED)
			return $str1.$str3.$str4;
	   else if($this->iType==self::INSURE_TYPE_FINANCING)
	   		return $str1.$str2.$str3.$str4;
				
	}
	/**
	 * ��������У�飬������ϸ��Ϣ�Ƿ�Ϸ�
	 * @return ������ϸ��Ϣ�Ƿ�Ϸ�
	 */
	public function isValid()
	{
		if(!$this->iType) return '����֧������Ϊ��';
		if($this->iType!=self::INSURE_TYPE_COMMON && $this->iType !=self::INSURE_TYPE_APPOINTED && $this->iType != self::INSURE_TYPE_FINANCING) return '����֧������Ϊ���Ϸ�';
		if($this->iType==self::INSURE_TYPE_FINANCING && (!$this->iFurl||strlen(trim($this->iFurl))==0)) return '��֤������Ϣ��ʾ��ַΪ��';
		$io=new InsureOrder();
		$io->constructInsureOrder($this->insureOrder);
		$tError=$io->isValid();
		if(strlen($tError)>0) return $tError;
		if($this->iType==self::INSURE_TYPE_FINANCING||$this->iType==self::INSURE_TYPE_APPOINTED)
		{
			$iu=new InsureUser();
			$iu->constructInsureUser($this->insureUser);
			$tError=$iu->isValid();
			if(strlen($tError)>0) return $tError;			
		}
		return '';
		
	}

}
/*
$insure=new Insure();
$xml='<Insure><Type>2</Type><Furl>www</Furl><Orders><InsureOrderItem>
	 <Amount>308.02</Amount><Name>cxl</Name><Code>nice</Code><Category>wow</Category><Mode>aha</Mode>
	 </InsureOrderItem>
	 <InsureOrderItem>
	 <Amount>333.02</Amount><Name>jw</Name><Code>great</Code><Category>mom</Category><Mode>xixi</Mode>
	 </InsureOrderItem></Orders><User><Name>jw</Name><CertificateType>I</CertificateType>
<CertificateNo>130628198810155026</CertificateNo><CardNo>622845671873621516</CardNo></User></Insure>';
$insure->constructInsure($xml);
echo $insure->getXMLDocument();
if(!$insure->isValid()) echo 'true';
*/
?>