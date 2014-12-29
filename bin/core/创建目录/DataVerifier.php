<?php
interface_exists('ILength') or require(dirname(__FILE__).'/ILength.php');
interface_exists('ICertificateType') or require(dirname(__FILE__).'/ICertificateType.php');

class DataVerifier
{
	public function __construct()
	{

	}
	   /**
     * ��鴫��Ľ���Ƿ����Ҫ���С�����ȷ�ȡ�
     * @param aAmount ��
     * @param aExp С�����λ�������С����ʱ�������Դ���Ľ������鲢�ش�false��
     * @return �������true:��ȷ   false:����ȷ��С�����λ������ָ����λ����
     */
	 public static function isValidAmount($aAmount,$aExp)
	{
		 $tResult=false;
		 //����
		if (!strpos($aAmount,'.'))
		{
			$tResult=true;
		}
		else {
			if($aExp>=0)
			{
				//if(strpos($aAmount,'.')>=(strlen((string)$aAmount)-$aExp-1))
				//{
				//	$tResult=true;
				//}һ��
				$realnum=strlen($aAmount)-strpos($aAmount, '.')-1;
				if($realnum<=$aExp)
				{
					$tResult=true;
				}
			}
		} 
		
		 return $tResult;
	}

	/**
     * ��鴫����ַ���ʱ�����YYYY/MM/DD�����ڸ�ʽ��
     * @param aString ��Ҫ�����ַ�����
     * @return �������true:��ȷ   false:����ȷ
     */
	public static function isValidDate($aString)
	{
		$tResult=false;
		//ILength::DATEYYYYMMDD_LEN=8
		if(strlen(trim($aString))!=10) return false;
		if((strpos(trim($aString),'/')!=4)||(strpos(trim($aString),'/',5)!=7)) return false;
		try
		{
			$tYYYY=substr($aString,0,4);
			$tMM=substr($aString,5,2);
			$tDD=substr($aString,8,2);

			if((int)$tYYYY===0) return false;
			if(($tMM<1)||($tMM>12)) return false;
			if(($tDD<1)||($tDD>31)) return false;
			if(($tMM==4||$tMM==6||$tMM==9||$tMM==11)&&$tDD>30) return false;
			if($tMM==2)
			{
				if(($tYYYY%4==0&&$tYYYY%100!=0)||$tYYYY%400==0)
				{
					if($tDD>29) return false;
				}
				else if($tDD>28) return false;
			}
			$tResult=true;
		}
		catch (Exception $e)
		{
			echo $e;
		}
		return $tResult;
	}
	/**
     * ��鴫����ַ���ʱ�����YYYYMMDD�����ڸ�ʽ��
     * @param aString ��Ҫ�����ַ�����
     * @return �������true:��ȷ   false:����ȷ
     */
	public static function isValidDate8($sDate)
	{
		$tResult=false;
		if(!$sDate)return false;
		if(strlen(trim($sDate))!=8) return false;
		try
		{
			//substr() returns the portion of string specified by the start and 'length' parameters
			$tYYYY=substr($sDate,0,4);
			$tMM=substr($sDate,4,2);
			$tDD=substr($sDate,6,2);
			if((int)$tYYYY===0) return false;
			if(((int)$tMM<1)||((int)$tMM>12)) return false;
			if(($tDD<1)||($tDD>31)) return false;
			
			if(($tMM==4||$tMM==6||$tMM==9||$tMM==11)&&$tDD>30) return false;
			if($tMM==2)
			{
				if(($tYYYY%4==0&&$tYYYY%100!=0)||$tYYYY%400==0)
				{
					if($tDD>29) return false;
				}
				else if($tDD>28) return false;
			}
			
			$tResult=true;
		}
		catch(Exception $e)
		{
			return false;
		}
		return $tResult;
	}
	/**
     * ��鴫����ַ���ʱ�����HH:MM:SS��ʱ���ʽ��
     * @param aString ��Ҫ�����ַ�����
     * @return �������true:��ȷ   false:����ȷ
     */
	public static function isValidTime($aString)
	{
		$tResult=true;
		//ILength::TIMEHHMMSS_LEN=6
		if(strlen(trim($aString))!=8) return false;
		if((strpos(trim($aString),':')!=2)||(strpos(trim($aString),':',3)!=5)) return false;
		try
		{
			$tHH=substr($aString,0,2);
			$tMM=substr($aString,3,2);
			$tSS=substr($aString,6,2);
			if(($tHH<0)||($tHH>23)) return false;
			if(($tMM<0)||($tMM>59)) return false;
			if(($tSS<0)||($tSS>59)) return false;
			$tResult = true;
		}
		catch(Exception $e)
		{
		}
		return $tResult;		
	}
	/**
	 * ��鴫����ַ���ʱ�����YYYY-MM-DD HH:MM:SS�����ڸ�ʽ��
	 * @param aString ��Ҫ�����ַ�����2000-02-12 04:04:04
	 * @return �������true:��ȷ   false:����ȷ
	 */
	public static function isValidDateTime($aString)
	{
		$tResult=false;
		$aStr=trim($aString);
		if(strlen($aStr) != 19) return false;
		if(strpos($aStr, '-') != 4 || strpos($aStr, '-',5) != 7 || strpos($aStr, ' ',8) != 10 || strpos($aStr, ':',11) != 13 && strpos($aStr, ':',14) != 16 )
			return false;
		$tYYYY = substr($aStr, 0,4);
		$tMM = substr($aStr, 5,2);
		$tDD = substr($aStr, 8,2);
		$tHH = substr($aStr, 11,2);
		$tII = substr($aStr, 14,2);
		$tSS = substr($aStr, 17,2);
		if((int)$tYYYY===0) return false;
		if(($tMM<1)||($tMM>12)) return false;
		if(($tDD<1)||($tDD>31)) return false;
		if(($tHH<0)||($tHH>23)) return false;
		if(($tII<0)||($tII>59)) return false;
		if(($tSS<0)||($tSS>59)) return false;
		if(($tMM==4||$tMM==6||$tMM==9||$tMM==11)&&$tDD>30) return false;
		if($tMM==2)
		{
			if(($tYYYY%4==0&&$tYYYY%100!=0)||$tYYYY%400==0)
			{
				if($tDD>29) return false;
			}
			else if($tDD>28) return false;
		}
		
		$tResult=true;
		return $tResult;
	}
	 /**
     * ��鴫����ַ���ʱ�����URL�ĸ�ʽ��
     * @param aString ��Ҫ�����ַ�����
     * @return �������true:��ȷ   false:����ȷ
     */
	public static function isValidURL($aString)
	{
		$tResult=true;
		if(strlen(trim($aString))<20) return false;
		if(!(strpos(trim($aString),'http://')==0)&& !(strpos(trim($aString),'https://')==0)) return false;
		return $tResult;	
	}
	/**У���ַ����Ƿ�Ϊ������Ч*/
	public static function isValidString($sValue)
	{
		if(!$sValue) return false;
		if($sValue==='') return false;
		return true;
	}
	/**У���ַ����Ƿ�Ϊ������Ч*/
	public static function isValidStringLen($sValue,$len)
	{
		if(!$sValue) return false;
		if($sValue===''||strlen(trim($sValue))>$len) return false;
		return true;

	}
	/**У��֤��������ȷ��*/
	public static function isValidCertificateNo($sCertificateNo)
	{
		if(!$sCertificateNo) return false;
		$len=strlen(trim($sCertificateNo));
		if($len!=15&&$len!=18) return false;
		return true;

	}
	/**
	 * �������п����Ƿ�Ϸ�
	 * @param iBankCardNo
	 * @return
	 */
	public static function isValidBankCardNo($iBankCardNo)
	{
		if(!DataVerifier::isValidStringLen($iBankCardNo,ILength::CARDNO_LEN)) return false;
		$numeric='1234567890';
		echo strlen($iBankCardNo)."<br/>";
		for($i=0;$i<strlen($iBankCardNo);$i++)
		{
			//Accessing single characters in a string can also be achived using curly braces��
			$character = $iBankCardNo{$i};
			if(strpos($numeric, $character) === false)
				return false;
		}
		return true;
	}
	/**У��֤��������ȷ��*/
	public static function isValidCertificate($sCertificateType,$sCertificateNo)
	{
		if(strpos(ICertificateType::CERTIFICATETYPE, '|'.$sCertificateType.'|' === false)) return false;
		if(!$sCertificateNo) return false;
		$len=strlen(trim($sCertificateNo));
		if(!(ICertificateType::I==$sCertificateType))
			return true;
		if($len != 15 && $len != 18) return  false;
		return true;
	}
	/*���ַ���תΪASCII���ֽ����� Ĭ��java getBytesĬ��gbk*/
	public static function stringToByteArray($str) 
	{ 
		$str = iconv('gbk','gbk',$str);
		preg_match_all('/(.)/s',$str,$bytes);
		$bytes=array_map('ord',$bytes[1]) ;
		return $bytes;
	}
	/*���ַ���תΪASCII���ֽ����� Ĭ��java getBytes����wΪutf8*/
	public static function stringToByteArrayUTF8($str)
	{
		$str=iconv('gbk', 'utf-8', $str);
		preg_match_all('/(.)/s', $str, $bytes);
		$bytes=array_map('ord', $bytes[1]);
		return $bytes;
	}
	public static function stringToByteArrayGB2312($str)
	{
		$str=iconv('utf-8', 'GB2312', $str);
		preg_match_all('/(.)/s', $str, $bytes);
		$bytes=array_map('ord', $bytes[1]);
		return $bytes;
	}
}
/*
if(DataVerifier::isValidAmount(280.01,2))
echo "true";
else
	echo "false";
/*
if(DataVerifier::isValidDateTime('2000-02-12 04:04:04'))
	echo "true";
else
	echo "false";
/*
print_r(DataVerifier::stringToByteArray('��ά')) ;
echo '<br>';
print_r(DataVerifier::stringToByteArrayUTF8('��ά'));
/*???
echo strlen((string)3008.00)."<br>";
if( DataVerifier::isValidAmount(3008.00, 2))
	echo "true";
else
	echo "false";
/*

/*
if( DataVerifier::isValidCertificate('I','130628198810155026'))
	echo "true";
else
	echo "false";
if( DataVerifier::isValidBankCardNo('6210300027923686'))
	echo "true";
else
	echo "false";
/*

/*
if( DataVerifier::isValidCertificateNo('4444111133333456'))
echo "true";
else
echo "false";
/*
if( DataVerifier::isValidStringLen('4444',5))
echo "true";
else
echo "false";
/*
if( DataVerifier::isValidURL('http://www.baidu.com?jw=0'))
echo "true";
else
echo "false";
/*
if( DataVerifier::isValidTime('18:59:98'))
echo "true";
else
echo "false";

if( DataVerifier::isValidDate('9999/10/31'))
echo "true";
else
echo "false";

$d=new DataVerifier();
if($d->isValidAmount(44.444,3))
{
	echo "true";
}
else
{
	echo "false";
}
*/