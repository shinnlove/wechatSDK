<?php
/**
 * 微信接口基础类。
 * 注意：该类不包括微信支付部分，微信支付分为第二版和第三版，放在WeChatPay接口部分。
 * 微信支付类也已经经过重构，适合平台级支付。
 * @author shinnlove、tony。
 * @email 306086640@qq.com
 * CreateTime：2014/05/20.
 * LatestModify：2015/04/19.
 * ModifyFor：增加AES加密，丰富类功能。
 * 特别注意：该类是平台级的企业用户接口类。
 */
class WeactWechat {
	
	/**
	 * ==========常量/微信接口Web Service接口地址区域==========
	 */
	
	/**
	 * 获取微信开发者access_token的地址。
	 * @var String WECHAT_TOKEN
	 */
	const WECHAT_TOKEN = "https://api.weixin.qq.com/cgi-bin/token";
	
	/**
	 * 平台微信token中控系统请求地址。
	 * @var String WECHAT_TOKEN_CENTRAL_SYSTEM
	 */
	const WECHAT_TOKEN_CENTRAL_SYSTEM = "http://www.we-act.cn/weact/Interface/ExportWeChat/getWeChatToken";
	
	/**
	 * 微信平台服务器地址列表。
	 * @var String WECHAT_SERVER_IP
	 */
	const WECHAT_SERVER_IP = "https://api.weixin.qq.com/cgi-bin/getcallbackip";
	
	/**
	 * 主动发送客服消息接口地址。
	 * @var String SEND_CUSTOMER_SERVICE_MESSAGE
	 */
	const SEND_CUSTOMER_SERVICE_MESSAGE = "https://api.weixin.qq.com/cgi-bin/message/custom/send";
	
	/**
	 * ==========微信模板消息接口地址区域==========
	 */
	
	/**
	 * 为模板消息设置企业所属行业接口地址。
	 * @var String TEMPLATE_SET_INDUSTRY
	 */
	const TEMPLATE_SET_INDUSTRY = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry";
	
	/**
	 * 通过API接口添加模板消息模板接口地址。
	 * @var String API_ADD_TEMPLATE
	 */
	const API_ADD_TEMPLATE = "https://api.weixin.qq.com/cgi-bin/template/api_add_template";
	
	/**
	 * 发送企业模板消息接口地址。
	 * @var String SEND_TEMPLATE
	 */
	const SEND_TEMPLATE = "https://api.weixin.qq.com/cgi-bin/message/template/send";
	
	/**
	 * ==========微信素材管理接口地址区域==========
	 * 本区域接口共8个，分别为：
	 * 1、新增临时素材；2、获取临时素材；3、新增永久素材；4、获取永久素材；
	 * 5、删除永久素材；6、修改永久图文素材；7、获取素材总数；8、获取素材列表。
	 */
	
	/**
	 * 向微信平台上传多媒体接口地址。
	 * @var String UPLOAD_MEDIA
	 */
	const UPLOAD_MEDIA = "http://file.api.weixin.qq.com/cgi-bin/media/upload";
	
	/**
	 * 向微信平台上传图文信息接口地址。
	 * @var String UPLOAD_NEWS
	 */
	const UPLOAD_NEWS = "https://api.weixin.qq.com/cgi-bin/media/uploadnews";
	
	/**
	 * 向公众号用户、用户分组群发图文接口地址。
	 * @var String MASS_SEND_MESSAGE
	 */
	const MASS_SEND_MESSAGE = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall";
	
	/**
	 * 从微信平台下载多媒体接口地址。
	 * @var String DOWNLOAD_MEDIA
	 */
	const DOWNLOAD_MEDIA = "http://file.api.weixin.qq.com/cgi-bin/media/get";
	
	/**
	 * 上传永久图文素材。
	 * @var String ADD_PERMANENT_NEWS
	 */
	const ADD_PERMANENT_NEWS = "https://api.weixin.qq.com/cgi-bin/material/add_news";
	
	/**
	 * 上传永久多媒体素材。
	 * @var String ADD_PERMANENT_MEDIA
	 */
	const ADD_PERMANENT_MEDIA = "http://api.weixin.qq.com/cgi-bin/material/add_material";
	
	/**
	 * 获取永久素材。
	 * @var String GET_PERMANENT_MATERIAL
	 */
	const GET_PERMANENT_MATERIAL = "https://api.weixin.qq.com/cgi-bin/material/get_material";
	
	/**
	 * 删除永久图文素材。
	 * @var String DELETE_PERMANENT_METERIAL
	 */
	const DELETE_PERMANENT_METERIAL = "https://api.weixin.qq.com/cgi-bin/material/del_material";
	
	/**
	 * 修改永久图文素材。
	 * @var String MODIFY_PERMANENT_NEWS
	 */
	const MODIFY_PERMANENT_NEWS = "https://api.weixin.qq.com/cgi-bin/material/update_news";
	
	/**
	 * 获取永久图文素材总数量。
	 * @var String PERMANENT_METERIAL_COUNT
	 */
	const PERMANENT_METERIAL_COUNT = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount";
	
	/**
	 * 获取永久图文素材列表。
	 * @var String PERMANENT_METERIAL_LIST
	 */
	const PERMANENT_METERIAL_LIST = "https://api.weixin.qq.com/cgi-bin/material/batchget_material";
	
	/**
	 * ==========微信用户管理：用户分组管理接口地址区域==========
	 * 本区域接口共6个，分别为：
	 * 1、创建用户分组；2、查询公众号所有用户分组；3、查询公众号某微信用户所在分组；4、修改公众号用户分组名称；
	 * 5、移动公众号某用户到某分组；6、批量移动公众号部分用户到某分组；7、删除公众号用户分组。
	 */
	
	/**
	 * 微信平台创建用户分组接口地址。
	 * @var String CREATE_USER_GROUP
	 */
	const CREATE_USER_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/create";
	
	/**
	 * 查询公众号所有用户分组接口地址。
	 * @var String QUERY_ALL_GROUP
	 */
	const QUERY_ALL_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/get";
	
	/**
	 * 查询公众号某微信用户所在分组接口地址。
	 * @var String QUERY_USER_IN_GROUP
	 */
	const QUERY_USER_IN_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/getid";
	
	/**
	 * 修改公众号用户分组名称接口地址。
	 * @var String ALTER_USER_GROUP_NAME
	 */
	const ALTER_USER_GROUP_NAME = "https://api.weixin.qq.com/cgi-bin/groups/update";
	
	/**
	 * 移动公众号某用户到某分组接口地址。
	 * @var String MOVE_USER_TO_GROUP
	 */
	const MOVE_USER_TO_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/members/update";
	
	/**
	 * 批量移动公众号部分用户到某分组接口地址。
	 * @var String BATCH_MOVE_USER_TO_GROUP
	 */
	const BATCH_MOVE_USER_TO_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate";
	
	/**
	 * 删除公众号用户分组接口地址。
	 * @var String DELETE_USER_GROUP
	 */
	const DELETE_USER_GROUP = "https://api.weixin.qq.com/cgi-bin/groups/delete";
	
	/**
	 * ==========微信用户管理：用户信息及公众号用户列表接口地址区域==========
	 * 本区域接口共3个，分别为：
	 * 1、修改公众号用户备注名接口地址；2、获取公众号某关注用户微信基本信息接口地址；3、获取公众号所有关注者用户openid列表。
	 * 特别注意：引导用户去微信公众平台授权、回跳后得到参数code，继而再拉取用户信息的接口与方法都封装在WeChatAuthorize控制器中，此处不再赘述。
	 */
	
	/**
	 * 修改公众号用户备注名接口地址。
	 * @var String MODIFY_USER_REMARK_NAME
	 */
	const MODIFY_USER_REMARK_NAME = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark";
	
	/**
	 * 获取公众号某关注用户微信基本信息接口地址。
	 * @var String WECHAT_USER_INFO
	 */
	const WECHAT_USER_INFO = "https://api.weixin.qq.com/cgi-bin/user/info";
	
	/**
	 * 获取公众号所有关注者用户openid列表。
	 * @var String PUBLIC_ALL_SUBSCRIBERS
	 */
	const PUBLIC_ALL_SUBSCRIBERS = "https://api.weixin.qq.com/cgi-bin/user/get";
	
	/**
	 * ==========微信自定义菜单功能接口地址区域==========
	 * 本区域接口共4个，分别为：
	 * 1、设置公众号菜单；2、查询公众号菜单；3、删除公众号自定义菜单；4、获取公众号自定义菜单配置。
	 */
	
	/**
	 * 设置公众号菜单接口地址。
	 * @var String SET_PUBLIC_MENU
	 */
	const SET_PUBLIC_MENU = "https://api.weixin.qq.com/cgi-bin/menu/create";
	
	/**
	 * 查询公众号菜单接口地址。
	 * @var String QUERY_PUBLIC_MENU
	 */
	const QUERY_PUBLIC_MENU = "https://api.weixin.qq.com/cgi-bin/menu/get";
	
	/**
	 * 删除公众号自定义菜单接口地址。
	 * @var String DELETE_PUBLIC_MENU
	 */
	const DELETE_PUBLIC_MENU = "https://api.weixin.qq.com/cgi-bin/menu/delete";
	
	/**
	 * 获取公众号自定义菜单配置接口地址。
	 * @var String PUBLIC_MENU_CONFIG
	 */
	const PUBLIC_MENU_CONFIG = "https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info";
	
	/**
	 * ==========微信账号管理功能接口地址区域==========
	 * 本区域接口共3个，分别为：
	 * 1、创建微信平台公众号二维码；2、下载微信平台公众号二维码；3、微信长链接转短链接接口地址。
	 */
	
	/**
	 * 生成微信平台提供的可关注公众号的二维码地址接口。
	 * @var String CREATE_QRCODE
	 */
	const CREATE_QRCODE = "https://api.weixin.qq.com/cgi-bin/qrcode/create";
	
	/**
	 * 下载微信提供的可关注公众号的二维码地址接口。
	 * @var String DOWNLOAD_QRCODE
	 */
	const DOWNLOAD_QRCODE = "https://mp.weixin.qq.com/cgi-bin/showqrcode";
	
	/**
	 * 微信长链接转短链接接口地址。
	 * @var String LONG_URL_TO_SHORT
	 */
	const LONG_URL_TO_SHORT = "https://api.weixin.qq.com/cgi-bin/shorturl";
	
	/**
	 * ==========微信平台数据统计接口地址区域==========
	 * 微信数据统计接口需要公众号向微信开放平台授权才能进行。
	 * 本区域接口共17（2+6+7+2）个，分别为：
	 * 1、用户分析数据接口（2小类）；2、图文分析数据接口（6小类）；3、消息分析数据接口（7小类）；4、接口分析数据接口（2小类）。
	 */
	
	/**
	 * 获取用户增加数据。
	 * @var String STATISTIC_GET_USER_SUMMARY
	 */
	const STATISTIC_GET_USER_SUMMARY = "https://api.weixin.qq.com/datacube/getusersummary";
	
