<?php 
class_exists('TrxException') or require(dirname(__FILE__).'/TrxException.php');

class MerchantConfig
{

	//ǩ���㷨
    const SIGNATURE_ALGORITHM = 'SHA1withRSA';

	//֤�鴢��ý�� - �ļ���ʽ
    const KEY_STORE_TYPE_FILE = '0';

	//֤�鴢��ý�� - Sign Serverǩ��������
    const KEY_STORE_TYPE_SIGN_SERVER = '1';

	//֤�鴢��ý�� - ����
	const KEY_STORE_TYPE_OTHERS='3';

	//�̻��������ļ���Դ����
    const RESOURCE_NAME="TrustMerchant";

	//�̻���
    private static $iMerchantNum = 1;
  
    //֤�鴢��ý��
    private static $iKeyStoreType = '0';
    
    //��ʼ���
    private static $iIsInitialed = FALSE;
    
    //�̻������ļ�(��Դ�󶨣�
    private static $iResourceBundle = null;
    
    //�̻���.�̻��б�
    private static $iMerchantIDs = array();
    //�̻��б�
    //private static $iMerchantIDList = array();
    
    //�̻�֤�飨Base64���룩
    private static $iMerchantCertificates = array();
    
    //�̻�˽Կ
    private static $iMerchantKeys = array();

	//����֧��ƽ̨ͨѶ��ʽ��HTTP / HTTPS��
    private static $iTrustPayConnectMethod = 'http';
    
    //����֧��ƽ̨������IP
    private static $iTrustPayServerName = '';
    
    //����֧��ƽ̨���׶˿�
    private static $iTrustPayServerPort = 0;
    
    //����֧��ƽ̨������ַ
    private static $iTrustPayTrxURL = '';

	//�̻�ͨ��������ύ����֧��ƽ̨������ַ
	private static $iTrustPayIETrxURL='';

	//�̻�ͨ��������ύ����֧��ƽ̨������ַ
	private static $iMerchantErrorURL='';
    
    //����֧��ƽ̨�ӿ�����
    private static $iNewLine = '1';

	//SSLSocketFactory
	private static $iSSLSocketFactory=null;
    
    //����֧��ƽ̨֤��
    private static $iTrustpayCertificate = null;

	//�̻���־����
    private static $iIsLog = FALSE;

    //�̻���־Ŀ¼
    private static $iLogPath = '';

        

    public function __construct()
    {
        self::bundle();
    }



    public static function getTrustPayConnectMethod()
    {
        self::bundle();
        return self::$iTrustPayConnectMethod;
    }
    public static function getKeyStoreType()
    {
        self::bundle();
        return self::$iKeyStoreType;
    }
    public static function getTrustPayServerName()
    {
        self::bundle();
        return self::$iTrustPayServerName;
    }
    public static function getTrustPayServerPort()
    {
        self::bundle();
        return self::$iTrustPayServerPort;
    }
    public static function getTrustPayNewLine()
    {
        self::bundle();
        return self::$iNewLine;
    }
    public static function getTrustPayTrxURL()
    {
        self::bundle();
        return self::$iTrustPayTrxURL;
    }
	public static function getTrustPayIETrxURL()
	{
		self::bundle();
		return self::$iTrustPayIETrxURL;
	}
	public static function getMerchantErrorURL()
	{
		self::bundle();
		return self::$iMerchantErrorURL;
	}
    public static function getTrustpayCertificate()
    {
        self::bundle();
        return self::$iTrustpayCertificate;
    }
    public static function getMerchantNum()
    {
        self::bundle();
        return self::$iMerchantNum;
    }
    public static function getIsLog()
    {
        self::bundle();
        return self::$iIsLog;
    }
	public static function getSSLSocketFactory()
	{
		self::bundle();
		return self::$iSSLSocketFactory;
	}

