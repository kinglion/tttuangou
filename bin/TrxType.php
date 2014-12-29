<?php

class TrxType
{

	 /**
     * �̻������������� - ֧������
     */
	const TRX_TYPE_PAY_REQ = "PayReq";

	/**
     * �̻������������� - �˵�����
     */
    const TRX_TYPE_KPAYVERIFY_REQ = "KPayVerifyReq";
    /**
     * �̻������������� - ��֤���ط�
     */
    const TRX_TYPE_KPAYRESEND_REQ = "KPayResendReq";
    /**
     * �̻������������� - K��֧��
     */
    const TRX_TYPE_KPAY_REQ = "KPayReq";
	
	/**
	 * �̻������������� - �ֻ�֧������
	 */
	const TRX_TYPE_MOBILEPAY_REQ = "MobilePayReq";
	/**
	 * �̻������������� - �ֻ�֧������
	 */
	const TRX_TYPE_MPAYREG_REQ = "MobilePayReg";
	/**
	 * �̻������������� - ������ѯ����
	 */
	const TRX_TYPE_CRADBALANCE_REQ = "CardBalanceReq";
    /**
     * �̻������������� - ȡ��֧��
     */
    const TRX_TYPE_VOID_PAY = "VoidPay";
	/**
     * �̻������������� - �˻�
     */
    const TRX_TYPE_REFUND = "Refund";
    
    /**
     * �̻������������� - �����˿�
     */
    const TRX_TYPE_OVERDUEREFUND = "OverdueRefund";
    
    /**
     * �̻������������� - ��ѯ�����˿�
     */
    const TRX_TYPE_QUERYOVERDUEREFUND = "QueryOverdueRefund";
    
    /**
     * �̻������������� - ȡ���˻�
     */
    const TRX_TYPE_VOID_REFUND = "VoidRefund";
    
    /**
     * �̻������������� - ����
     */
    const TRX_TYPE_SETTLE = "Settle";
	/**
	* �̻������������� - ������֧����������
	*/
	const TRX_TYPE_CBPSETTLE = "CBPSettle";
    
    /**
     * �̻������������� - ����״̬��ѯ
     */
    const TRX_TYPE_QUERY = "Query";

    /**
     * �̻������������� - ��ѯί�пۿ�ǩԼ��Ϣ
     */
    const TRX_TYPE_QUERYAGENTSIGN = "QueryAgentSign";
    /**
     * �̻������������� - ֧�����֪ͨ
     */
    const TRX_TYPE_PAY_RESULT = "PayResult";
     
    /**
     * ����֧����������
     *
     */
    const TRX_TYPE_FUND_PAY_REQ = "FundPayReq";
	/**
	 * �����֤��������
	 *
	 */
    const TRX_TYPE_CARD_VERIFY_REQ = "CardVerifyReq";
   
    /**
     * �����֤��������
     *
     */
    const TRX_TYPE_IDENTITY_VERIFY_REQ = "IdentityVerifyReq";
  
    /**
     * �˿������ļ�����
     *
     */
    const TRX_TYPE_BATCH_SEND_REQ = "RefundBatchSendReq";
 
    /**
     * ��ѯ����������
     *
     */
    const TRX_TYPE_QUERY_BATCH_REQ = "QueryBatchReq";
    
    /**
     * ί�пۿ�ǩԼ
     */
    const TRX_TYPE_B2C_AgentSignContract_REQ = "AgentSign";
	/**
     * ί�пۿ��Լ
     */
    const TRX_TYPE_B2C_AgentUnsignContract_REQ = "AgentUSign";
  
    /**
     * ί�пۿ�ʿۿ�
     */
    const TRX_TYPE_B2C_AgentPayment_REQ = "AgentPay";
    
    /**
     * ί�пۿ�ǩԼ���
     */
    const TRX_TYPE_B2C_AgentSignContract_RESULT = "AgentSignResult";
    /**
     * ί�пۿ�����
     */
    const TRX_TYPE_B2C_AGENTBATCH_REQ = "AgentBatch";
    /**
     * ί�пۿ����������ѯ
     */
    const TRX_TYPE_B2C_AGENTBATCHQUERY_RESULT = "AgentBatchQuery";
	/**
     * ���ϸ�����Ϣ����
     */
    const TRX_TYPE_B2C_ONLINEREMIT_REQ = "OnlineRemit";
    
    /**
     * ���ϸ��״̬��ѯ
     */
    const TRX_TYPE_B2C_ONLINEREMIT_CARDQUERYREQ = "OnlineRmtCardQuery";
    
    /**
     * �̻������������� - ���ϸ���׽����ѯ
     */
    const TRX_TYPE_ONLINERMTQUERYRESULT = "OnlineRmtQueryResult";

	public function TrxType()
	{

	}

}
?>