	/**
	 * 获取累积用户数据。
	 * @var String STATISTIC_GET_USER_CUMULATE
	 */
	const STATISTIC_GET_USER_CUMULATE = "https://api.weixin.qq.com/datacube/getusercumulate";
	
	/**
	 * 获取图文群发每日数据。
	 * @var String STATISTIC_GET_ARTICLE_SUMMARY
	 */
	const STATISTIC_GET_ARTICLE_SUMMARY = "https://api.weixin.qq.com/datacube/getarticlesummary";
	
	/**
	 * 获取图文群发总数据。
	 * @var String STATISTIC_GET_ARTICLE_TOTAL
	 */
	const STATISTIC_GET_ARTICLE_TOTAL = "https://api.weixin.qq.com/datacube/getarticletotal";
	
	/**
	 * 获取图文统计数据。
	 * @var String STATISTIC_GET_USER_READ
	 */
	const STATISTIC_GET_USER_READ = "https://api.weixin.qq.com/datacube/getuserread";
	
	/**
	 * 获取图文统计分时数据。
	 * @var String STATISTIC_GET_USER_READ_HOUR
	 */
	const STATISTIC_GET_USER_READ_HOUR = "https://api.weixin.qq.com/datacube/getuserreadhour";
	
	/**
	 * 获取图文分享转发数据。
	 * @var String STATISTIC_GET_USER_SHARE
	 */
	const STATISTIC_GET_USER_SHARE = "https://api.weixin.qq.com/datacube/getusershare";
	
	/**
	 * 获取图文分享转发分时数据。
	 * @var String STATISTIC_GET_USER_SHARE_HOUR
	 */
	const STATISTIC_GET_USER_SHARE_HOUR = "https://api.weixin.qq.com/datacube/getusersharehour";
	
	/**
	 * 获取消息发送概况数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG
	 */
	const STATISTIC_GET_UPSTREAM_MSG = "https://api.weixin.qq.com/datacube/getupstreammsg";
	
	/**
	 * 获取消息分送分时数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_HOUR
	 */
	const STATISTIC_GET_UPSTREAM_MSG_HOUR = "https://api.weixin.qq.com/datacube/getupstreammsghour";
	
	/**
	 * 获取消息发送周数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_WEEK
	 */
	const STATISTIC_GET_UPSTREAM_MSG_WEEK = "https://api.weixin.qq.com/datacube/getupstreammsgweek";
	
	/**
	 * 获取消息发送月数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_MONTH
	 */
	const STATISTIC_GET_UPSTREAM_MSG_MONTH = "https://api.weixin.qq.com/datacube/getupstreammsgmonth";
	
	/**
	 * 获取消息发送分布数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_DIST
	 */
	const STATISTIC_GET_UPSTREAM_MSG_DIST = "https://api.weixin.qq.com/datacube/getupstreammsgdist";
	
	/**
	 * 获取消息发送分布周数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_DIST_WEEK
	 */
	const STATISTIC_GET_UPSTREAM_MSG_DIST_WEEK = "https://api.weixin.qq.com/datacube/getupstreammsgdistweek";
	
	/**
	 * 获取消息发送分布月数据
	 * @var String STATISTIC_GET_UPSTREAM_MSG_DIST_MONTH
	 */
	const STATISTIC_GET_UPSTREAM_MSG_DIST_MONTH = "https://api.weixin.qq.com/datacube/getupstreammsgdistmonth";
	
	/**
	 * 获取接口分析数据
	 * @var String STATISTIC_GET_INTERFACE_SUMMARY
	 */
	const STATISTIC_GET_INTERFACE_SUMMARY = "https://api.weixin.qq.com/datacube/getinterfacesummary";
	
	/**
	 * 获取接口分析分时数据
	 * @var String STATISTIC_GET_INTERFACE_SUMMARY_HOUR
	 */
	const STATISTIC_GET_INTERFACE_SUMMARY_HOUR = "https://api.weixin.qq.com/datacube/getinterfacesummaryhour";
	
	/**
	 * ==========微信小店接口地址区域==========
	 * 已经使用三方平台商城功能，商家不愿意把商品、存货、销售信息放给微信，该功能暂不开放。
	 * 1、商品管理接口；2、库存管理接口；3、邮费模板管理接口；4、分组管理接口；5、货架管理接口；6、订单管理接口；7、功能接口。
	 */
	
	/**
	 * ==========微信卡券接口地址区域==========
	 * 已经使用三方平台优惠券功能，商家不愿意把商品、顾客、优惠券信息放给微信，该功能暂不开放。
	 * 1、创建卡券接口；2、卡券投放接口；3、卡券核销接口；4、卡券管理接口；5、特殊卡票接口；6、设置测试用户白名单接口。
	 */
	
	/**
	 * ==========微信智能地址区域==========
	 * 虽然已经有了新浪分词接口和智能搜索接口，但是这里还是为了完整，加入微信智能接口部分（语义分析）。
	 */
	
	/**
	 * 微信语义理解代理接口地址。
	 * @var String WECHAT_SEMANTIC_PROXY
	 */
	const WECHAT_SEMANTIC_PROXY = "https://api.weixin.qq.com/semantic/semproxy/search";
	
	/**
	 * ==========微信多客服功能：客服管理接口地址区域==========
	 * 本区域接口共6个，分别为：
	 * 1、获取公众号在线客服列表；2、获取公众号在线客服的状态（服务了多少个客户）；3、为公众号添加客服账号；
	 * 4、修改公众号客服信息接口地址；5、上传公众号客服头像接口；6、删除公众号客服账号。
	 */
	
	/**
	 * 获取公众号在线客服列表接口地址。
	 * @var String CUSTOMER_SERVICE_LIST
	 */
	const CUSTOMER_SERVICE_LIST = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist";
	
	/**
	 * 获取公众号在线客服的状态（服务了多少个客户）接口地址。
	 * @var String CUSTOMER_SERVICE_STATUS
	 */
	const CUSTOMER_SERVICE_STATUS = "https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist";
	
	/**
	 * 为公众号添加客服账号接口地址。
	 * @var String ADD_CUSTOMER_SERVICE
	 */
	const ADD_CUSTOMER_SERVICE = "https://api.weixin.qq.com/customservice/kfaccount/add";
	
	/**
	 * 修改公众号客服信息接口地址。
	 * @var String MODIFY_CUSTOMER_SERVICE_INFO
	 */
	const MODIFY_CUSTOMER_SERVICE_INFO = "https://api.weixin.qq.com/customservice/kfaccount/update";
	
	/**
	 * 上传公众号客服头像接口。
	 * @var String UPLOAD_CUSTOMER_SERVICE_AVATAR
	 */
	const UPLOAD_CUSTOMER_SERVICE_AVATAR = "http://api.weixin.qq.com/customservice/kfacount/uploadheadimg";
	
	/**
	 * 删除公众号客服账号。
	 * @var String UPLOAD_CUSTOMER_SERVICE_AVATAR
	 */
	const DELETE_CUSTOMER_SERVICE = "https://api.weixin.qq.com/customservice/kfaccount/del";
	
	/**
	 * ==========本类私有变量区域==========
	 */
	
	/**
	 * 当前企业的e_id。
	 * 
	 * @var String $e_id
	 */
	private $e_id = '';
	
	/**
	 * 开启开发者模式时填写的token。
	 * 
	 * @var String $developertoken
	 */
	private $developertoken = '';
	
	/**
	 * 企业开发者模式的APPID。
	 * 
	 * @var String $appid
	 */
	private $appid = '';
	
	/**
	 * 企业开发者模式的APPSECRET.
	 * 
	 * @var String $appsecret
	 */
	private $appsecret = '';
	
	/**
	 * 是否开启本类调试模式，若开启则忽略验证签名。
	 * 
	 * @var boolean $debug
	 */
	private $debug = false;
	
	/**
	 * 微信推送过来的数据或响应数据（XML被解析成二维数组形式）
	 * 
	 * @var array $data
	 */
	private $data = array ();
	
	/**
	 * 服务器主动发送给微信服务器的数据。
	 * @var array $send
	 */
	private $send = array ();
	
	/**
	 * 接口调用时产生的错误信息，默认OK
	 * @var String $error
	 */
	private $error = "ok";
	
	/**
	 * 调用操作修改类微信接口（非返回信息类）产生的结果数组（errcode,errmsg）。
	 * @var array $result
	 */
	private $result;
	
	/**
	 * 是否开启aes密文加密传输。
	 * @var boolean $encode
	 */
	private $encode = FALSE;
	
	/**
	 * 开启aes密文传输的加密密钥
	 * @var string $AESKey
	 */
	private $AESKey = '';
	
	/**
	 * 定义http请求头格式。
	 * @var array $header
	 */
	private $header = array ( 'Content-type' => 'text/html', 'charset' => 'utf-8' );
	
	/**
	 * 本类WeactWechat的构造函数。
	 * @param array $options 创建微信类的信息数组，包含如下字段信息：
	 * @property string e_id 企业编号
	 * @property string appid 企业开发者APPID
	 * @property string appsecret 企业开发者APPSECRET
	 * @property string developertoken 企业在平台接入开发者模式的token，可以自行修改，默认123456
	 * @property boolean encode 是否需要开启密文传输
	 * @property string aeskey 如果开启密文传输，aes的加密key
	 * @property boolean debug 是否开启调试模式
	 */
	public function __construct($options = array ()) {
		$this->e_id = isset ( $options ['e_id'] ) ? $options ['e_id'] : ''; // 本类要操作的企业编号（平台下的）
		$this->appid = isset ( $options ['appid'] ) ? $options ['appid'] : ''; // 本类要操作的APPID
		$this->appsecret = isset ( $options ['appsecret'] ) ? $options ['appsecret'] : ''; // 本类要操作的APPSecret
		$this->developertoken = isset ( $options ['developer_token'] ) ? $options ['developer_token'] : '123456'; // 本类要操作的开发者模式token
		$this->encode = ! empty ( $options ['msg_encode'] ) ? true : false; // 是否需要对微信消息进行加密
		$this->AESKey = isset ( $options ['aeskey'] ) ? $options ['aeskey'] : ''; // AES加密的Key
		$this->debug = isset ( $options ['debug'] ) ? $options ['debug'] : false; // 是否开启调试模式
		// 判断是否传入了企业信息、appid和appsecret，三者都不为空才创建对象
		if (empty ( $this->e_id ) || empty ( $this->appid ) || empty ( $this->appsecret )) {
			$this->error = "创建微信接口层失败，企业编号、企业开发者appid和appsecret都不能为空！";
			return false;
		}
		// 如果开启了加密传输消息，则判断加密AESKey是否长度正确
		if ($this->encode && strlen ( $this->AESKey ) != 43) {
			$this->error = 'AESKey Lenght Error.'; // AESKey加密密钥长度错误
			return false;
		}
	}
	
	/**
	 * ==========基本类变量读写函数区域==========
	 */
	
