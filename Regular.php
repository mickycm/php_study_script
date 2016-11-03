<?php

namespace app\addon;

/**
 * 正则表达式专用类
 *
 * @author ly-chengminbin
 *        
 */
class Regular {
	
	// 手机号
	public static $REGEX_PHONE = '/^1[\d]{10}$/';
	
	// 身份证号
	public static $REGEX_ID_CARD = ' /^(\d{15}|\d{17}[0-9Xx])$/';
	
	// 验证租赁合同号 15位整数
	public static $REGEX_CONTRACT_NUM = '/^[\d]{15}';
	
	// 验证由中文或英文 组成的用户名 2-25位
	public static $REGEX_USER_NAME = '/^([a-zA-Z]{2,25}|[\x{4e00}-\x{9fa5}]{1,25})$/u';
	
	//验证英文 数字 下划线组成用户名  英文开头
	public static $REGEX_LOGIN_NAME = '/^([a-zA-Z]+[a-zA-Z0-9_]*){2,30}$/';
	
	// 验证由中英文数字混合组成的昵称
	public static $REGEX_NICK_NAME = '/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]{1,25}$/u';
	// 验证 4位数字的 验证码
	public static $REGEX_VCODE = '/^[\d]{4}$/';
	
	// 验证 邮箱 格式
	public static $REGEX_EMAIL = '/\w[-\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/';
	
	// 验证 userid
	public static $REGEX_USER_ID = '/^[-\w]{20,40}$/';
	
	//验证密码 强度 8位以上
	public static $REGEX_PASS = '/^(?![^a-zA-Z]+$)(?!\D+$)(?![\sa-zA-Z0-9]+$).{8,}$/';
	
	//菜单url  # 或 字母开头中间可以有 "/" 
	public static $REGEX_MENU_URL = '/^(#|\/[a-zA-Z\/]+#?[a-zA-Z]*)$/';
	
	// 验证由中英文混合组成的菜单名称
	public static $REGEX_MENU_NAME = '/^[a-zA-Z\x{4e00}-\x{9fa5}]{1,25}$/u';
	
	//验证菜单编码
	public static $MENU_CODE = '/^([a-zA-Z][a-zA-Z_\-]*[a-zA-Z]+){1,45}$/';
	//验证菜单 target id
	public static $TARGET_ID = '/^#[a-zA-Z][a-zA-Z0-9]*$/';
	/**
	 * 验证菜单 TARGET ID
	 * #fadsfs  这样的形式
	 * @param string $targetid
	 * @return boolean
	 */
	public static function checkMenuTargetid($targetid = ''){
	    if(preg_match(self::$TARGET_ID,$targetid)) return true;
	    return false;
	}
	/**
	 * 验证菜单编码
	 * 字母_-  组成，必须以字母开头
	 * @param string $menucode
	 */
	public static function checkMenuCode($menucode = ''){
	    if(preg_match(self::$MENU_CODE, $menucode)) return true;
	    return false;
	}
	/**
	 * 验证菜单名称
	 * @param string $menuname
	 * @return boolean
	 */
	public static function checkMenuName($menuname = ''){
	    if(preg_match(self::$REGEX_MENU_NAME, $menuname)) return true;
	    return false;
	}
	/**
	 * 验证菜单编码
	 */
	public static function checkMenuurl($menuurl = ''){
	    if(preg_match(self::$REGEX_MENU_URL,$menuurl)) return true;
	    return false;
	}
	/**
	 * 验证用户登录名
	 */
	public static function checkLoginName($name = ''){
	    $pattern = self::$REGEX_LOGIN_NAME;
	    if(preg_match($pattern,$name)) return true;
	    return false;
	}
	/**
	 * 验证密码强度
	 * @param string $pass
	 * @return boolean
	 */
    public static function checkPass($pass = ''){
        $pattern = self::$REGEX_PASS;
        if(!preg_match($pattern, $pass))return false;
        return true;
    }
	/**
	 * 验证用户USERID是否正确
	 *
	 * @param string $userid
	 * @return boolean
	 */
	static public function checkUserId($userid = '') {
	    $pattern = self::$REGEX_USER_ID;
	    if (! preg_match ( $pattern, $userid )) {
	        return false;
	    }
	    return true;
	}	
	/**
	 * 验证用户名是否正确
	 *
	 * @param string $user_name        	
	 * @return boolean
	 */
	static public function checkUserName($user_name = '') {
		$pattern = self::$REGEX_USER_NAME;
		if (! preg_match ( $pattern, $user_name )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 验证用户昵称是否正确
	 *
	 * @param string $user_name
	 * @return boolean
	 */
	static public function checkNickName($nick_name = '') {
	    $pattern = self::$REGEX_NICK_NAME;
	    if (! preg_match ( $pattern, $nick_name )) {
	        return false;
	    }
	    return true;
	}	
	
	/**
	 * 验证手机号是否正确
	 *
	 * @param string $phone_no        	
	 * @return boolean
	 */
	static public function checkPhone($phone_no = '') {
		$pattern = self::$REGEX_PHONE;
		if (! preg_match ( $pattern, $phone_no )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 验证用户身份号是否正确
	 *
	 * @param string $id_card        	
	 * @return boolean
	 */
	static public function checkUserIdCard($id_card = '') {
		$pattern = self::$REGEX_ID_CARD;
		if (! preg_match ( $pattern, $id_card )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 验证验证码是否正确
	 *
	 * @param string $vcode        	
	 * @return boolean
	 */
	static public function checkVerifyCode($vcode = '') {
		$pattern = self::$REGEX_VCODE;
		if (! preg_match ( $pattern, $vcode )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 验证EMAIL 是否正确
	 * 
	 * @param string $email        	
	 * @return boolean
	 */
	static public function checkEmail($email = '') {
		$pattern = self::$REGEX_EMAIL;
		if (! preg_match ( $pattern, $email )) {
			return false;
		}
		return true;
	}
}