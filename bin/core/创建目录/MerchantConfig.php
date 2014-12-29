<?php 
class_exists('TrxException') or require(dirname(__FILE__).'/TrxException.php');

class MerchantConfig
{

	//签名算法
    const SIGNATURE_ALGORITHM = 'SHA1withRSA';

	//证书储存媒体 - 文件形式
    const KEY_STORE_TYPE_FILE = '0';

	//证书储存媒体 - Sign Server签名服务器
    const KEY_STORE_TYPE_SIGN_SERVER = '1';

	//证书储存媒体 - 其他
	const KEY_STORE_TYPE_OTHERS='3';

	//商户端配置文件资源名称
    const RESOURCE_NAME="TrustMerchant";

	//商户数
    private static $iMerchantNum = 1;
  
    //证书储存媒体
    private static $iKeyStoreType = '0';
    
    //初始旗标
    private static $iIsInitialed = FALSE;
    
    //商户配置文件(资源绑定）
    private static $iResourceBundle = null;
    
    //商户号.商户列表
    private static $iMerchantIDs = array();
    //商户列表
    //private static $iMerchantIDList = array();
    
    //商户证书（Base64编码）
    private static $iMerchantCertificates = array();
    
    //商户私钥
    private static $iMerchantKeys = array();

	//网上支付平台通讯方式（HTTP / HTTPS）
    private static $iTrustPayConnectMethod = 'http';
    
    //网上支付平台服务器IP
    private static $iTrustPayServerName = '';
    
    //网上支付平台交易端口
    private static $iTrustPayServerPort = 0;
    
    //网上支付平台交易网址
    private static $iTrustPayTrxURL = '';

	//商户通过浏览器提交网上支付平台交易网址
	private static $iTrustPayIETrxURL='';

	//商户通过浏览器提交网上支付平台交易网址
	private static $iMerchantErrorURL='';
    
    //网上支付平台接口特性
    private static $iNewLine = '1';

	//SSLSocketFactory
	private static $iSSLSocketFactory=null;
    
    //网上支付平台证书
    private static $iTrustpayCertificate = null;

	//商户日志开关
    private static $iIsLog = FALSE;