	/**
	 * 返回当前类的商家编号。
	 * @return string $e_id 企业编号
	 */
	public function gete_id(){
		return $this->e_id;
	}
	
	/**
	 * 返回当前类的商家APPID。
	 * @return string $appid 企业开发者模式appid
	 */
	public function getAPPID(){
		return $this->appid;
	}
	
	/**
	 * 返回当前类的商家APPSecret。
	 * @return string $appsecret 企业开发者模式appsecret
	 */
	public function getAPPSecret(){
		return $this->APPSecret;
	}
	
	/**
	 * 方便开发者调试维护的函数，查看该微信类的商家配置（平台）。
	 */
	public function getConfig() {
		$configinfo = array (
				'e_id' => $this->e_id, // 平台商家编号
				'developertoken' => $this->developertoken, // 开发者模式填写的token
				'appid' => $this->appid, // 开发者模式appid
				'appsecret' => $this->appsecret, // 开发者模式appsecret
				'debug' => $this->debug, // 是否开启接口调试模式
				'data' => $this->data, // 微信发来的POST消息数据（二维数组）
				'send' => $this->send, // 准备要发送给微信用户的数据（二维数组）
				'error' => $this->error, // 微信接口调用失败解析的错误信息
				'result' => $this->result, // 微信操作类接口调用后产生的结果信息
				'encode' => $this->encode, // 微信POST来的消息数据是否开启AES加解密
				'AESKey' => $this->AESKey // 该商家的aes加密密钥
		);
		return $configinfo;
	}
	
	/**
	 * ==========本类私有函数区域==========
	 */
	
	/**
	 * 私有敏感函数：向中控系统请求access_token函数。
	 * 该接口类型为GET。
	 * @return string $access_token 企业的token信息
	 */
	private function getToken() {
		$url = self::WECHAT_TOKEN_CENTRAL_SYSTEM;			//请求获取accesstoken的url
		$params ['e_id'] = $this->e_id;						//商家编号
		$httpstr = http ( $url, $params );					//使用http方法获取服务器返回数据$httpstr
		$jsonresult = json_decode ( $httpstr, true );		//使用json格式对数据解码，第二个参数为true时，将返回数组而非对象object
		return $jsonresult ['access_token'];				//返回token信息
	}
	
	/**
	 * ==========微信接口验证准备工作==========
	 */
	
	/**
	 * 验证URL有效性，在request解析数据前调用。
	 */
	public function valid() {
		$echoStr = $_GET ["echostr"]; // 尝试获取GET字段
		if (isset ( $echoStr )) {
			// 如果验证URL
			if ($this->checkSignature ()) {
				//echo $echoStr; // 验证成功则输出到页面上
				exit ( $echoStr ); // 验证成功则输出到页面上
			} else {
				exit ( "Access Denied! 身份验证失败，拒绝响应非微信发来的数据，谢谢合作！" );
			}
		}
		return true;
	}
	
	/**
	 * 对数据进行签名认证，确保是微信发送的数据，原auth函数。
	 * @return boolean true-签名正确，false-签名错误
	 */
	public function checkSignature() {
		if ($this->debug) return true; // 如果本类处于调试状态，直接返回真
		
		$signature = $_GET ['signature']; // 获取消息签名
		$timestamp = $_GET ['timestamp']; // 获取消息时间戳
		$nonce = $_GET ['nonce']; // 获取消息随机数
		if (empty ( $signature ) || empty ( $timestamp ) || empty ( $nonce )) {
			return false; // 如果消息的前民个、时间戳或随机数是空的，则返回false
		}
		$token = $this->developertoken; // 取当前的开发者模式token
		if (! $token) return false; // 如果实例化类的时候不传入token，直接返回false
		
		$tmpArr = array ( $token, $timestamp, $nonce ); // Step1：把开发者模式token，时间戳和随机数放入数组中
		sort ( $tmpArr, SORT_STRING ); // Step2：对数组数据进行字典排序
		$tmpStr = implode ( $tmpArr ); // Step3：切分数组
		return sha1 ( $tmpStr ) == $signature; // Step4：比对签名是否正确
	}
	
	/**
	 * 获取微信推送的数据，包含两个：1、验证真实性；2、接收一般消息。
	 * @return array 转换为数组后的数据
	 *
	 * 在这里声明下微信的数据格式：
	 * <xml>
	 *		<ToUserName><![CDATA[toUser]]></ToUserName>				开发者微信号
	 *		<FromUserName><![CDATA[fromUser]]></FromUserName> 		发送方帐号（一个OpenID）
	 *		<CreateTime>1348831860</CreateTime>						消息创建时间 （整型）
	 *		<MsgType><![CDATA[text]]></MsgType>						消息类型
	 *		<Content><![CDATA[this is a test]]></Content>			消息内容
	 *		<MsgId>1234567890123456</MsgId>							消息id，64位整型，消息的主键，可以用来查重
	 * </xml>
	 *
	 *  2014/06/22 03:24:25 写入。
	 *
	 */
	public function request() {
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"]; // 获取微信POST推送过来的数据
		if (! empty ( $postStr )) {
			// 如果消息不空
			$this->data = self::extractXml ( $postStr ); // 抽取微信推送的消息，解码成data（我已经修改成不转为小写字母，尊重微信原来的字段名称，注意！）
			if ($this->encode && ! empty ( $this->AESKey )) {
				// 如果该企业开启密文，且数据库已配置
				$datadecode = $this->AESdecode ( $this->data ['Encrypt'] ); // 直接对其进行解密
				if (! empty ( $datadecode )) {
					$this->data = $datadecode; // 返回aes解码后的结果
				}
			}
			return $this->data; // 返回解析后的数据
		} else {
			// 空消息不予理会
			exit ( "" ); // 直接将空消息输出
			return false;
		}
		// 原来的解析
		/* $xml = file_get_contents ( "php://input" ); // php读取文件函数file_get_contents()，读入xml文件，file_get_contents("php://input")代表php文件输入流
		$xml = new SimpleXMLElement ( $xml ); // 使用php的SimpleXMLElement()函数来解析xml
		$xml || exit ( '' ); // 如果解析的xml是空文档则退出
		p($xml);die;
		foreach ( $xml as $key => $value ) { // 使用php的foreach循环，将解码后的xml的键和值对应转成数组
			$this->data [$key] = strval ( $value ); // 本类中定义了$data数组，将解码后的xml转成格式data['键值']=字符串值，strval()函数是php转字符串
		}
		
		if ($this->encode) {
			// 如果该企业开启密文
			$datadecode = $this->AESdecode ( $this->data ['encrypt'] ); // 直接对其进行解密
			$this->data = $datadecode; // 返回aes解码后的结果
		}
		return $this->data; // 返回将xml转成的数组  */
	}
	
	/**
	 * ==========微信接口部分函数==========
	 * 以下部分封装各种各样的微信接口函数。
	 */
	
	/**
	 * 基础支持：获取微信服务器IP地址，已调通。
	 * @return array $wechatiplist 微信地址列表
	 */
	public function wechatServerIP() {
		$params ['access_token'] = $this->getToken ();
		$serverIPJson = http ( self::WECHAT_SERVER_IP, $params );
		$jsonArr = $this->parseJson ( $serverIPJson );
		return $jsonArr;
	}
	
	/**
	 * ==========被动回复用户消息接口部分==========
	 */
	
	/**
	 * 被动响应微信发送的信息（被动回复），密文模式已调通。
	 * @param string $to 接收用户名
	 * @param string $from 发送者用户名
	 * @param array $content 回复信息，文本信息为string类型
	 * @param string $type 消息类型
	 * @param string $flag 是否新标刚接受到的信息
	 * @return string XML字符串
	 */
	public function response($content, $type = 'text', $flag = 0) {
		/* 原来SDK的代码：定义本类的基础数据$data */
		$timenow = NOW_TIME;
		$this->data = array(
				'ToUserName'   => $this->data ['FromUserName'],		//$weixin中有request的$data数据，取出FromUserName作为被回复者（用户）
				'FromUserName' => $this->data ['ToUserName'],		//$weixin中有request的$data数据，取出ToUserName作为回复者（公众号）
				'CreateTime'   => $timenow,							//当前时间
				'MsgType'      => $type,							//取消息类型
		);
		
		/* 添加类型数据 */
		$this->$type ( $content );
		
		/* 添加状态 */
		$this->data ['FuncFlag'] = $flag; // （这里我先省去了，形参中原来有个$flag = 0标识自己服务器的新旧消息）
		
		/* 转换数据为XML */
		$response = self::array2Xml ( $this->data );
		
		if ($this->encode) {
			// 如果采用密文模式，则加密后再发送
			$nonce                  = $_GET ['nonce']; // $nonce用$_GET ['nonce']获取！2015/04/24，不可以自己生成一个，否则签名比对不上
			//$nonce = md5 ( $timenow . randCode ( 4, 1 ) );
			$xmlStr ['Encrypt']      = $this->AESencode ( $response ); // 采用密文模式加密
			$xmlStr ['MsgSignature'] = self::getSHA1 ( $xmlStr ['Encrypt'], $nonce );
			$xmlStr ['TimeStamp']    = $timenow;
			$xmlStr ['Nonce']        = $nonce;
			$response = '';
			$response = self::array2Xml ( $xmlStr ); // 将本类数组$data转换数据为XML
		}
		exit ( $response ); // 输出结果回应微信
	}
	
	/**
	 * 回复文本信息（被动回复）。
	 * @param  string $content 要回复的信息
	 */
	private function text($content){
		$this->data['Content'] = $content;
	}
	
	/**
	 * 回复音乐信息（被动回复）。
	 * @param  string $content 要回复的音乐
	 */
	private function music($music){
		$this->data['Music'] = $music;
	}
	
	/**
	 * 回复图文信息（被动回复）。
	 * @param  string $news 要回复的图文内容
	 */
	private function news($news){
		$articles = array();
		foreach ($news as $key => $value) {
			$articles[$key]['Title'] = $value['Title'];
			$articles[$key]['Description'] = $value['Description'];
			$articles[$key]['PicUrl'] = $value['PicUrl'];
			$articles[$key]['Url'] = $value['Url'];
			if ($key >= 9) { break; } //最多只允许10条新闻
		}
		$this->data['ArticleCount'] = count($articles);
		$this->data['Articles'] = $articles;
	}
	
	/**
	 * ==========主动发送客服消息接口部分==========
	 */
	
