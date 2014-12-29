<?php  $config["isearcher"] = array (
  'idx' => 
  array (
    'admin' => 
    array (
      'product_list' => 'product_name,seller_name,city_name',
      'order_list' => 'product_name,order_id,user_name',
      'coupon_list' => 'product_name,order_id,user_name,coupon_no',
      'delivery_list' => 'product_name,order_id,user_name',
      'recharge_card_list' => 'recharge_card_number',
      'recharge_order_list' => 'recharge_order_id,recharge_user_name',
      'cash_order_list' => 'cash_order_id,cash_user_name',
      'fund_order_list' => 'fund_order_id,fund_user_name,fund_seller_name',
    ),
  ),
  'frc' => 
  array (
    'admin' => 
    array (
      'order_list' => 'order_status,order_process',
      'coupon_list' => 'coupon_status',
      'recharge_card_list' => 'recharge_card_usetime',
      'product_list' => 'product_status,product_dsp_area',
      'recharge_order_list' => 'recharge_order_status',
      'cash_order_list' => 'cash_order_status',
      'fund_order_list' => 'fund_order_status',
    ),
  ),
  'tvs' => 
  array (
    'admin' => 
    array (
      'order_list' => 'order_main',
      'recharge_order_list' => 'recharge_order_main',
      'cash_order_list' => 'cash_order_main',
      'fund_order_list' => 'fund_order_main',
    ),
  ),
  'map' => 
  array (
    'product_name' => 
    array (
      'name' => '产品名称',
      'table' => 'product',
      'src' => 'flag',
      'key' => 'pid',
      'idx' => 'id',
    ),
    'seller_name' => 
    array (
      'name' => '商家名称',
      'table' => 'seller',
      'src' => 'sellername',
      'key' => 'sid',
      'idx' => 'id',
    ),
    'city_name' => 
    array (
      'name' => '城市名称',
      'table' => 'city',
      'src' => 'cityname',
      'key' => 'cid',
      'idx' => 'cityid',
    ),
    'order_id' => 
    array (
      'name' => '订单编号',
      'table' => 'order',
      'src' => 'orderid',
      'key' => 'oid',
      'idx' => 'orderid',
    ),
    'user_name' => 
    array (
      'name' => '用户名',
      'table' => 'members',
      'src' => 'username',
      'key' => 'uid',
      'idx' => 'uid',
    ),
    'coupon_no' => 
    array (
      'name' => '团购券号码',
      'table' => 'ticket',
      'src' => 'number',
      'key' => 'coid',
      'idx' => 'ticketid',
    ),
    'recharge_card_number' => 
    array (
      'name' => '充值卡号码',
      'table' => 'recharge_card',
      'src' => 'number',
      'key' => 'rcid',
      'idx' => 'id',
    ),
    'recharge_order_id' => 
    array (
      'name' => '订单编号',
      'table' => 'recharge_order',
      'src' => 'orderid',
      'key' => 'orderid',
      'idx' => 'orderid',
    ),
    'recharge_user_name' => 
    array (
      'name' => '用户名',
      'table' => 'members',
      'src' => 'username',
      'key' => 'userid',
      'idx' => 'uid',
    ),
    'cash_order_id' => 
    array (
      'name' => '提现记录流水号',
      'table' => 'cash_order',
      'src' => 'orderid',
      'key' => 'orderid',
      'idx' => 'orderid',
    ),
    'cash_user_name' => 
    array (
      'name' => '用户名',
      'table' => 'members',
      'src' => 'username',
      'key' => 'userid',
      'idx' => 'uid',
    ),
    'fund_order_id' => 
    array (
      'name' => '结算记录流水号',
      'table' => 'fund_order',
      'src' => 'orderid',
      'key' => 'orderid',
      'idx' => 'orderid',
    ),
    'fund_user_name' => 
    array (
      'name' => '用户名',
      'table' => 'members',
      'src' => 'username',
      'key' => 'userid',
      'idx' => 'uid',
    ),
    'fund_seller_name' => 
    array (
      'name' => '商家名称',
      'table' => 'seller',
      'src' => 'sellername',
      'key' => 'sellerid',
      'idx' => 'id',
    ),
  ),
  'filter' => 
  array (
    'order_status' => 
    array (
      'name' => '订单状态',
      'key' => 'ordsta',
      'list' => 
      array (
        1 => '订单正常',
        0 => '已经取消',
        3 => '订单失败',
        2 => '已经过期',
        4 => '已经返款',
      ),
    ),
    'order_process' => 
    array (
      'name' => '处理进程',
      'key' => 'ordproc',
      'list' => 
      array (
        '__CREATE__' => '创建订单',
        '__PAY_YET__' => '已经付款',
        'WAIT_BUYER_PAY' => '等待付款',
        'WAIT_SELLER_SEND_GOODS' => '等待发货',
        'WAIT_BUYER_CONFIRM_GOODS' => '等待收货',
        'TRADE_FINISHED' => '交易完成',
      ),
    ),
    'coupon_status' => 
    array (
      'name' => '团购券状态',
      'key' => 'coupsta',
      'list' => 
      array (
        0 => '还未使用',
        1 => '已经使用',
        2 => '已经过期',
        3 => '号码无效',
      ),
    ),
    'recharge_card_usetime' => 
    array (
      'name' => '使用状态',
      'key' => 'used',
      'list' => 
      array (
        0 => '还未使用',
        1 => '已经使用',
      ),
    ),
    'product_status' => 
    array (
      'name' => '产品状态',
      'key' => 'prosta',
      'list' => 
      array (
        2 => '进行中，已成团',
        1 => '进行中，未成团',
        3 => '已结束，团购成功',
        0 => '已结束，团购失败',
        4 => '已结束，已经返款',
      ),
    ),
    'product_dsp_area' => 
    array (
      'name' => '显示区域',
      'key' => 'prodsp',
      'list' => 
      array (
        2 => '全部城市显示',
        1 => '限定城市显示',
        0 => '不在前台显示',
      ),
    ),
    'recharge_order_status' => 
    array (
      'name' => '支付状态',
      'key' => 'paystatus',
      'list' => 
      array (
        0 => '还未支付',
        1 => '已经支付',
      ),
    ),
    'cash_order_status' => 
    array (
      'name' => '提现状态',
      'key' => 'paystatus',
      'list' => 
      array (
        'no' => '等待处理',
        'yes' => '提现成功',
        'doing' => '正在处理',
        'error' => '提现失败',
      ),
    ),
    'fund_order_status' => 
    array (
      'name' => '结算状态',
      'key' => 'paystatus',
      'list' => 
      array (
        'no' => '等待处理',
        'yes' => '结算成功',
        'doing' => '正在处理',
        'error' => '结算失败',
      ),
    ),
  ),
  'timev' => 
  array (
    'order_main' => 
    array (
      0 => 
      array (
        'name' => '下单时间',
        'field' => 'buytime',
        'key' => 'ordbt',
      ),
      1 => 
      array (
        'name' => '付款时间',
        'field' => 'paytime',
        'key' => 'ordpt',
      ),
    ),
    'recharge_order_main' => 
    array (
      0 => 
      array (
        'name' => '支付时间',
        'field' => 'paytime',
        'key' => 'paytime',
      ),
    ),
    'fund_order_main' => 
    array (
      0 => 
      array (
        'name' => '受理时间',
        'field' => 'paytime',
        'key' => 'paytime',
      ),
    ),
    'cash_order_main' => 
    array (
      0 => 
      array (
        'name' => '受理时间',
        'field' => 'paytime',
        'key' => 'paytime',
      ),
    ),
  ),
) ; ?>