    //商户日志目录
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
	//日志文件路径和名称
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
                    " - 系统无法写入交易日志至[$tFileName]中!");
            }
       }
        
        return $tLogFile;

    }

	private static function bundle()
    {
        if (!self::$iIsInitialed)
        {
            //1、读取系统配置文件
            $tIniFile = getenv('TrustMerchantIniFile');
            if(!$tIniFile)
            {
            	//配置文件路径
                $tIniFile = substr(dirname(__FILE__), 0,-9).'/TrustMerchant.ini';
            }
            self::$iResourceBundle = parse_ini_file($tIniFile);
            if (empty(self::$iResourceBundle))
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1000, TrxException::TRX_EXC_MSG_1000);
            }

            //2、读取系统配置段
            self::$iTrustPayConnectMethod = self::getParameterByName('TrustPayConnectMethod');
            self::$iTrustPayServerName = self::getParameterByName('TrustPayServerName');
            self::$iTrustPayServerPort = intval(self::getParameterByName('TrustPayServerPort'));
            if (self::$iTrustPayServerPort == 0)
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001.' - 网上支付平台交易端口[TrustPayServerPort]配置错误！');
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
            //证书路径
            $tTrustPayCertFile = self::getParameterByName('TrustPayCertFile');
            $tTrustPayCertFile= substr(dirname(__FILE__), 0,-9).'/'. $tTrustPayCertFile;
  
            //生产环境用方法1读，测试环境用方法2读，
           // 方法1
            self::$iTrustpayCertificate = openssl_x509_read(self::der2pem(file_get_contents($tTrustPayCertFile)));
			//方法2
            //self::$iTrustpayCertificate = openssl_x509_read(file_get_contents($tTrustPayCertFile));
            if (!self::$iTrustpayCertificate)
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1002, TrxException::TRX_EXC_MSG_1002."[$tTrustPayCertFile]！");
            }
            
            self::$iIsLog = (self::getParameterByName('EnableLog', FALSE) == '1');
            //self::$iIsLog=self::getParameterByName('EnableLog');
            
            if(self::$iIsLog)
            {
            	//日志路径
                self::$iLogPath = substr(dirname(__FILE__), 0,-9).'/'.self::getParameterByName('LogPath');
            }

            //3、读取商户号
            self::$iMerchantIDs = array_filter(array_map('trim', explode(',', self::getParameterByName('MerchantID'), 100)));
            self::$iMerchantNum = count(self::$iMerchantIDs);
            
            //4、读取商户证书
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
                throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001.' - 证书储存媒体配置错误！');
            }
            self::$iIsInitialed = TRUE;

        }

    }

	//根据参数名称,获取配置文件参数值
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
            throw new TrxException(TrxException::TRX_EXC_CODE_1001, TrxException::TRX_EXC_MSG_1001." - 未设定[$aParamName]参数值!");
        }
        return $tValue;
    }


	//2进制进行base64加密
	public static function der2pem($der_data)
    {
       $pem = chunk_split(base64_encode($der_data), 64, "\n");
       $pem = "-----BEGIN CERTIFICATE-----\n".$pem."-----END CERTIFICATE-----\n";
       return $pem;
    }
	//获取商户证书和私钥密码
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
            //1、读取证书
            $tCertificate = array();
            if(openssl_pkcs12_read(file_get_contents($tMerchantCertFileArray[$i]), $tCertificate, $tMerchantCertPasswordArray[$i]))
            {
                //2、验证证书是否在有效期内
                $cer = openssl_x509_parse($tCertificate['cert']);
                $t = time();
                if($t < $cer['validFrom_time_t'] || $t > $cer['validTo_time_t'])
                {
                    throw new TrxException(TrxException::TRX_EXC_CODE_1005, TrxException::TRX_EXC_MSG_1005);
                }
                self::$iMerchantCertificates[] = $tCertificate;
                //3、取得密钥
                $pkey = openssl_pkey_get_private($tCertificate['pkey']);
                if($pkey)
                {
                    self::$iMerchantKeys[] = $pkey;
                }
                else
                {
                    throw new TrxException(TrxException::TRX_EXC_CODE_1003, TrxException::TRX_EXC_MSG_1003, '无法生成私钥证书对象！');
                }

            }
            else
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1002, TrxException::TRX_EXC_MSG_1002, '['.$tMerchantCertFileArray[$i]."]！");
            }

        }
    }

	//对报文进行签名
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
	//对报文进行签名
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
        
		//添加了<message>
        return new XMLDocument("<Message>$data</Message><Signature-Algorithm>".self::SIGNATURE_ALGORITHM.
            "</Signature-Algorithm><Signature>$signature</Signature>");
    }

    private static function signServerSignMessage($aMessage)
    {
        throw new Exception('Not implement');
    }
	//验证服务器端响应报文
    public static function verifySign($aMessage)
    {
        self::bundle();
        $tTrxResponse = $aMessage->getValue('Message');
        if($tTrxResponse == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '无[Message]段！');
        }
        $tAlgorithm = $aMessage->getValue('Signature-Algorithm');
        if ($tAlgorithm == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '无[Signature-Algorithm]段！');
        }
        $tSignBase64 = $aMessage->getValue('Signature');
        
        if ($tSignBase64 == null)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1301, TrxException::TRX_EXC_MSG_1301, '无[Signature]段！');
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
//先把der2pem改为public
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
$doc = new XMLDocument('<aa><b>ttt王淼源</b></aa>');
echo MerchantConfig::signMessage(1, $doc);
*/
/*
$f = MerchantConfig::getTrxLogFile();
fwrite($f, 'bbbccc');
fclose($f);
*/
?>