	/**
	 * 主动发送消息（客服接口），此函数为类外可以调用的客服消息发送函数，已调通。
	 * 该函数执行消息的打包，最终发送还需要调用本类内部的私有函数send。
	 * @param string $content 要发送的消息内容
	 * @param string $openid 要发送给的微信用户openid
	 * @param string $msgtype 要发送消息的类型
	 * @param string $kf_account 可选字段：（微信6.0.2版本以上可用）客服账号昵称及自定义头像
	 * @return array 微信服务器返回的发送结果信息（json_decode后的数组格式）
	 */
	public function sendMsg($content, $openid = '', $msgtype = 'text', $kf_account = '') {
		/* 基础数据 $send = array();已经简写 */
		$this->send ['touser'] = $openid;					//设置数组$send（当前函数中的变量$this->）的touser（发送给谁）
		$this->send ['msgtype'] = $msgtype;					//设置数组$send的发送类型：文本信息类型
		
		/* 添加类型数据 */
		$sendtype = 'send' . $msgtype; // 拼接不同的函数名称
		$this->$sendtype ( $content ); // 多态调用不同函数名
	
		/* 处理新添加的客服信息 */
		if (! empty ( $kf_account )) {
			$this->send ['customservice'] ['kf_account'] = $kf_account; // 如果客服账号不空，则添加客服账号
		}
		
		/* 发送 */
		$sendjson = jsencode ( $this->send ); // 压缩要发送的数据包，采用无转义字符方式压缩
		$url = self::SEND_CUSTOMER_SERVICE_MESSAGE . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$httpresult = http ( $url, $sendjson, 'POST', $this->header, true );	// 调用Common公有的http()函数发送给微信服务器
		$sendresult = $this->parseJson ( $httpresult ); // 解析发送客服消息结果
		return $sendresult;
	}
	
	/**
	 * 主动发送（客服接口）文本消息，已调通。
	 * @param string $content 要发送的信息
	 */
	private function sendtext($content) {
		$this->send ['text'] = array (
				'content' => $content
		);
	}
	
	/**
	 * 主动发送（客服接口）图片消息，已调通。
	 * @param string $content 要发送的信息
	 */
	private function sendimage($content) {
		$this->send ['image'] = array (
				'media_id' => $content
		);
	}
	
	/**
	 * 主动发送（客服接口）视频消息。
	 * @param string $content 要发送的信息
	 */
	private function sendvideo($video){
		list (
				$video ['media_id'],
				$video ['title'],
				$video ['description']
		) = $video;
	
		$this->send ['video'] = $video;
	}
	
	/**
	 * 主动发送（客服接口）语音消息，已调通。
	 * @param string $content 要发送的信息
	 */
	private function sendvoice($content) {
		$this->send ['voice'] = array (
				'media_id' => $content
		);
	}
	
	/**
	 * 主动发送（客服接口）音乐消息。
	 * @param string $content 要发送的信息
	 */
	private function sendmusic($music) {
		$this->send ['music'] = $music;
	}
	
	/**
	 * 主动发送（客服接口）图文消息，已调通。
	 * 已经修复原来SDK的错误。
	 * 修复时间：2014/07/05 02:23:25.
	 * Author：赵臣升。
	 * @param string $news 要回复的图文内容
	 *
	 * $news消息格式：（注意都是小写）.
	 * $content[$i]['title'] = '标题';
	 * $content[$i]['description'] = '描述';
	 * $content[$i]['picurl'] = '封面地址';
	 * $content[$i]['url'] = '具体地址';
	 */
	private function sendnews($news) {
		$articles = array ();
		$k = 0; // 图文条数
		foreach ($news as $key => $value) {
			if ($k > 9) { break; } // 最多只允许10条图文（也最多只装入10条图文）
			$articles [$k] ['title'] = $value ['title'];
			$articles [$k] ['description'] = $value ['description'];
			$articles [$k] ['url'] = $value ['url'];
			$articles [$k] ['picurl'] = $value ['picurl'];
			$k ++; // 赋值一条图文后，k值+1
		}
		$finalnews ['articles'] = $articles; // 图文放入articles索引中
		$this->send ['news'] = $finalnews; // 整个articles放入news索引中
	}
	
	/**
	 * ==========发送企业模板消息==========
	 */
	
	/**
	 * 模板消息设置企业信息所属行业，最多允许一个企业两个行业。
	 * 接口类型：POST。
	 */
	public function setIndustry($industry1 = "41", $industry2 = "41") {
		$url = self::TEMPLATE_SET_INDUSTRY . "?access_token=" . $this->getToken ();
		if (empty ( $industry1 ) || empty ( $industry2 )) {
			$this->error = "请选择企业模板消息所属行业。";
			return false;
		}
		$num1 = intval ( $industry1 ); 	// 行业1转整形
		$num2 = intval ( $industry2 ); 	// 行业2转整形
		if ($num1 <= 0 || $num1 > 41) {
			$industry1 = "41"; 			// 必要的容错，行业不能超过范围
		}
		if ($num2 <= 0 || $num2 > 41) {
			$industry2 = "41"; 			// 必要的容错，行业不能超过范围
		}
		// 准备post参数
		$params = array (
				'industry_id1' => $industry1, // 行业1
				'industry_id2' => $industry2, // 行业2
		);
		$jsoninfo = jsencode ( $params ); 	// 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		return $jsonresult;
	}
	
