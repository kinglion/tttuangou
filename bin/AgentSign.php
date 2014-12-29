<?php
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class AgentSign
{	
    /** [����״̬]���� - Э�����������ȴ�ǩԼ�� */
	const SIGN_STATUS_ORIGN='00';

    /** [����״̬]���� - ǩԼ�ɹ���*/
	const SIGN_STATUS_SUCESS='01';

    /** [����״̬]���� - ǩԼʧ�ܡ�*/
	const SIGN_STATUS_FAIL='02';

    /** [����״̬]���� - ��Լ�ɹ���*/
	const UNSIGN_STATUS_SUCESS='03';
    
    /** [����״̬]���� - ǩԼ״̬δ֪��*/
	const SIGN_STATUS_UNKNOWN='99';

    /** ǩԼЭ��� */
	private $iAgentSignNo='';

    /** �̻��ն˴��� */
	private $iMerchantNo='';

    /** ֤������ */
	private $iCertificateType='';

    /** ֤������ */
	private $iCertificateNo='';

    /** �˺ź���λ */
	private $iCardNo='';

    /**ǩԼ����*/
	private $SignDate='';

    /** ��Լ���� */
	private $UnSignDate='';
       
    /** Э��״̬ */
	private $SignStatus='00';
    /** ǩԼ���п����� */
	private $AccountType='';

	/**
     * �趨ί�пۿ�ǩԼЭ���
     * @param aAgentSignNo ί�пۿ�ǩԼЭ���
     * @return ������
     */
	public function setAgentSignNo($aAgentSignNo)
	{
		$this->iAgentSignNo=trim($aAgentSignNo);
	}

    /**
     * ί�пۿ�ǩԼЭ���
     * @return ί�пۿ�ǩԼЭ���
     */
	public function getAgentSignNo()
	{
		return $this->iAgentSignNo;
	}
	/**
     * �̻��ն˴���
     * @param aMerchantNo �̻��ն˴���
     */
	public function setMerchantNo($aMerchantNo)
	{
		$this->iMerchantNo=trim($aMerchantNo);
	}

    /**
     * �̻��ն˴���
     * @return �̻��ն˴���
     */
	public function getMerchantNo()
	{
		return $this->iMerchantNo;
	}
	/**
     * �趨ǩԼ֤������
     * @param aCertificateType ǩԼ֤������
     */
	public function setCertificateType($aCertificateType)
	{
		$this->iCertificateType=trim($aCertificateType);
	}
    /**
     * ǩԼ֤������
     * @return ǩԼ֤������
     */
	public function getCertificateType()
	{
		return $this->iCertificateType;
	}
	/**
     * �趨ǩԼ֤������
     * @param aCertificateNo ǩԼ֤������
     */
	public function setCertificateNo($aCertificateNo)
	{
		$this->iCertificateNo=trim($aCertificateNo);
	}

    /**
     * ǩԼ֤������
     * @return ǩԼ֤������
     */
	public function getCertificateNo()
	{
		return $this->iCertificateNo;
	}
	/**
     * �趨ǩԼ���п�����λ
     * @param aCardNo ǩԼ���п�����λ
     */
	public function setCardNo($aCardNo)
	{
		$this->iCardNo=trim($aCardNo);
	}

    /**
     * ǩԼ���п�����λ
     * @return ǩԼ���п�����λ
     */
	public function getCardNo()
	{
		return $this->iCardNo;
	}
	/**
     * �趨ǩԼ����
     * @param aAgentSignDate ǩԼ����
     */
	public function setSignDate($aAgentSignDate)
	{
		$this->SignDate=trim($aAgentSignDate);
	}

    /**
     * ǩԼ����
     * @return ǩԼ����
     */
	public function getSignDate()
	{
		return $this->SignDate;
	}
    /**
     * �趨��Լ����
     * @param aUnsignDate ��Լ����
     */
	public function setUnSignDate($aUnsignDate)
	{
		$this->UnSignDate=trim($aUnsignDate);
	}

    /**
     * ��Լ����
     * @return ��Լ����
     */
	public function getUnSignDate()
	{
		return $this->UnSignDate;
	}
	/**
     * �趨Э��״̬
     * @param aSignStatus Э��״̬
     */
	public function SetSignStatus($aSignStatus)
	{
		$this->SignStatus=trim($aSignStatus);
	}
    /**
     * Э��״̬
     * @return Э��״̬
     */
	public function getSignStatus()
	{
		return $this->SignStatus;
	}
   /**
     * �趨ǩԼ������
     * @param aAccountType ǩԼ������
     */
	public function SetAccountType($aAccountType)
	{
		$this->AccountType=trim($aAccountType);
	}
    /**
     * ǩԼ������
     * @return ǩԼ������
     */
    public function getAccountType()
	{
		return $this->AccountType;
	}
	/**
     * Class AgentSign ���캯����
     */
	public function __construct()
	{
	}
	 /**
     * ȡ�ö����XML�ļ�
     * @param aType �Ƿ���������������ԡ�<br>
     * @return XML�ļ�
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