    public static  function getMerchantID($aMerchantNo)
    {
        self::bundle();
        return self::$iMerchantIDs[$aMerchantNo - 1];
    }
	//��־�ļ�·��������
	public static function getTrxLogFile()
    {
        self::bundle();
        $aFileName='TrxLog';
        $tLogFile = null;
        if(self::$iIsLog)
        {
            $datatime = new DateTime('now', new DateTimeZone('Asia/Shanghai'));
            $tFileName = self::$iLogPath."/$aFileName.".$datatime->format('Ymd').'.log';
            
            $tLogFile = fopen($tFileName, 'a');
            if(!$tLogFile)
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1004, TrxException::TRX_EXC_MSG_1004,
                    " - ϵͳ�޷�д�뽻����־��[$tFileName]��!");
            }
       }
        
        return $tLogFile;

    }

	private static function bundle()
    {
        if (!self::$iIsInitialed)
        {
            //1����ȡϵͳ�����ļ�
            $tIniFile = getenv('TrustMerchantIniFile');
            if(!$tIniFile)
            {
            	//�����ļ�·��
                $tIniFile = substr(dirname(__FILE__), 0,-9).'/TrustMerchant.ini';
            }
            self::$iResourceBundle = parse_ini_file($tIniFile);
            if (empty(self::$iResourceBundle))
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1000, TrxException::TRX_EXC_MSG_1000);
            }

            //2����ȡϵͳ���ö�
            self::$iTrustPayConnectMethod = self::getParameterByName('TrustPayConnectMethod');
            self::$iTrustPayServerName = self::getParameterByName('TrustPayServerName');
            self::$iTrustPayServerPort = intval(self::getParameterByName('TrustPayServerPort'));
            if (self::$iTrustPayServerPort == 0)
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001.' - ����֧��ƽ̨���׶˿�[TrustPayServerPort]���ô���');
            }
            self::$iTrustPayTrxURL = self::getParameterByName('TrustPayTrxURL');
			self::$iTrustPayIETrxURL=self::getParameterByName('TrustPayIETrxURL');
			self::$iMerchantErrorURL=self::getParameterByName('MerchantErrorURL');
            $tNewLine = self::getParameterByName('TrustPayNewLine');
            if ($tNewLine == '1')
            {
                self::$iNewLine = "\n";
            }
            else
            {
                self::$iNewLine = "\r\n";
            }
            //֤��·��
            $tTrustPayCertFile = self::getParameterByName('TrustPayCertFile');
            $tTrustPayCertFile= substr(dirname(__FILE__), 0,-9).'/'. $tTrustPayCertFile;
  
            //���������÷���1�������Ի����÷���2����
           // ����1
            self::$iTrustpayCertificate = openssl_x509_read(self::der2pem(file_get_contents($tTrustPayCertFile)));
			//����2
            //self::$iTrustpayCertificate = openssl_x509_read(file_get_contents($tTrustPayCertFile));
            if (!self::$iTrustpayCertificate)
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1002, TrxException::TRX_EXC_MSG_1002."[$tTrustPayCertFile]��");
            }
            
            self::$iIsLog = (self::getParameterByName('EnableLog', FALSE) == '1');
            //self::$iIsLog=self::getParameterByName('EnableLog');
            
            if(self::$iIsLog)
            {
            	//��־·��
                self::$iLogPath = substr(dirname(__FILE__), 0,-9).'/'.self::getParameterByName('LogPath');
            }

            //3����ȡ�̻���
            self::$iMerchantIDs = array_filter(array_map('trim', explode(',', self::getParameterByName('MerchantID'), 100)));
            self::$iMerchantNum = count(self::$iMerchantIDs);
            
            //4����ȡ�̻�֤��
            self::$iKeyStoreType = self::getParameterByName('MerchantKeyStoreType');
            if (self::$iKeyStoreType == self::KEY_STORE_TYPE_FILE)
            {
                self::bindMerchantCertificateByFile();
            }
            else if (self::$iKeyStoreType == self::KEY_STORE_TYPE_SIGN_SERVER)
            {
            }
            else
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001.' - ֤�鴢��ý�����ô���');
            }
            self::$iIsInitialed = TRUE;

        }

    }

	//���ݲ�������,��ȡ�����ļ�����ֵ
	public static function getParameterByName($aParamName, $aThrowException=TRUE)
    {
        if (self::$iResourceBundle == null)
        {
            self::bundle();
        }
        if(array_key_exists($aParamName, self::$iResourceBundle))
        {
            $tValue = self::$iResourceBundle[$aParamName];
        }
        else
        {
            $tValue = '';
        }
        if ($tValue == '' && $aThrowException)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001." - δ�趨[$aParamName]����ֵ!");
        }
        return $tValue;
    }


	//2���ƽ���base64����
	public static function der2pem($der_data)
    {
       $pem = chunk_split(base64_encode($der_data), 64, "\n");
       $pem = "-----BEGIN CERTIFICATE-----\n".$pem."-----END CERTIFICATE-----\n";
       return $pem;
    }
	//��ȡ�̻�֤���˽Կ����
    private static function bindMerchantCertificateByFile()
    {
        $tMerchantCertFiles = self::getParameterByName('MerchantCertFile');
        $tMerchantCertFiles=substr(dirname(__FILE__), 0,-9).'/'.$tMerchantCertFiles;

        $tMerchantCertPasswords = self::getParameterByName('MerchantCertPassword');

        $tMerchantCertFileArray = array_filter(array_map('trim', explode(',', $tMerchantCertFiles, 100)));
        $tMerchantCertPasswordArray = array_filter(array_map('trim', explode(',', $tMerchantCertPasswords, 100)));

        if(self::$iMerchantNum != count($tMerchantCertFileArray) || self::$iMerchantNum != count($tMerchantCertPasswordArray))
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1007, TrxException::TRX_EXC_MSG_1007);
        }

        self::$iMerchantCertificates = array();
        self::$iMerchantKeys = array();
        for($i = 0; $i < self::$iMerchantNum; $i++)
        {
            //1����ȡ֤��
            $tCertificate = array();
            if(openssl_pkcs12_read(file_get_contents($tMerchantCertFileArray[$i]), $tCertificate, $tMerchantCertPasswordArray[$i]))
            {
                //2����֤֤���Ƿ�����Ч����
                $cer = openssl_x509_parse($tCertificate['cert']);
                $t = time();
                if($t < $cer['validFrom_time_t'] || $t > $cer['validTo_time_t'])
                {
                    throw new TrxException(TrxException::TRX_EXC_CODE_1005, TrxException::TRX_EXC_MSG_1005);
                }
                self::$iMerchantCertificates[] = $tCertificate;
                //3��ȡ����Կ
                $pkey = openssl_pkey_get_private($tCertificate['pkey']);
                if($pkey)
                {
                    self::$iMerchantKeys[] = $pkey;
                }
                else
                {
                    throw new TrxException(TrxException::TRX_EXC_CODE_1003, TrxException::TRX_EXC_MSG_1003, '�޷�����˽Կ֤�����');
                }

            }
            else
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1002, TrxException::TRX_EXC_MSG_1002, '['.$tMerchantCertFileArray[$i]."]��");
            }

        }
    }

	//�Ա��Ľ���ǩ��
	public static function signMessage($aMerchantNo, $aMessage)
    {
        self::bundle();
        $tMessage = null;
        if(self::$iKeyStoreType == self::KEY_STORE_TYPE_FILE)
        {
            $tMessage = self::fileSignMessage($aMerchantNo, $aMessage);
        }
        else if(self::$iKeyStoreType == self::KEY_STORE_TYPE_SIGN_SERVER)
        {
            $tMessage = self::signServerSignMessage($aMessage);
        }

        if(!$tMessage)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1102, TrxException::TRX_EXC_MSG_1102);
        }

        return $tMessage;
    }
	//�Ա��Ľ���ǩ��
    private static function fileSignMessage($aMerchantNo, $aMessage)
    {
    	$key=self::$iMerchantKeys[$aMerchantNo-1];
        $signature = '';
        $data = strval($aMessage);

       if(!openssl_sign(iconv('GB2312','UTF-8', $data), $signature, $key,OPENSSL_ALGO_SHA1 ))
        {
        	return null;
        }
    
        $signature = base64_encode($signature);
        
		//�����<message>
        return new XMLDocument("<Message>$data</Message><Signature-Algorithm>".self::SIGNATURE_ALGORITHM.
            "</Signature-Algorithm><Signature>$signature</Signature>");
    }

    private static function signServerSignMessage($aMessage)
    {
        throw new Exception('Not implement');
    }
	//��֤����������Ӧ����
    public static function verifySign($aMessage)
    {
        self::bundle();
        $tTrxResponse = $aMessage->getValue('Message');
        if($tTrxResponse == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '��[Message]�Σ�');
        }
        $tAlgorithm = $aMessage->getValue('Signature-Algorithm');
        if ($tAlgorithm == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '��[Signature-Algorithm]�Σ�');
        }
        $tSignBase64 = $aMessage->getValue('Signature');
        
        if ($tSignBase64 == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '��[Signature]�Σ�');
        }
		$tSign=base64_decode($tSignBase64);
        $key = openssl_pkey_get_public(self::$iTrustpayCertificate);
        $data = $tTrxResponse;
        if(openssl_verify($data,$tSign, $key, OPENSSL_ALGO_SHA1) == 1)
        {
        	
            return $tTrxResponse;
        }
        else
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1302, TrxException::TRX_EXC_MSG_1302);
        }

    }  
}

/*
//�Ȱ�der2pem��Ϊpublic
$config=new MerchantConfig();

$cert = $config->der2pem(file_get_contents('Certificate\\TrustPay.cer'));
var_dump(openssl_x509_parse($cert));
*/
/*
$cert1 = array();
var_dump(openssl_pkcs12_read(file_get_contents('Certificate\\211000004633A01.pfx'), $cert1, '111111'));
var_dump($cert1);
var_dump(openssl_pkey_get_details(openssl_pkey_get_private($cert1['pkey'])));
*/
/*
class_exists('XMLDocument') or require('XMLDocument.php');
$doc = new XMLDocument('<aa><b>ttt���Դ</b></aa>');
echo MerchantConfig::signMessage(1, $doc);
*/
/*
$f = MerchantConfig::getTrxLogFile();
fwrite($f, 'bbbccc');
fclose($f);
*/
?>