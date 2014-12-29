<?php

class TrxType
{

	 /**
     * 商户交易请求类型 - 支付请求
     */
	const TRX_TYPE_PAY_REQ = "PayReq";

	/**
     * 商户交易请求类型 - 账单发送
     */
    const TRX_TYPE_KPAYVERIFY_REQ = "KPayVerifyReq";
    /**
     * 商户交易请求类型 - 验证码重发
     */
    const TRX_TYPE_KPAYRESEND_REQ = "KPayResendReq";
    /**
     * 商户交易请求类型 - K码支付
     */
    const TRX_TYPE_KPAY_REQ = "KPayReq";
	
	/**
	 * 商户交易请求类型 - 手机支付请求
	 */
	const TRX_TYPE_MOBILEPAY_REQ = "MobilePayReq";
	/**
	 * 商户交易请求类型 - 手机支付请求
	 */
	const TRX_TYPE_MPAYREG_REQ = "MobilePayReg";
	/**
	 * 商户交易请求类型 - 卡余额查询请求
	 */
	const TRX_TYPE_CRADBALANCE_REQ = "CardBalanceReq";
    /**
     * 商户交易请求类型 - 取消支付
     */
    const TRX_TYPE_VOID_PAY = "VoidPay";
	/**
     * 商户交易请求类型 - 退货
     */
    const TRX_TYPE_REFUND = "Refund";
    
    /**
     * 商户交易请求类型 - 超期退款
     */
    const TRX_TYPE_OVERDUEREFUND = "OverdueRefund";
    
    /**
     * 商户交易请求类型 - 查询超期退款
     */
    const TRX_TYPE_QUERYOVERDUEREFUND = "QueryOverdueRefund";
    
    /**
     * 商户交易请求类型 - 取消退货
     */
    const TRX_TYPE_VOID_REFUND = "VoidRefund";
    
    /**
     * 商户交易请求类型 - 对账
     */
    const TRX_TYPE_SETTLE = "Settle";
	/**
	* 商户交易请求类型 - 第三方支付机构对账
	*/
	const TRX_TYPE_CBPSETTLE = "CBPSettle";
    
    /**
     * 商户交易请求类型 - 订单状态查询
     */
    const TRX_TYPE_QUERY = "Query";

    /**
     * 商户交易请求类型 - 查询委托扣款签约信息
     */
    const TRX_TYPE_QUERYAGENTSIGN = "QueryAgentSign";
    /**
     * 商户交易请求类型 - 支付结果通知
     */
    const TRX_TYPE_PAY_RESULT = "PayResult";
     
    /**
     * 基金支付交易请求
     *
     */
    const TRX_TYPE_FUND_PAY_REQ = "FundPayReq";
	/**
	 * 身份验证交易请求
	 *
	 */
    const TRX_TYPE_CARD_VERIFY_REQ = "CardVerifyReq";
   
    /**
     * 身份验证交易请求
     *
     */
    const TRX_TYPE_IDENTITY_VERIFY_REQ = "IdentityVerifyReq";
  
    /**
     * 退款批量文件发送
     *
     */
    const TRX_TYPE_BATCH_SEND_REQ = "RefundBatchSendReq";
 
    /**
     * 查询批量处理结果
     *
     */
    const TRX_TYPE_QUERY_BATCH_REQ = "QueryBatchReq";
    
    /**
     * 委托扣款签约
     */
    const TRX_TYPE_B2C_AgentSignContract_REQ = "AgentSign";
	/**
     * 委托扣款解约
     */
    const TRX_TYPE_B2C_AgentUnsignContract_REQ = "AgentUSign";
  
    /**
     * 委托扣款单笔扣款
     */
    const TRX_TYPE_B2C_AgentPayment_REQ = "AgentPay";
    
    /**
     * 委托扣款签约结果
     */
    const TRX_TYPE_B2C_AgentSignContract_RESULT = "AgentSignResult";
    /**
     * 委托扣款批量
     */
    const TRX_TYPE_B2C_AGENTBATCH_REQ = "AgentBatch";
    /**
     * 委托扣款批量结果查询
     */
    const TRX_TYPE_B2C_AGENTBATCHQUERY_RESULT = "AgentBatchQuery";
	/**
     * 网上付款信息发送
     */
    const TRX_TYPE_B2C_ONLINEREMIT_REQ = "OnlineRemit";
    
    /**
     * 网上付款卡状态查询
     */
    const TRX_TYPE_B2C_ONLINEREMIT_CARDQUERYREQ = "OnlineRmtCardQuery";
    
    /**
     * 商户交易请求类型 - 网上付款交易结果查询
     */
    const TRX_TYPE_ONLINERMTQUERYRESULT = "OnlineRmtQueryResult";

	public function TrxType()
	{

	}

}
?>