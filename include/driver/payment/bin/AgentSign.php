<?php
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class AgentSign
{	
    /** [订单状态]属性 - 协议请求建立，等待签约。 */
	const SIGN_STATUS_ORIGN='00';

    /** [订单状态]属性 - 签约成功。*/
	const SIGN_STATUS_SUCESS='01';

    /** [订单状态]属性 - 签约失败。*/
	const SIGN_STATUS_FAIL='02';

    /** [订单状态]属性 - 解约成功。*/
	const UNSIGN_STATUS_SUCESS='03';
    
    /** [订单状态]属性 - 签约状态未知。*/
	const SIGN_STATUS_UNKNOWN='99';

    /** 签约协议号 */
	private $iAgentSignNo='';

    /** 商户终端代码 */
	private $iMerchantNo='';

    /** 证件类型 */
	private $iCertificateType='';

    /** 证件号码 */
	private $iCertificateNo='';

    /** 账号后四位 */
	private $iCardNo='';

    /**签约日期*/
	private $SignDate='';

    /** 解约日期 */
	private $UnSignDate='';
       
    /** 协议状态 */
	private $SignStatus='00';
    /** 签约银行卡类型 */
	private $AccountType='';

	/**
     * 设定委托扣款签约协议号
     * @param aAgentSignNo 委托扣款签约协议号
     * @return 对象本身
     */
	public function setAgentSignNo($aAgentSignNo)
	{
		$this->iAgentSignNo=trim($aAgentSignNo);
	}

    /**
     * 委托扣款签约协议号
     * @return 委托扣款签约协议号
     */
	public function getAgentSignNo()
	{
		return $this->iAgentSignNo;
	}
	/**
     * 商户终端代码
     * @param aMerchantNo 商户终端代码
     */
	public function setMerchantNo($aMerchantNo)
	{
		$this->iMerchantNo=trim($aMerchantNo);
	}

    /**
     * 商户终端代码
     * @return 商户终端代码
     */
	public function getMerchantNo()
	{
		return $this->iMerchantNo;
	}
	/**
     * 设定签约证件类型
     * @param aCertificateType 签约证件类型
     */
	public function setCertificateType($aCertificateType)
	{
		$this->iCertificateType=trim($aCertificateType);
	}
    /**
     * 签约证件类型
     * @return 签约证件类型
     */
	public function getCertificateType()
	{
		return $this->iCertificateType;
	}
	/**
     * 设定签约证件号码
     * @param aCertificateNo 签约证件号码
     */
	public function setCertificateNo($aCertificateNo)
	{
		$this->iCertificateNo=trim($aCertificateNo);
	}

    /**
     * 签约证件号码
     * @return 签约证件号码
     */
	public function getCertificateNo()
	{
		return $this->iCertificateNo;
	}
	/**
     * 设定签约银行卡后四位
     * @param aCardNo 签约银行卡后四位
     */
	public function setCardNo($aCardNo)
	{
		$this->iCardNo=trim($aCardNo);
	}

    /**
     * 签约银行卡后四位
     * @return 签约银行卡后四位
     */
	public function getCardNo()
	{
		return $this->iCardNo;
	}
	/**
     * 设定签约日期
     * @param aAgentSignDate 签约日期
     */
	public function setSignDate($aAgentSignDate)
	{
		$this->SignDate=trim($aAgentSignDate);
	}

    /**
     * 签约日期
     * @return 签约日期
     */
	public function getSignDate()
	{
		return $this->SignDate;
	}
    /**
     * 设定解约日期
     * @param aUnsignDate 解约日期
     */
	public function setUnSignDate($aUnsignDate)
	{
		$this->UnSignDate=trim($aUnsignDate);
	}

    /**
     * 解约日期
     * @return 解约日期
     */
	public function getUnSignDate()
	{
		return $this->UnSignDate;
	}
	/**
     * 设定协议状态
     * @param aSignStatus 协议状态
     */
	public function SetSignStatus($aSignStatus)
	{
		$this->SignStatus=trim($aSignStatus);
	}
    /**
     * 协议状态
     * @return 协议状态
     */
	public function getSignStatus()
	{
		return $this->SignStatus;
	}
   /**
     * 设定签约卡类型
     * @param aAccountType 签约卡类型
     */
	public function SetAccountType($aAccountType)
	{
		$this->AccountType=trim($aAccountType);
	}
    /**
     * 签约卡类型
     * @return 签约卡类型
     */
    public function getAccountType()
	{
		return $this->AccountType;
	}
	/**
     * Class AgentSign 构造函数。
     */
	public function __construct()
	{
	}
	 /**
     * 取得对象的XML文件
     * @param aType 是否包含完整对象属性。<br>
     * @return XML文件
     */
	public function constructAgentSign($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setAgentSignNo($xml->getValueNoNull('AgentSignNo'));
		$this->setMerchantNo($xml->getValueNoNull('MerchantNo'));
		$this->setCardNo($xml->getValueNoNull('Last4CardNo'));
		$this->SetAccountType($xml->getValueNoNull('AccountType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->SetSignStatus($xml->getValueNoNull('AgentSignStatus'));
		$this->setSignDate($xml->getValueNoNull('SignDate'));
		$this->setUnSignDate($xml->getValueNoNull('UnSignDate'));

	}

}
/*
$as=new AgentSign();
$xml='<AgentSignNo>1111</AgentSignNo><MerchantNo>2222</MerchantNo><Last4CardNo>3686</Last4CardNo>
	  <AccountType>1</AccountType><CertificateNo>130628198810155026</CertificateNo>
	  <CertificateType>I</CertificateType><AgentSignStatus>00</AgentSignStatus>
	  <SignDate>2013/3/19</SignDate><UnSignDate>2013/3/29</UnSignDate>';
$as->constructAgentSign($xml);
echo $as->getAgentSignNo()."<br>";
echo $as->getCardNo()."<br>";
echo $as->getMerchantNo()."<br>";
echo $as->getAccountType()."<br>";
echo $as->getCertificateNo()."<br>";
echo $as->getCertificateType()."<br>";
echo $as->getSignStatus()."<br>";
echo $as->getSignDate()."<br>";
echo $as->getUnSignDate()."<br>";
*/

?>