	/**
	 * 设置企业需要使用的模板，并且返回模板id。
	 * @param string $commontp_id 需要使用的模板公共编号
	 * @return string $template_id 返回设置后的模板ID
	 */
	public function setTemplateInfo($commontp_id = "TM00015") {
		$url = self::API_ADD_TEMPLATE . "?access_token=" . $this->getToken ();
		if (empty ( $commontp_id )) {
			$this->error = "请输入要使用的企业模板编号。";
			return false;
		}
		$params = array (
				'template_id_short' => $commontp_id, // 要使用的模板
		);
		$jsoninfo = jsencode ( $params ); 	// 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		if ($jsonresult) {
			return $this->getResult (); // 想查看结果可以调用getResult
		} else {
			return $jsonresult;
		}
	}
	
	/**
	 * 发送模板消息，最后一个参数必须保证。
	 * @param string $openid 微信用户openid
	 * @param string $template_id 企业设置的模板消息
	 * @param string $url 点击模板消息后的跳转链接
	 * @param array $tpldata 模板类型（特别注意：因为模板消息变量类型各异，这里$tpldata一定由最外部调用给出参数，不能在内部拼装）
	 * @param string $topcolor 模板消息顶部的颜色（并不是每个模板都可以设置顶部颜色的）
	 * @return array $sendresult 发送结果
	 */
	public function sendTemplateMsg($openid = "", $template_id = "", $linkurl = "", $tpldata = NULL, $topcolor = "#FF0000") {
		$url = self::SEND_TEMPLATE . "?access_token=" . $this->getToken ();
		if (empty ( $openid )) {
			$this->error = "请输入要发送模板消息的微信用户。";
			return false;
		}
		if (empty ( $template_id )) {
			$this->error = "请输入要使用的企业模板编号。";
			return false;
		}
		if (empty ( $url )) {
			$this->error = "请输入点击模板消息跳转的图文地址URL。";
			return false;
		}
		$params = array (
				'touser' => $openid, 			// 微信用户openid
				'template_id' => $template_id, 	// 企业模板编号
				'url' => $linkurl, 				// 点击模板消息后的网址URL
				'topcolor' => $topcolor, 		// 模板消息顶部颜色
				'data' => $tpldata, 			// 模板消息
		);
		$jsoninfo = jsencode ( $params ); 	// 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		if ($jsonresult) {
			return $this->getResult (); // 想查看结果可以调用getResult
		} else {
			return $jsonresult;
		}
	}
	
	/**
	 * ==========素材管理接口部分==========
	 */
	
	/**
	 * 上传多媒体接口，把数据发送到微信服务器，已调通。
	 * 特别注意：$mediapath请传入多媒体文件的绝对路径。
	 * 该接口为POST接口，表单提交方式。
	 * @param string $mediapath	多媒体在window下的绝对路径：@$mediapath
	 * @param string $type 多媒体类型，有image,voice,video,thumb4种
	 * @return array $httpinfo 上传多媒体得到微信服务器端的返回
	 */
	public function uploadMedia($mediapath = '', $type = 'image') {
		$filedata ['media'] = '@' . $mediapath;
		$url = self::UPLOAD_MEDIA . "?access_token=" . $this->getToken () . "&type=" . $type; // 拼接发送信息API的URL请求地址
		$httpresult = http ( $url, $filedata, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		return $jsonresult;	
	}
	
	/**
	 * 上传图文API接口，已调通。
	 * 特别注意：这里上传的是临时图文！~
	 * @param array $articleinfo 要上传的图文信息
	 * @return array $uploadnewsresult 上传图文得到的返回结果
	 */
	public function uploadNews($articleinfo = NULL) {
		$url = self::UPLOAD_NEWS . "?access_token=" . $this->getToken ();
		$jsoninfo = jsencode ( $articleinfo ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		return $jsonresult;
	}
	
	/**
	 * 群发图文接口，该接口为高级接口（需要认证），已调通。
	 * @param number $sendgroupid 群发图文的分组编号
	 * @param string $msgnewsid 微信平台上传图文后得到的media_id，而不是本地数据库的图文主键。
	 * @return array $groupsendresult 群发结果
	 */
	public function publicGroupSendNews($sendgroupid = 0, $msgnewsid = '') {
		if (empty ( $msgnewsid )) {
			$this->error = "必须给出要群发的图文编号。";
			return false;
		}
		$url = self::MASS_SEND_MESSAGE . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$params = array (
				"filter" => array (
						"is_to_all" => false, // 使用is_to_all为true且成功群发，会使得此次群发进入历史消息列表
						"group_id" => $sendgroupid // 要发送的组号
				),
				"mpnews" => array (
						"media_id" => $msgnewsid // 微信平台上传图文后得到的编号
				),
				"msgtype" => "mpnews" // 群发类型为图文
		);
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 微信下载多媒体接口API，依据media_id从微信服务器下载多媒体信息，已调通。
	 * 终于调通，调通时间：2015/04/12 22:41:25.
	 * 该接口不同于其他微信接口，还有http请求头。
	 * @param string $media_id 形参传入多媒体的编号
	 * @param string $savefinalpath 多媒体文件最终保存路径
	 * @return array $downloadresult 下载多媒体文件是否成功
	 */
	public function downloadMedia($media_id = '', $savefinalpath = '') {
		// 定义全局返回码
		$downloadresult = array (
				'errCode' => 10001,
				'errMsg' => "下载多媒体文件失败，请稍后再试！"
		); // 默认没下载成功
		
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get';	//定义API请求查询菜单的URL地址
		$params = array (
				'access_token' => $this->getToken(),				//获取当前商家的access_token
				'media_id' => $media_id 							//获取当前要下载的media_id
		);
		// 下载多媒体
		$fileInfo = downloadWeixinFile ( $url, $params );			//调用Common公有函数中的downloadWeixinFile()函数请求微信服务器返回数据
		$httpresult = json_decode ( $fileInfo ['body'], true ); 	// utf-8解码数据
	
		// // 微信端文件是否成功返回，如果文件出错
		if (isset ( $httpresult ['errcode'] ) && $httpresult ['errcode'] != 0 ) {
			// 如果有错误信息
			$downloadresult ['errCode'] = $httpresult ['errcode'];  // 错误码给他
			return $downloadresult; // 返回错误信息
		}
	
		// 如果不出错，尝试下载多媒体文件，并写入本地磁盘文件
		$localFile = fopen ( $savefinalpath, 'w' );					//打开文件流，写文件方式
		if ($localFile !== false) {
			// 如果创建文件成功，则写入文件
			if (fwrite ( $localFile, $fileInfo ['body'] ) !== false) {
				fclose ( $localFile ); // 关闭文件读写流
				// 将成功写入的信息返回
				$downloadresult ['errCode'] = 0;
				$downloadresult ['errMsg'] = "ok";
				$downloadresult ['mediapath'] = $savefinalpath;
			}
		}
		return $downloadresult;
	}
	
	/**
	 * 新增永久图文素材。
	 * 特别注意：新增图文素材的封面图片media_id必须是永久media_id。
	 */
	public function addPermanentNews($articleinfo = NULL) {
		$url = self::ADD_PERMANENT_NEWS . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $articleinfo ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		return $jsonresult;
	}
	
	/**
	 * 新增永久多媒体素材，已调通。
	 */
	public function addPermanentMedia($mediapath = '', $type = 'image') {
		$filedata ['media'] = '@' . $mediapath;
		$url = self::ADD_PERMANENT_MEDIA . "?access_token=" . $this->getToken () . "&type=" . $type; // 拼接发送信息API的URL请求地址
		$httpresult = http ( $url, $filedata, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult );
		return $jsonresult;
	}
	
	/**
	 * 获取永久多媒体接口，图片、语音已调通。
	 * @param string $media_id 要下载的永久多媒体media_id
	 * @param string $type 要下载的永久多媒体类型，必须显式指定
	 * @param string $savemediapath 要保存该永久多媒体到磁盘的哪个位置（带文件名和后缀）
	 * @return array|boolean $downloadmediaresult 下载永久多媒体的结果
	 */
	public function getPermanentMedia($media_id = '', $type = 'image', $savemediapath = '') {
		$geturl = self::GET_PERMANENT_MATERIAL; // 拼接微信api GET地址
		$posturl = self::GET_PERMANENT_MATERIAL . "?access_token=" . $this->getToken (); // 拼接微信api POST地址
		if ($type == "news") {
			// 处理图文消息下载
			
		} else if ($type == "image" || $type == "voice") {
			// 处理图片、声音多媒体的下载：直接下载素材
			if (empty ( $savemediapath )) {
				$this->error = "请指定多媒体文件的保存路径，否则无法下载。";
				return false;
			}
			// 正常下载多媒体
			$downloadresult = $this->getMediaFromURL ( $posturl, $media_id, $savemediapath ); // 从URL地址下载多媒体
			return $downloadresult; // 返回下载的多媒体信息
		} else if ($type == "video") {
			// 处理视频的下载，获取返回信息，根据URL下载
			if (empty ( $savemediapath )) {
				$this->error = "请指定多媒体文件的保存路径，否则无法下载。";
				return false;
			}
			// 正常下载多媒体
		} else {
			// 无法处理的永久素材
			$this->error = "无法识别的素材类型，请给出合理的素材类型。";
			return false;
		}
	}
	
	/**
	 * 私有函数，从URL上下载多媒体文件（如浏览器获取一样），已调通。
	 * @param string $downloadurl 需要从哪个地址下载多媒体
	 * @param string $media_id 要下载的多媒体id
	 * @param string $savefinalpath 要保存到的磁盘文件路径
	 * @return array $downloadresult 下载的多媒体文件信息
	 */
	private function getMediaFromURL($downloadurl = '', $media_id = '', $savefinalpath = '') {
		// 定义全局返回码
		$downloadresult = array (
				'errCode' => 10001,
				'errMsg' => "下载多媒体文件失败，请稍后再试！"
		); // 默认没下载成功
		
		$params ['media_id'] = $media_id;
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $downloadurl, $jsoninfo, 'POST', $this->header, true ); // 调用Common公有的http()函数发送给微信服务器
		
		// 如果不出错，尝试下载多媒体文件，并写入本地磁盘文件
		$localFile = fopen ( $savefinalpath, 'w' );					//打开文件流，写文件方式
		if ($localFile !== false) {
			// 如果创建文件成功，则写入文件
			if (fwrite ( $localFile, $httpresult ) !== false) {
				fclose ( $localFile ); // 关闭文件读写流
				// 将成功写入的信息返回
				$downloadresult ['errCode'] = 0;
				$downloadresult ['errMsg'] = "ok";
				$downloadresult ['mediapath'] = $savefinalpath;
			}
		}
		return $downloadresult;
	}
	
	/**
	 * 调取永久素材接口。
	 * @param string $type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
	 * @param number $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回，nextstart的意思
	 * @param number $count 返回素材的数量，取值在1到20之间
	 * @return array $medialist 永久素材列表
	 */
	public function getPermanentMediaList($type = "image", $offset = 0, $count = 1) {
		if ($type != "image" && $type != "video" && $type != "voice" && $type != "news") {
			$this->error = "要读取的图文素材类型不符。";
			return false;
		}
		if ($offset < 0) {
			$this->error = "请输入正确的素材读取起始位置。";
			return false;
		}
		if ($count < 1 || $count > 20) {
			$this->error = "一次性最多读取1~20条永久素材！";
			return false;
		}
		$params = array (
				'type' => $type, 
				'offset' => $offset, 
				'count' => $count, 
		);
		$url = self::PERMANENT_METERIAL_LIST . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * ==========用户管理：用户分组管理接口部分==========
	 */
	
	/**
	 * 微信平台创建分组接口，已调通。
	 * 该接口为POST类型。
	 * @param string $groupname 创建分组的名称
	 * @return array $jsonresult 创建分组的结果的数组信息
	 */
	public function createGroup($groupname = '默认') {
		if (empty ( $groupname )) {
			$this->error = "请输入一个分组名称。";
			return false;
		}
		$params = array (
				'group' => array (
						'name' => $groupname
				)
		);
		$url = self::CREATE_USER_GROUP . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 查询公众号所有用户分组，已调通。
	 * 该接口为GET类型。
	 * 特别注意：该接口没有errcode == 0的，直接返回用户分组json。
	 * @return array $groupinfo 返回企业的分组信息。
	 */
	public function queryAllGroup() {
		$params ['access_token'] = $this->getToken (); // 获取access_token
		$httpresult = http ( self::QUERY_ALL_GROUP, $params ); // 发送http请求获取所有用户分组
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 查询用户所在分组，传入array数组：openid和值，已调通。
	 * 该接口为POST类型。
	 * @param string $openid 用户的微信openid。
	 * @return array $groupinfo 包含组id的组信息。
	 */
	public function queryUserGroup($openid = '') {
		if (empty ( $openid )) return false; // 用户openid不能为空
		$url = self::QUERY_USER_IN_GROUP . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$params ['openid'] = $openid; // 准备POST参数
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 拓展：批量查询用户所在分组，传入用户微信openid的一位数组，已调通。
	 * @param array $openidgroup 要批量查询的用户openid，一位数组
	 * @return array $batchqueryresult 批量查询用户分组结果
	 */
	public function batchQueryUserGroup($openidgroup = NULL) {
		if (empty ( $openidgroup )) return false; // openid数组不能为空
		$batchqueryresult = array (); // 批量查询用户分组的结果
		$url = self::QUERY_USER_IN_GROUP . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$querynum = count ( $openidgroup ); // 统计查询人数
		for($i = 0; $i < $querynum; $i ++) {
			$singlequery ['openid'] = $openidgroup [$i]; // 构建单微信用户查询参数
			$singlejsoninfo = jsencode ( $singlequery ); // 打包数据
			$singlejsonresult = http ( $url, $singlejsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
			$batchqueryresult [$i] = $this->parseJson ( $singlejsonresult ); // 解析json信息
		}
		return $batchqueryresult;
	}
	
	/**
	 * 修改分组名。（特别注意，组id只增不减），已调通。
	 * 该接口为POST类型。
	 * @param number $group_id 要修改名字的组id
	 * @param string $modify_name 要修改的新组名
	 * @return boolean|string 修改成功返回true，修改失败返回失败信息。
	 */
	public function alterGroupName($group_id = 101, $modify_name = '') {
		// 判断组id和要修改的名称都不空
		if (empty ( $group_id ) || empty ( $modify_name )) {
			$this->error = '请选择一个分组，并输入一个新的名称。';
			return false;
		}
		// 打包修改组的数据格式
		$params = array (
				'group' => array (
						'id'   => $group_id,
						'name' => $modify_name
				)
		);
		// 发送修改
		$url = self::ALTER_USER_GROUP_NAME . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 移动用户分组函数，已调通。
	 * @param string $openid 要移动的微信用户openid
	 * @param number $to_groupid 要移动到的目标分组id（为了防止出错，默认移动到未分组）
	 * @return array $moveresult 移动用户到某个分组的结果（数组）
	 */
	public function moveUserToGroup($openid = '', $to_groupid = 0) {
		if (empty ( $openid ) || ! is_numeric ( $to_groupid )) {
			$this->error = "请指定一个微信用户的openid，并指定要将其移动到的分组编号。";
			return false;
		}
		// 准备数据
		$params = array (
				'openid' => $openid,
				'to_groupid' => $to_groupid 
		);
		$url = self::MOVE_USER_TO_GROUP . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 微信新更新的批量移动用户分组接口，已调通。
	 * @param array $openidlist 要移动的微信用户openid列表
	 * @param number $to_groupid 要移动到的用户分组编号
	 * @return array $batchmoveresult 批量移动用户结果
	 */
	public function newBatchMoveUserToGroup($openidlist = NULL, $to_groupid = 0) {
		if (empty ( $openidlist ) || ! is_numeric ( $to_groupid )) {
			$this->error = "请指定要移动的微信用户openid列表，并指明要移动到的分组编号。";
			return false;
		}
		// 准备打包信息
		$params = array (
				'openid_list' => $openidlist,
				'to_groupid' => $to_groupid
		);
		$url = self::BATCH_MOVE_USER_TO_GROUP . "?access_token=" . $this->getToken (); // 定义要请求的URL地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$batchmoveresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $batchmoveresult;
	}
	
	/**
	 * 拓展：批量移动用户到某分组的函数，从时间复杂度上对单次移动进行优化。
	 * 推荐最佳的批量移动数量为20~50条，不要太多，否则用户等待时间比较长。
	 * 形参数组格式：$movelist
	 * $movelist = array(
	 *     0 => array( 'openid' => $openid0, 'groupid' => groupid0 ),
	 *     1 => array( 'openid' => $openid1, 'groupid' => groupid1 ),
	 *     2 => array( 'openid' => $openid2, 'groupid' => groupid2 ),
	 *     ...
	 * );
	 * @param array $movelist 要移动的用户和组的信息二维数组
	 * @return array $batchmoveresult 批量移动用户到组结果的二维数组，就是单次调用结果的二维数组集合。
	 */
	public function batchMoveUserToGroup($movelist = NULL) {
		if (empty ( $movelist )) return false;
		$batchmoveresult = array(); // 批量移动用户到组结果
		$url = self::MOVE_USER_TO_GROUP . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$num = count( $movelist );
		for($i = 0; $i < $num; $i ++) {
			$singlejsoninfo = jsencode ( $movelist [$i] );
			$singlejsonresult = http ( $url, $singlejsoninfo, 'POST', $header, true );
			$batchmoveresult [$i] = json_decode ( $singlejsonresult, true );
		}
		return $batchmoveresult;
	}
	
	/**
	 * ==========用户管理：用户信息接口部分==========
	 */
	
	/**
	 * 设置某个用户的备注名接口，已调通。
	 * 该接口为POST类型。
	 * @param string $openid 要修改备注名的微信用户openid
	 * @param string $remarkname 要为该用户修改的备注名
	 * @return array $modifyresult 修改备注名的结果。
	 */
	public function modifyUserRemark($openid = '', $remarkname = '') {
		if (empty ( $openid ) || empty ( $remarkname )) {
			$this->error = "请指定一个微信用户，并给出备注名。";
			return false;
		}
		// 准备信息
		$remarkinfo = array (
				'openid' => $openid,
				'remark' => $remarkname,
		);
		$url = self::MODIFY_USER_REMARK_NAME . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $remarkinfo ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 单个获取微信用户的基本资料，传入用户的openid（每个公众号对于同一个用户的openid都不同，防止恶意集粉。），已调通。
	 * @param string $openid 要查询的用户微信openid
	 * @return array $userinfo 某微信用户的资料（如果关注公众号）
	 */
	public function getUserInfo($openid = '') {
		if (empty ( $openid )) {
			$this->error = "需要获取信息的微信用户openid不能为空。";
			return false;
		}
		$params = array (
				'access_token' => $this->getToken (), // 获取access_token
				'openid' => $openid
		);
		$httpresult = http ( self::WECHAT_USER_INFO, $params ); // 请求微信服务器返回数据
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 批量获取微信用户数组，从时间复杂度和空间复杂度上进行优化。
	 * @param array $openidlist 形参传入数组形式的openid
	 * @return array $userinfolist 微信用户信息列表
	 */
	public function batchGetUserInfo($openidlist = NULL) {
		if (empty ( $openidlist )) return false;
		$params ['access_token'] = $this->getToken ();			//获取access_token
		$userinfolist = array (); //用户信息列表
		$usernum = count ( $openidlist );
		for($i = 0; $i < $usernum; $i ++) {
			$params ['openid'] = $openidlist [$i];
			$userinfolist [$i] = json_decode ( http ( self::WECHAT_USER_INFO, $params ), true );
		}
		return $userinfolist;
	}
	
	/**
	 * 获取公众号关注列表，该函数直接可以被类对象调用，获取用户，看实例化的时候传参.
	 * 该接口为GET类型接口，可以一次性读取上万条数据，配合哈希双散列算法，直接对数据库5万量的用户在8秒内同步。
	 * @return array 当前公众号关注者列表
	 * Author：赵臣升
	 */
	public function getAllSubscriber() {
		$params = array ();										//定义发送数据的数组
		$params ['access_token'] = $this->getToken ();			//获取access_token
		$params ['next_openid'] = '';							//下一个用户的openid，如果没有下一个，则为空字符串
		$httpstr = http ( self::PUBLIC_ALL_SUBSCRIBERS, $params ); // 请求微信服务器返回数据
		$harr = json_decode ( $httpstr, true );					//将返回的数据以utf-8格式解码
		while($harr ['next_openid'] != '') {
			$params ['next_openid'] = $harr ['next_openid'];
			$httpstrnext = http ( self::PUBLIC_ALL_SUBSCRIBERS, $params );
			$harrnext = json_decode ( $httpstrnext, true );
			//如果下一个拉取接口得到的data中的openid数组不空，才做出用户openid数组合并
			if ($harrnext ['data'] ['openid']) {
				$harr ['data'] ['openid'] = array_merge ( $harr ['data'] ['openid'], $harrnext ['data'] ['openid'] );
			}
			$harr ['next_openid'] = $harrnext ['next_openid'];
		}
		return $harr;											//返回解码后的数据（应该是数组形式，具体格式参见微信API）
	}
	
	/**
	 * ==========用户管理：补充授权获取用户信息接口部分（该部分在WeChatAuthorize中有）==========
	 */
	
	/**
	 * API 五、订阅、未订阅公众号的用户授权登录后获取用户信息的函数。
	 * Author：赵臣升。
	 * CreateTime：2014/07/05 20:13:25.
	 * @param string $code 形参传入用户授权后获得的code
	 * @param string $state 形参传入用户授权后获得的state（商家或者定义的）
	 * @return array $finaluser 返回从微信请求的数据
	 */
	public function authorize($code='', $state=''){
		//用户同意授权才去换取access_token
	
		//Step1：利用code换取access_token
		header ( "Content-type: text/html; charset=utf-8" );		//定义https请求文件头
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token';	//定义API请求的URL地址（获取access_token的URL）
		$params = array ();											//定义发送数据的数组
		$params ['appid'] = $this->APPID;							//获取当前商家的APPID
		$params ['secret'] = $this->APPSecret;						//获取当前商家的APPSecret
		$params ['code'] = $code;									//下一个用户的openid，如果没有下一个，则为空字符串
		$params ['grant_type'] = 'authorization_code';				//下一个用户的openid，如果没有下一个，则为空字符串
		$httpstr = http ( $url, $params );							//调用Common公有函数中的http()函数请求微信服务器返回数据
		$finaldata = json_decode ( $httpstr, true );				//将返回的数据以utf-8格式解码
		//$finaldata = array( 'access_token' => value1, 'expires_in' => value2, 'refresh_token' => value3, 'openid' => value4, 'scope' => value5 );
	
		//Step2：利用access_token换取用户的信息
		header ( "Content-type: text/html; charset=utf-8" );		//定义https请求文件头
		$url = 'https://api.weixin.qq.com/sns/userinfo';			//定义API请求的URL地址（获取用户数据的URL）
		$parameters = array ();										//定义发送数据的数组
		$parameters ['access_token'] = $finaldata['access_token'];	//获取当前商家的APPID
		$parameters ['openid'] = $finaldata['openid'];				//获取当前商家的APPSecret
		$parameters ['lang'] = 'zh_CN';								//下一个用户的openid，如果没有下一个，则为空字符串
		$httpsstr = http ( $url, $parameters );						//调用Common公有函数中的http()函数请求微信服务器返回数据
		$finaluser = json_decode ( $httpsstr, true );				//将返回的数据以utf-8格式解码
		//$finaluser也是数组
		return $finaluser;
	}
	
	/**
	 * API 五、订阅、未订阅公众号的用户授权登录后获取用户信息的函数。
	 * Author：赵臣升。
	 * CreateTime：2014/07/05 20:13:25.
	 * @param string $code	形参传入用户授权后获得的code
	 * @param string $state	形参传入用户授权后获得的state（商家或者定义的）
	 * @return array $finaluser	返回从微信请求的数据
	 */
	public function baseAuthorize($code='', $state=''){
		//Step1：利用code换取access_token
		header ( "Content-type: text/html; charset=utf-8" );		//定义https请求文件头
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token';	//定义API请求的URL地址（获取access_token的URL）
		$params = array ();											//定义发送数据的数组
		$params ['appid'] = $this->APPID;							//获取当前商家的APPID
		$params ['secret'] = $this->APPSecret;						//获取当前商家的APPSecret
		$params ['code'] = $code;									//下一个用户的openid，如果没有下一个，则为空字符串
		$params ['grant_type'] = 'authorization_code';				//下一个用户的openid，如果没有下一个，则为空字符串
		$httpstr = http ( $url, $params );							//调用Common公有函数中的http()函数请求微信服务器返回数据
		$finaldata = json_decode ( $httpstr, true );				//将返回的数据以utf-8格式解码
		//$finaldata = array( 'access_token' => value1, 'expires_in' => value2, 'refresh_token' => value3, 'openid' => value4, 'scope' => value5 );
	
		return $finaldata;
	}
	
	/**
	 * ==========公众号菜单接口部分==========
	 */
	
	/**
	 * 设置自定义菜单，请把打包解包json统一放在本类中，已调通。
	 * 该接口为POST类型。
	 * @param array $menudata 菜单的数组信息
	 * @return string 返回的结果
	 */
	public function setMenu($menudata = NULL) {
		if (empty ( $menudata )) {
			$this->error = "菜单内容必须要填写。";
			return false;
		}
		$url = self::SET_PUBLIC_MENU . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $menudata ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult; // 返回定制菜单结果
	}
	
	/**
	 * 查询商家自定义菜单，已调通。
	 * 该接口为GET类型接口。
	 * @return array $menu 数组格式的菜单
	 */
	public function queryMenu() {
		$params ['access_token'] = $this->getToken ();				// 获取当前商家的access_token
		$httpresult = http ( self::QUERY_PUBLIC_MENU, $params );	// 调用Common公有函数中的http()函数请求微信服务器返回数据
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 删除商家自定义菜单，已调通。
	 * @return boolean $jsonresult true	删除菜单成功;false 删除菜单失败。
	 */
	public function deleteMenu() {
		$params ['access_token'] = $this->getToken ();				//获取当前商家的access_token
		$httpresult = http ( self::DELETE_PUBLIC_MENU, $params ); // 调用Common公有函数中的http()函数请求微信服务器返回数据
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * ==========账号管理接口部分==========
	 */
	
	/**
	 * 产生二维码的接口，已调通。
	 * 该接口为POST类型。
	 * @param number $param 二维码的scene_id编号
	 * @param boolean $permanent 是否生成永久二维码，默认临时二维码
	 * @param number $expire 二维码时间
	 * @return array $codeinfo 微信服务器返回的请求二维码结果
	 */
	public function generateQRcode($scene_id = 10000, $permanent = FALSE, $expire = 1800) {
		if (empty ( $scene_id ) || ! is_numeric ( $scene_id )) {
			$this->error = '场景值不合法。';
			return false;
		}
		if ($permanent) {
			if ($scene_id > 100000 || $scene_id < 1) {
				$this->error = '永久二维码场景值必须是1-100000之间的整数。';
				return false;
			}
		}
		// 打包二维码信息数组
		$scenedata = array (
				"action_info" => array (
						"scene" => array (
								'scene_id' => $scene_id
						)
				)
		);
		if ($permanent) {
			$scenedata ["action_name"] = "QR_LIMIT_SCENE"; // 永久二维码
		} else {
			$scenedata ["action_name"] = "QR_SCENE"; // 临时二维码
			$scenedata ["expire_seconds"] = $expire; // 临时二维码的有效时间，最长时间30分钟，1800秒
		}
		// 请求二维码
		$url = self::CREATE_QRCODE . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $scenedata ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 新生成二维码的接口，增加了永久二维码可以生成1~64位字符串的情况。
	 * @param string $scene_id 要生成的二维码场景值，永久二维码可以使用字符串；临时二维码必须将该参数转整形。
	 * @param boolean $permanent 是否要生成永久二维码，默认临时二维码
	 * @param number $expire 二维码的有效时间（永久二维码不用传此参数）
	 * @return array $qrcodeinfo 生成二维码的信息
	 */
	public function newGenerateQRCode($scene_id = '', $permanent = FALSE, $expire = 604800) {
		// 定义一些全局变量
		$sceneid = 0; // 临时二维码的场景值（整型）
		$scenestr = ""; // 永久二维码的场景值（字符串）
		$scenedata = array (); // 要生成二维码的参数格式
		
		if ($permanent) {
			// 如果是永久二维码
			$scenestr = $scene_id; // 字符串类型
			if (empty ( $scenestr )) {
				$this->error = '永久二维码场景值不合法，必须为1~64位的字符串。';
				return false;
			}
			// 格式化永久二维码的参数
			$scenedata = array (
					'action_name' => 'QR_LIMIT_STR_SCENE',
					'action_info' => array (
							'scene' => array (
									'scene_str' => $scenestr // 微信平台新允许的字符串参数（2015/04/22）
							),
					),
			);
		} else {
			// 如果是临时二维码
			$sceneid = intval ( $scene_id ); // 转整型
			if (! is_numeric ( $sceneid )) {
				$this->error = '临时二维码场景值不合法，必须为1~32位的整型。';
				return false;
			}
			if ($expire <= 0 || $expire > 604800) {
				$this->error = '临时二维码有效时间不合法，必须为1~604800之间的秒数。';
				return false;
			}
			// 格式化临时二维码的参数
			$scenedata = array (
					'expire_seconds' => $expire,
					'action_name' => 'QR_SCENE',
					'action_info' => array (
							'scene' => array (
									'scene_id' => $sceneid // 原来的临时二维码参数
							),
					),
			);
		}
		
		// 请求二维码
		$url = self::CREATE_QRCODE . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $scenedata ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 下载二维码接口，已调通。
	 * @param string $ticket_id 要下载的二维码ticket_id
	 * @param string $savefinal 最终保存下载二维码图片的路径
	 * @return array $result 返回是否下载成功的信息数组
	 */
	public function downloadQR($ticket_id = '', $savefinalpath = '') {
		$downloadresult = array (
				'errCode' => 10001,
				'errMsg' => "下载图片失败，请稍后再试！"
		); // 默认没下载成功
		
		// 通过ticket下载二维码
		$params ['ticket'] = $ticket_id;							//获取当前要下载的$ticket_id
		$fileInfo = downloadWeixinFile ( self::DOWNLOAD_QRCODE, $params ); // 调用downloadWeixinFile()函数请求微信服务器返回数据
		
		// 微信端文件是否成功返回，如果文件出错
		if (empty ( $fileInfo ['body'] )) {
			// 如果有错误信息
			$downloadresult ['errCode'] = $httpresult ['errcode'];  // 错误码给他
			return $downloadresult; // 返回错误信息
		}
		
		// 如果不出错，尝试下载多媒体文件，并写入本地磁盘文件
		$localFile = fopen ( $savefinalpath, 'w' );					//打开文件流，写文件方式
		if ($localFile !== false) {
			// 如果创建文件成功，则写入文件
			if (fwrite ( $localFile, $fileInfo ['body'] ) !== false) {
				fclose ( $localFile ); // 关闭文件读写流
				// 将成功写入的信息返回
				$downloadresult ['errCode'] = 0;
				$downloadresult ['errMsg'] = "ok";
				$downloadresult ['code_path'] = $savefinalpath;
			}
		}
		return $downloadresult;
	}
	
	/**
	 * 长链接转短链接接口，已调通。
	 * 该接口为POST类型。
	 * @param string $longurl 链接信息数组。
	 * @return array $shorturl 经过json解码后的数组。
	 */
	public function getShortURL($longurl = '') {
		if (empty ( $longurl )) {
			$this->error = "要转换的长链接信息不能为空。";
			return false;
		}
		// 准备转换参数
		$params = array (
				'action' => 'long2short', // 长链接转换短链接
				'long_url' => $longurl
		);
		$url = self::LONG_URL_TO_SHORT . "?access_token=" . $this->getToken (); // 拼接发送信息API的URL请求地址
		$jsoninfo = jsencode ( $params ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$shorturl = json_decode ( $httpresult, true ); // utf-8解码
		if ($shorturl ['errcode'] == 0) {
			return $shorturl ['short_url'];
		} else {
			return false;
		}
	}
	
	/**
	 * ==========微信多客服接口部分==========
	 */
	
	/**
	 * 获取公众号在线客服列表，已调通。
	 * @return array $kflist 客服信息数组，参见微信API文档。
	 */
	public function getOnlineServiceList() {
		$params ['access_token'] = $this->getToken ();				// 获取当前商家的access_token
		$httpresult = http ( self::CUSTOMER_SERVICE_LIST, $params );	// 调用Common公有函数中的http()函数请求微信服务器返回数据
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 获取公众号在线客服的状态（服务了多少个客户），已调通。
	 * 若返回结果kf_online_list数组为空，则代表没有客服在线。
	 * @return array kefuonlinelist 在线客服状态等信息
	 */
	public function getOnlineServiceStatus() {
		$params ['access_token'] = $this->getToken ();				// 获取当前商家的access_token
		$httpresult = http ( self::CUSTOMER_SERVICE_STATUS, $params );	// 调用Common公有函数中的http()函数请求微信服务器返回数据
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 为公众号添加客服账号接口，POST类型，已调通。
	 * @param array $accountinfo 客服账号信息数组
	 * @property string kf_account 客服人员登录的账号
	 * @property string nickname 客服的昵称信息
	 * @property string password 客服人员登录的密码，必须是经过md5函数加密后的密码，不能是明文
	 * @return array $jsonresult 添加客服账号结果
	 */
	public function addOnlineServiceAccount($accountinfo = NULL) {
		$url = self::ADD_CUSTOMER_SERVICE . "?access_token=" . $this->getToken ();
		$jsoninfo = jsencode ( $accountinfo ); // 不转义json压缩组信息
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 设置客服信息,账号不能更改，昵称，密码可以改，POST类型接口，已调通。
	 * @param array $modifyinfo 要修改的账号信息
	 * @property string kf_account 要修改的账号
	 * @property string nickname 要修改的客服昵称
	 * @property string password 要修改的客服密码
	 * @return boolean $jsonresult 修改客服信息是否成功
	 */
	public function modifyOnlineServiceInfo($modifyinfo = NULL) {
		$url = self::MODIFY_CUSTOMER_SERVICE_INFO . "?access_token=" . $this->getToken (); // POST的URL地址
		$jsoninfo = jsencode ( $modifyinfo );
		$httpresult = http ( $url, $jsoninfo, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 上传客服头像，该接口为media类型POST接口，已调通，但要使用必须api授权（开放平台）。
	 * @param string $mediapath 客服的头像jpg图片绝对路径。
	 */
	public function uploadOnlineServiceAvatar($account = '', $mediapath = '') {
		$url = self::UPLOAD_CUSTOMER_SERVICE_AVATAR . "?access_token=" . $this->getToken () . "&kf_account=" . $account; // 修改客服头像的POST地址
		$filedata ['media'] = '@' . $mediapath; // 多媒体文件的绝对路径
		$httpresult = http ( $url, $filedata, 'POST', $this->header, true ); // 发送给微信服务器
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * 公众号删除客服账号接口，特别注意该接口是GET，已调通，但是请注意@符号的转义。
	 * @param string $account 要删除的账号
	 * @return array $jsonresult 删除线上账号的结果
	 */
	public function deleteOnlineServiceAccount($account = '') {
		if (empty ( $account )) {
			$this->error = "请指定一个要删除的客服账号。";
			return false;
		}
		$params = array (
				'access_token' => $this->getToken (),
				'kf_account' => $account
		);
		$httpresult = http ( self::DELETE_CUSTOMER_SERVICE, $params );
		$jsonresult = $this->parseJson ( $httpresult ); // 解析json信息
		return $jsonresult;
	}
	
	/**
	 * ==========微信接口调用后的一些处理==========
	 * 以下部分封装微信接口调用完的一些处理。
	 */
	
	/**
	 * 返回微信接口调用操作结果。
	 * @return array $result 微信接口操作结果（非信息类）
	 */
	public function getResult() {
		return $this->result;
	}
	
	/**
	 * 转换微信全局返回错误码信息函数。
	 * @param number $code 错误码编号
	 * @return string 错误信息
	 */
	private function transformErrorCode($code = 0) {
		switch ($code) {
			// AESKey加密部分
			case -40001 : return '校验签名失败';
			case -40002 : return '解析xml失败';
			case -40003 : return '计算签名失败';
			case -40004 : return '不合法的AESKey';
			case -40005 : return '校验AppID失败';
			case -40006 : return 'AES加密失败';
			case -40007 : return 'AES解密失败';
			case -40008 : return '公众平台发送的xml不合法';
			case -40009 : return 'Base64编码失败';
			case -40010 : return 'Base64解码失败';
			case -40011 : return '公众帐号生成回包xml失败';
			// 常用部分
			case -1    : return '系统繁忙 ';
			case 0     : return "ok";
			case 40001 : return '获取access_token时AppSecret错误，或者access_token无效';
			case 40002 : return '不合法的凭证类型';
			case 40003 : return '不合法的OpenID';
			case 40004 : return '不合法的媒体文件类型';
			case 40005 : return '不合法的文件类型';
			case 40006 : return '不合法的文件大小';
			case 40007 : return '不合法的媒体文件id';
			case 40008 : return '不合法的消息类型 ';
			case 40009 : return '不合法的图片文件大小';
			case 40010 : return '不合法的语音文件大小';
			case 40011 : return '不合法的视频文件大小';
			case 40012 : return '不合法的缩略图文件大小';
			case 40013 : return '不合法的APPID';
			case 40014 : return '不合法的access_token ';
			case 40015 : return '不合法的菜单类型';
			case 40016 : return '不合法的按钮尺寸';
			case 40017 : return '不合法的按钮个数';
			case 40018 : return '不合法的按钮名字长度';
			case 40019 : return '不合法的按钮KEY长度';
			case 40020 : return '不合法的按钮URL长度';
			case 40021 : return '不合法的菜单版本号';
			case 40022 : return '不合法的子菜单级数';
			case 40023 : return '不合法的子菜单按钮个数';
			case 40024 : return '不合法的子菜单按钮类型';
			case 40025 : return '不合法的子菜单按钮名字长度';
			case 40026 : return '不合法的子菜单按钮KEY长度 ';
			case 40027 : return '不合法的子菜单按钮URL长度 ';
			case 40028 : return '不合法的自定义菜单使用用户';
			case 40029 : return '不合法的oauth_code';
			case 40030 : return '不合法的refresh_token';
			case 40031 : return '不合法的openid列表 ';
			case 40032 : return '不合法的openid列表长度 ';
			case 40033 : return '不合法的请求字符，不能包含\uxxxx格式的字符 ';
			case 40035 : return '不合法的参数';
			case 40038 : return '不合法的请求格式';
			case 40039 : return '不合法的URL长度 ';
			case 40050 : return '不合法的分组id';
			case 40051 : return '分组名字不合法';
			case 40054 : return '子菜单的URL地址域名不能是mp微信图文详情页';
			case 41001 : return '缺少access_token参数';
			case 41002 : return '缺少appid参数';
			case 41003 : return '缺少refresh_token参数';
			case 41004 : return '缺少secret参数';
			case 41005 : return '缺少多媒体文件数据';
			case 41006 : return '缺少media_id参数';
			case 41007 : return '缺少子菜单数据';
			case 41008 : return '缺少oauth code';
			case 41009 : return '缺少openid';
			case 42001 : return 'access_token超时';
			case 42002 : return 'refresh_token超时';
			case 42003 : return 'oauth_code超时';
			case 43001 : return '需要GET请求';
			case 43002 : return '需要POST请求';
			case 43003 : return '需要HTTPS请求';
			case 43004 : return '需要接收者关注';
			case 43005 : return '需要好友关系';
			case 44001 : return '多媒体文件为空';
			case 44002 : return 'POST的数据包为空';
			case 44003 : return '图文消息内容为空';
			case 44004 : return '文本消息内容为空';
			case 45001 : return '多媒体文件大小超过限制';
			case 45002 : return '消息内容超过限制';
			case 45003 : return '标题字段超过限制';
			case 45004 : return '描述字段超过限制';
			case 45005 : return '链接字段超过限制';
			case 45006 : return '图片链接字段超过限制';
			case 45007 : return '语音播放时间超过限制';
			case 45008 : return '图文消息超过限制';
			case 45009 : return '接口调用超过限制';
			case 45010 : return '创建菜单个数超过限制';
			case 45015 : return '回复时间超过限制';
			case 45016 : return '系统分组，不允许修改';
			case 45017 : return '分组名字过长';
			case 45018 : return '分组数量超过上限';
			case 46001 : return '不存在媒体数据';
			case 46002 : return '不存在的菜单版本';
			case 46003 : return '不存在的菜单数据';
			case 46004 : return '不存在的用户';
			case 47001 : return '解析JSON/XML内容错误';
			case 48001 : return 'api功能未授权';
			case 50001 : return '用户未授权该api';
			// 客服管理接口返回码
			case 61451 : return '参数错误(invalid parameter)';
			case 61452 : return '无效客服账号(invalid kf_account)';
			case 61453 : return '账号已存在(kf_account exsited)';
			case 61454 : return '账号名长度超过限制(前缀10个英文字符)(invalid kf_acount length)';
			case 61455 : return '账号名包含非法字符(英文+数字)(illegal character in kf_account)';
			case 61456 : return '账号个数超过限制(10个客服账号)(kf_account count exceeded)';
			case 61457 : return '无效头像文件类型(invalid file type)';
			// 2015/04开放接口（摇周边）
			case 61450 : return '系统错误(system error)';
			case 61500 : return '日期格式错误';
			case 61501 : return '日期范围错误';
			case 9001001 : return 'POST数据参数不合法';
			case 9001002 : return '远端服务不可用';
			case 9001003 : return 'Ticket不合法';
			case 9001004 : return '获取摇周边用户信息失败';
			case 9001005 : return '获取商户信息失败';
			case 9001006 : return '获取OpenID失败';
			case 9001007 : return '上传文件缺失';
			case 9001008 : return '上传素材的文件类型不合法';
			case 9001009 : return '上传素材的文件尺寸不合法';
			case 9001010 : return '上传失败';
			case 9001020 : return '帐号不合法';
			case 9001021 : return '已有设备激活率低于50%，不能新增设备';
			case 9001022 : return '设备申请数不合法，必须为大于0的数字';
			case 9001023 : return '已存在审核中的设备ID申请';
			case 9001024 : return '一次查询设备ID数量不能超过50';
			case 9001025 : return '设备ID不合法';
			case 9001026 : return '页面ID不合法';
			case 9001027 : return '页面参数不合法';
			case 9001028 : return '一次删除页面ID数量不能超过10';
			case 9001029 : return '页面已应用在设备中，请先解除应用关系再删除';
			case 9001030 : return '一次查询页面ID数量不能超过50';
			case 9001031 : return '时间区间不合法';
			case 9001032 : return '保存设备与页面的绑定关系参数错误';
			case 9001033 : return '门店ID不合法';
			case 9001034 : return '设备备注信息过长';
			case 9001035 : return '设备申请参数不合法';
			case 9001036 : return '查询起始值begin不合法';
			// 其他
			default    : return '未知错误';
		}
	}
	
	/**
	 * 获取微信接口错误信息。
	 * @return string $error 微信接口错误信息
	 */
	public function getError() {
		return $this->error;
	}
	
	/**
	 * ==========本类工具函数区域==========
	 * 以下部分封装一些开发需要用到的工具类、转换函数。
	 */
	
	/**
	 * 工具函数：XML文档解析成数组，并将键值转成小写
	 * @param xml $xml
	 * @return array
	 */
	private function extractXml($xml) {
		$data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		//return array_change_key_case($data, CASE_LOWER);
		return $data;
	}
	
	/**
	 * 工具函数：将数组打包成xml格式返回给微信。
	 * 该工具函数以前放在微信send发送消息里
	 * @param array $array 要打包成xml格式的二维数组
	 * @return xml $xml 打包成xml格式的信息
	 */
	private function array2Xml($array) {
		$xml  = new SimpleXMLElement('<xml></xml>');
		$this->data2xml($xml, $array);
		return $xml->asXML();
	}
	
	/**
	 * 将数据用XML格式编码 dataToxml → data2xml
	 * @param  object $xml XML对象
	 * @param  mixed  $data 数据
	 * @param  string $item 数字索引时的节点名称
	 * @return string
	 */
	private function data2xml($xml, $data, $item = 'item') {
		foreach ($data as $key => $value) {
			/* 指定默认的数字key */
			is_numeric($key) && $key = $item;
	
			/* 添加子元素 */
			if(is_array($value) || is_object($value)){
				$child = $xml->addChild($key);
				$this->data2xml($child, $value, $item);
			} else {
				if(is_numeric($value)){
					$child = $xml->addChild($key, $value);
				} else {
					$child = $xml->addChild($key);
					$node  = dom_import_simplexml($child);
					$node->appendChild($node->ownerDocument->createCDATASection($value));
				}
			}
		}
	}
	
	/**
	 * AES 解密方法
	 * @param  string $encrypted 加密后的字符串
	 * @return xml|boolean
	 */
	public function AESdecode($encrypted) {
		$key            = base64_decode($this->AESKey . "=");
		// 使用BASE64对需要解密的字符串进行解码
		$ciphertext_dec = base64_decode($encrypted);
		$module         = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
		$iv             = substr($key, 0, 16);
		mcrypt_generic_init($module, $key, $iv);
		// 解密
		$decrypted      = mdecrypt_generic($module, $ciphertext_dec);
		mcrypt_generic_deinit($module);
		mcrypt_module_close($module);
		// 去除补位字符
		$pad = ord(substr($decrypted, -1));
		if ($pad < 1 || $pad > 32) {
			$pad = 0;
		}
		$result = substr($decrypted, 0, (strlen($decrypted) - $pad));
		// 去除16位随机字符串,网络字节序和AppId
		if (strlen($result) < 16) {
			$this->error = 'AESdecode Result Length Error';
			return false;
		}
		$content     = substr($result, 16);
		$len_list    = unpack("N", substr($content, 0, 4));
		$xml_len     = $len_list[1];
		$xml_content = substr($content, 4, $xml_len);
		$from_appid  = substr($content, $xml_len + 4);
		if ($from_appid != $this->appid) {
			$this->error = 'AESdecode AppId Error';
			return false;
		} else {
			return self::extractXml($xml_content);
		}
	}
	
	/**
	 * AES 加密方法
	 * @param  string $text 需要加密的字符串
	 * @return boolean
	 */
	public function AESencode($text) {
		$key    = base64_decode($this->AESKey . "=");
		$random = self::getRandomStr();
		$text   = $random . pack("N", strlen($text)) . $text . $this->appid;
		// 下面函数好像无法执行，必须。。。做两个步骤。
		$size   = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
		$iv     = substr($key, 0, 16);
		// 使用自定义的填充方式对明文进行补位填充
		$text_length = strlen($text);
		//计算需要填充的位数
		$amount_to_pad = 32 - ($text_length % 32);
		if ($amount_to_pad == 0) {
			$amount_to_pad = 32;
		}
		//获得补位所用的字符
		$pad_chr = chr($amount_to_pad);
		$tmp = "";
		for ($index = 0; $index < $amount_to_pad; $index++) {
			$tmp .= $pad_chr;
		}
		$text = $text . $tmp;
		mcrypt_generic_init($module, $key, $iv);
		// 加密
		$encrypted = mcrypt_generic($module, $text);
		mcrypt_generic_deinit($module);
		mcrypt_module_close($module);
		// 使用BASE64对加密后的字符串进行编码
		return base64_encode($encrypted);
	}
	
	/**
	 * 返回随机填充的字符串。
	 */
	private function getRandomStr($lenght = 16)	{
		$str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		return substr ( str_shuffle ( $str_pol ), 0, $lenght );
	}
	
	/**
	 * 对数据进行SHA1签名
	 */
	public function getSHA1($encrypt_msg, $nonce = '') {
		$array = array ( $encrypt_msg, $this->developertoken, NOW_TIME, $nonce );
		sort ( $array, SORT_STRING );
		$str = implode ( $array );
		return sha1 ( $str );
	}
	
	/**
	 * 解析JSON编码，如果有错误，则返回错误并设置错误信息
	 * @param json $json json数据
	 * @return array
	 */
	private function parseJson($json) {
		$jsonArr = json_decode ( $json, true ); // 标准utf-8格式解码json
		if (isset ( $jsonArr ['errcode'] )) {
			if ($jsonArr ['errcode'] == 0) {
				$this->result = $jsonArr; // 想看操作结果可以调用getResult
				return true;
			} else {
				$this->error = $this->transformErrorCode ( $jsonArr ['errcode'] ); // 想看错误信息可以调用getError
				return false;
			}
		} else {
			return $jsonArr;
		}
	}
	
	/**
	 * _json_encode函数，不转义中文字符和\/的 json 编码方法，不太推荐用，本平台用jsencode就不转义。
	 * @param array $array
	 * @return json
	 */
	private function _json_encode($array = array()) {
		$array = str_replace ( "\\/", "/", json_encode ( $array ) );
		$search = '#\\\u([0-9a-f]+)#ie';
		if (strpos ( strtoupper ( PHP_OS ), 'WIN' ) === false) {
			$replace = "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))"; // LINUX
		} else {
			$replace = "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))"; // WINDOWS
		}
		return preg_replace ( $search, $replace, $array );
	}
	
}
?>
