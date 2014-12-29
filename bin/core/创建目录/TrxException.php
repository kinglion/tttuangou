<?php
class TrxException extends Exception
{
    const TRX_EXC_CODE_1000 = '1000';
    const TRX_EXC_CODE_1001 = '1001';
    const TRX_EXC_CODE_1002 = '1002';
    const TRX_EXC_CODE_1003 = '1003';
    const TRX_EXC_CODE_1004 = '1004';
    const TRX_EXC_CODE_1005 = '1005';
    const TRX_EXC_CODE_1006 = '1006';
    const TRX_EXC_CODE_1007 = '1007';
    const TRX_EXC_CODE_1008 = '1008';
    const TRX_EXC_CODE_1100 = '1100';
    const TRX_EXC_CODE_1101 = '1101';
    const TRX_EXC_CODE_1102 = '1102';
    const TRX_EXC_CODE_1103 = '1103';
    const TRX_EXC_CODE_1104 = '1104';
    const TRX_EXC_CODE_1201 = '1201';
    const TRX_EXC_CODE_1202 = '1202';
    const TRX_EXC_CODE_1203 = '1203';
    const TRX_EXC_CODE_1204 = '1204';
    const TRX_EXC_CODE_1205 = '1205';
    const TRX_EXC_CODE_1206 = '1206';
    const TRX_EXC_CODE_1301 = '1301';
    const TRX_EXC_CODE_1302 = '1302';
    const TRX_EXC_CODE_1303 = '1303';
    const TRX_EXC_CODE_1304 = '1304';
    const TRX_EXC_CODE_1999 = '1999';
    
    const TRX_EXC_MSG_1000 = '�޷���ȡ�̻��������ļ�';
    const TRX_EXC_MSG_1001 = '�̻��������ļ��в������ô���';
    const TRX_EXC_MSG_1002 = '�޷���ȡ֤���ĵ�';
    const TRX_EXC_MSG_1003 = '�޷���ȡ�̻�˽Կ';
    const TRX_EXC_MSG_1004 = '�޷�д�뽻����־�ĵ�';
    const TRX_EXC_MSG_1005 = '֤�����';
    const TRX_EXC_MSG_1006 = '֤���ʽ����';
    const TRX_EXC_MSG_1007 = '�����ļ���MerchantID��MerchantCertFile��MerchantCertPassword���Ը�����һ��';
    const TRX_EXC_MSG_1008 = 'ָ�����̻����ñ�Ų��Ϸ�';
    const TRX_EXC_MSG_1100 = '�̻��ύ�Ľ������ϲ�����';
    const TRX_EXC_MSG_1101 = '�̻��ύ�Ľ������ϲ��Ϸ�';
    const TRX_EXC_MSG_1102 = 'ǩ�����ױ���ʱ��������';
    const TRX_EXC_MSG_1103 = '�޷�����ǩ��������';
    const TRX_EXC_MSG_1104 = 'ǩ������������ǩ������';
    const TRX_EXC_MSG_1201 = '�޷���������֧��ƽ̨';
    const TRX_EXC_MSG_1202 = '�ύ����ʱ�����������';
    const TRX_EXC_MSG_1203 = '�޷����յ�����֧��ƽ̨����Ӧ';
    const TRX_EXC_MSG_1204 = '��������֧��ƽ̨��Ӧ����ʱ�����������';
    const TRX_EXC_MSG_1205 = '�޷���ʶ����֧��ƽ̨����Ӧ����';
    const TRX_EXC_MSG_1206 = '����֧��ƽ̨������ʱֹͣ';
    const TRX_EXC_MSG_1301 = '����֧��ƽ̨����Ӧ���Ĳ�����';
    const TRX_EXC_MSG_1302 = '����֧��ƽ̨����Ӧ����ǩ����֤ʧ��';
    const TRX_EXC_MSG_1303 = '�޷���ʶ����֧��ƽ̨�Ľ��׽��';
    const TRX_EXC_MSG_1304 = '��ѹ�����׼�¼ʱ��������';
    const TRX_EXC_MSG_1999 = 'ϵͳ�����޷�Ԥ�ڵĴ���';


    protected $code = '';

    protected $iDetailMessage = '';

    public function __construct($aCode, $aMessage, $aDetailMessage='')
    {
        parent::__construct($aMessage);
        $this->code = trim($aCode);
        $this->iDetailMessage = trim($aDetailMessage);
    }

    public function getDetailMessage()
    {
        return $this->iDetailMessage;
    }

}
/*
$e = new TrxException('code', 'msg', 'dmsg');
echo $e->getMessage();
*/
?>