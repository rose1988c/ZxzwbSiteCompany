<?php
class Html {
	
	public static function tracktime($tracker) {
		
		if($tracker->track_status == TRACK_STATUS_CANCEL)
			return '<span class="f-Cred">已退订</span>';
		 
	    $ts1 = $tracker->expired_at;
        if (!ctype_digit($ts1))
            $ts1 = strtotime($ts1);
            
        $diff = $ts1 - strtotime(date("Y-m-d", time()));
        
        if ($diff > 0) {
            $day_diff = floor($diff / 86400); 
            if ($day_diff == 0) {
            	return '<span class="f-Cred">1天</span>';
            } else if($day_diff <= 10) {
                return '<span class="f-Cred">' . $day_diff . '天</span>';
            }
            return $day_diff. '天';
        }
        return '<span class="f-Cred">已过期</span>';
    }
    
    public static function count_trackers_time($tracker) {
        
        $common_action = '<a href="javascript:void(0);" id="expire_track" rel="' . $tracker->tracker_id .  '">立即续订</a>';
        
        if($tracker->track_status == TRACK_STATUS_CANCEL)
            return '已退订，' . $common_action;
         
        $ts1 = $tracker->expired_at;
        if (!ctype_digit($ts1))
            $ts1 = strtotime($ts1);
            
        $diff = $ts1 - strtotime(date("Y-m-d", time()));
        
        if ($diff > 0) {
            $day_diff = floor($diff / 86400); 
            if ($day_diff == 0) {
                return '还剩 1 天， ' . $common_action;
            } else if($day_diff <= 10) {
                return '还剩 ' . $day_diff . ' 天， ' . $common_action;
            }
            return '还剩' . $day_diff. ' 天';
        }
        return '已过期， ' . $common_action;
    }
    
    public static function format_week($week) {
         $WEEK_ARRAY = array(
        	0 => '日',
        	1 => '一',
        	2 => '二',
        	3 => '三',
        	4 => '四',
        	5 => '五',
        	6 => '六',
        );
        
        return $WEEK_ARRAY[$week];
    }
    
    public static function format_exchange($pay, $exchange = false) {
    	_require(DOC_ROOT . '/lib/services/user_pay.php');
    	$pay = $pay/PAY_EXCHANGE;
    	
    	if($exchange) {
    		$pay = floor($pay/PAY_EXCHANGE) * PAY_EXCHANGE;
    	}
    	
    	return $pay;
    }
    
	public static function select_blog_categories($id, $name, $categories, $checked = null, $default_value = false ,$className = null, $style = null) {
		
        $output = '<select id="' . $id .'" name="' . $name . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        if(!is_null($style)) {
            $output .= ' style="' . $style . '"';
        }
        $output .= '>';
		
        if($default_value != false) {
            $output .= '<option value="0">' . $default_value . '</option>';
        }
        
        foreach($categories as $category) {
            $output .= '<option value="' . $category->category_id . '"';
            if(!is_null($checked) && $checked == $category->category_id) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $category->category_name;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_gender($id, $checked = null,$className = null) {

		$output = '<select id="' . $id .'" name="' . $id . '"';
		if(!is_null($className)) {
			$output .= ' class="' . $className . '"';
		}
		$output .= '>';
			
		foreach(BaseUtils::$PROFILE_GENDER as $key => $value) {
			$output .= '<option value="' . $key . '"';
			if(!is_null($checked) && $checked == $key) {
				$output .=  ' selected="selected"';
			}
			$output .= '>';
			$output .= $value;
			$output .= '</option>';
		}
			
		$output .= '</select>';

		return $output;
	}
	
    public static function select_group_level($id, $commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$GROUP_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->group_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_legend_level($id, $commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(LegendUtils::$LEGEND_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->legend_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function label_legend_fee_type($require_scores, $fee_type, $class = false) {

        _require(DOC_ROOT . '/lib/services/user_stock_legend.php');
        $output = '';
        if($fee_type == USER_STOCK_LEGEND_FEE_TYPE_SCORE) {
            $output = $require_scores . ' 积分';
            if($class) {
                $output = "<span class=\"f-18px-bold f-Cf63\" style=\"color:red;font-size:22px;\">{$require_scores}</span><span class=\"f-C333\"  style=\"color:red;\">  积分</span>";
            }
        } else if($fee_type == USER_STOCK_LEGEND_FEE_TYPE_MPAY) {
            $output = $require_scores . ' 魔方宝';
            if($class) {
                $output = "<span class=\"f-18px-bold f-Cf63\"  style=\"color:red;font-size:22px;\">{$require_scores}</span><span class=\"f-C333\"  style=\"color:red;\">  魔方宝</span>";
            }
        }
        
        return $output;
    }
    
    public static function label_legend_fee_type_cards($require_cards, $class = false) {

        _require(DOC_ROOT . '/lib/services/user_stock_legend.php');
        $output = $require_cards . ' 牛股查看卡';
        if($class) {
            $output = "<span class=\"f-18px-bold f-Cf63\" style=\"color:red;font-size:22px;\">{$require_cards}</span><span class=\"f-C333\"  style=\"color:red;\">  牛股查看卡</span>";
        }
        
        return $output;
    }

    public static function select_stock_level($id, $commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(StockUtils::$STOCK_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->symbol_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }

    public static function select_match_topic_level($id, $topic = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$GROUP_TOPIC_MATCH_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($topic !== false && $topic->topic_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    
    public static function select_suggest_status_level($id, $suggest = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(SuggestStatusUtils::$SUGGEST_STATUS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(($suggest !== false && !is_object($suggest) && $suggest == $key) 
              || (is_object($suggest) && $suggest->status == $key)) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function label_suggest_status_type($suggest) {
        $status = is_object($suggest) ? $suggest->status : $suggest;
        
        $array_status = SuggestStatusUtils::$SUGGEST_STATUS;
        
        if(!is_null($status) && $status >= 0) {
            if(array_key_exists("${status}", $array_status)) {
               $output = '<span style="color:#c80000;">' . $array_status[$status] . '</span> ';
            }
        }
        
        return $output;
        
    }
    
    public static function select_user_level($id, $user_level = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($user_level !== false && $user_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_group_chat_level($id, $chat_commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$GROUP_CHAT_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($chat_commend !== false && $chat_commend->chat_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_analytic_app_level($id, $app_commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(AnalyticAppUtils::$USER_ANALYTIC_APP_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($app_commend !== false && $app_commend->app_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_stock_news_level($id, $stock_news_commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(StockNewsUtils::$STOCK_NEWS_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($stock_news_commend !== false && $stock_news_commend->news_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_stock_block($id, $stock = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(StockUtils::$STOCK_BLOCK as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($stock !== false && $stock->stock_block == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_stock_type($id, $stock = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(StockUtils::$STOCK_TYPES as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($stock !== false && $stock->stock_type == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_stock_industry($id, $stock = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(StockUtils::$STOCK_INDUSTRIES as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($stock !== false && $stock->industry == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_blog_level($id, $commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_BLOG_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->blog_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_common_level($id, $level = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_BLOG_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($level !== false && $level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    /*
     * 名人首页推荐
     */
    public  static  function select_mingren_level ($id, $commend = false , $className = false ){
    	$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_MINGREN_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    
    public static function select_user_commend_level($id, $user_commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_MINGREN_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($user_commend !== false && $user_commend->user_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function select_group_user_level($id, $user_commend = false, $className = null) {

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$GROUP_USER_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($user_commend !== false && $user_commend->group_user_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
	 
    public static function select_role($id, $role = USER_CS, $checked = null,$className = null) {
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        
        $userroles = is_array($role) ? $role : explode(',', $role);
        $checked = is_array($checked) ? $checked : explode(',', $checked);
        
        $isvip = UserRolesUtils::is_vip_card($checked) ? ',vip' : '';
        
        $roles = array(
        	USER_UNVERIFIY		=> '未审核', 
        	USER_OK			 	=> '普通用户', 
			USER_ACE         	=> '炒股高手', 
			USER_ADVISER     	=> '投资顾问', 
			USER_ANALYST     	=> '证券分析师',
        	USER_DISABLED 		=> '已锁定', 
        	USER_MINGREN		=> '名人堂高手');
        
        foreach ($userroles as $userrole) {
            switch ($userrole){
            	case USER_ADMIN :
            		$roles = array_merge($roles, array(USER_CS => '客服', USER_MANAGER => '网站管理员', USER_VIP => 'VIP会员'));
            		break;
                case USER_MANAGER :
                    $roles = array_merge($roles, array(USER_CS => '客服', USER_VIP => 'VIP会员'));
                    break;
            }
        }
        
        
	    foreach($roles as $key => $value) {
            $output .= '<option value="' . $key . $isvip. '"';
            if(!is_null($checked) && in_array($key, $checked)) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
        
        $output .= '</select>';

        return $output;
	}
	
	public static function select_user_category($id, $checked = null,$className = null) {
		_require(DOC_ROOT . '/lib/services/user_category.php');
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        
        $categories = array(
        	USER_CATEGORY_ORDINARY			=> '普通用户', 
        	USER_CATEGORY_KEY_MAINTENANCE	=> '重点维护', 
			USER_CATEGORY_CUBE_STAFF        => '魔方人员', 
			USER_CATEGORY_TRANSACTION_USER  => '异动用户'
		);
        
	    foreach($categories as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
        
        $output .= '</select>';

        return $output;
	}
	
	public static function select_verify_join($id, $checked = null, $className = null) {
		$VERIFY_JOIN = array(
            VERIFY_JOIN_NOTSET   => '未审核',
            VERIFY_JOIN_OK       => '普通圈子',
            VERIFY_JOIN_VIP      => 'VIP圈子',
            VERIFY_JOIN_BLACK    => '已注销',
        );
        
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($VERIFY_JOIN as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
	}
	
    public static function select_suggest_type($id, $checked = null, $className = null) {
        
        $SUGGEST_TYPE = array(
            SUGGEST_TYPE_BUG   => 'bug反馈、错误报告',
            SUGGEST_TYPE_SUGGEST   => '网站改进建议', 
            SUGGEST_TYPE_FEEDBACK  => '问题反馈', 
            SUGGEST_TYPE_OTHERS  => '其他', 
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($SUGGEST_TYPE as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
    }
    
	public static function select_category_type($id, $checked = null, $className = null) {
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$CATEGORY_TYPE as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
	}
	
	public static function select_blog_verify($id, $checked = null, $className = null) {
		
        $BLOG_VERIFY = array(
            //BLOG_VERIFY_NOTSET   => '未审核',
            BLOG_VERIFY_NOAUDIT   => '未通过', 
            BLOG_VERIFY_AUDIT   => '已通过', 
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($BLOG_VERIFY as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_match_player_verify($id, $checked = null, $className = null) {
		
        $MATCH_PLAYER_VERIFY = array(
            MATCH_PLAYER_VERIFY_NOAUDIT  => '未通过', 
            MATCH_PLAYER_VERIFY_AUDIT  	 => '已通过', 
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($MATCH_PLAYER_VERIFY as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_match_award_category($id, $checked = null, $className = null) {
		
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(MatchUtils::$MATCH_AWARD_CATEGORY as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_match_award_status($id, $checked = null, $className = null) {
		
        $MATCH_AWARD_STATUS = array(
            MATCH_AWARD_STATUS_NOTSET  	=> '未发送', 
            MATCH_AWARD_STATUS_APPLY  	=> '已申请',
            MATCH_AWARD_STATUS_OVER  	=> '已审核',
            MATCH_AWARD_STATUS_BACK 	=> '已拒绝',
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($MATCH_AWARD_STATUS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function new_select_match_award_status($id, $checked = null, $className = null) {
		
        $MATCH_AWARD_STATUS = array(
            MATCH_AWARD_STATUS_NOTSET  	=> '未发送', 
            //MATCH_AWARD_STATUS_APPLY  	=> '已申请',
            MATCH_AWARD_STATUS_OVER  	=> '已发送',
            //MATCH_AWARD_STATUS_BACK 	=> '已拒绝',
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($MATCH_AWARD_STATUS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_match_topic_type($id, $checked = null, $className = null) {
		
        $MATCH_TOPIC_TYPE = array( 
            MATCH_TOPIC_TYPE_NOTCIE => '公告',
            MATCH_TOPIC_TYPE_HELP  	=> '帮助',
        );
        
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach($MATCH_TOPIC_TYPE as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function match_group_name( $match_group )
	{
		if( $match_group != false )
		{
			return $match_group->group_name;
		}
		return '--';
	}
	
	public static function select_match_groups($match_id, $id, $checked = null, $className = null) {
        _require(DOC_ROOT . '/lib/services/match_groups.php');
        $match_groups = mcc_get_match_groups(array('match_id'=>$match_id), false, false);
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        $output .= '<option value="">所有</option>';
        if( is_array($match_groups) )
        {
	        foreach($match_groups as $key => $match_group) {
	            $output .= '<option value="' . $match_group->group_id . '"';
	            if(!is_null($checked) && $checked == $match_group->group_id) {
	                $output .=  ' selected="selected"';
	            }
	            $output .= '>';
	            $output .= $match_group->group_name;
	            $output .= '</option>';
        }
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function label_stock_news_type($stock_news) {
	    $type = is_object($stock_news) ? $stock_news->news_type : $stock_news;
	    
	    $stock_news_types = array(
	       NEWS_TYPE_STOCK     => '个股新闻',
	       NEWS_TYPE_COMPANY   => '股市新闻',
	       NEWS_TYPE_HOT       => '热点解析',
	    );
	    
	    if(!is_null($type) && $type > 0) {
	        if(array_key_exists("${type}", $stock_news_types)) {
	           $output = '[' . $stock_news_types[$type] . '] ';
	        }
	    }
	    
	    return $output;
	    
	}
	
	public static function label_verify_join($verify_join) {
    	
        $VERIFY_JOIN = array(
            VERIFY_JOIN_NOTSET   => '未审核',
            VERIFY_JOIN_OK       => '普通圈子',
            VERIFY_JOIN_VIP      => 'VIP圈子',
            VERIFY_JOIN_BLACK    => '已注销',
        );
        
        foreach($VERIFY_JOIN as $key => $value) {
            if($key == $verify_join) {
                return $value;
            }
        }
        return $VERIFY_JOIN[VERIFY_JOIN_NOTSET];
    }
	
	public static function label_role($role) {
		$roles = array(
			USER_UNVERIFIY   => '未审核', 
			USER_OK          => '普通用户', 
			USER_ACE         => '炒股高手', 
			USER_ADVISER     => '投资顾问', 
			USER_ANALYST     => '证券分析师',
			USER_MINGREN	 => '名人堂高手', 
			USER_DISABLED    => '已锁定', 
			USER_CS          => '管理员', 
            USER_MANAGER     => '网站管理员',
			USER_ADMIN       => '超级管理员', 
			USER_EDITOR      => '网站编辑', 
		);
	    $part = explode(',', $role);
	    $part = array_filter($part);
	    $out_put = '';
	    foreach($roles as $key => $value) {
            if(in_array($key, $part)) {
                $out_put .= $value.' ';
            }
        }
        if($out_put != ''){
            return $out_put;
        }
        return $roles[USER_UNVERIFIY];
	}
	
	public static function span_vip($role) {

	    $roles = UserRolesUtils::get_user_roles_arrays($role);
	    
		$goal_roles = array(
			USER_ACE, 
			USER_ADVISER, 
			USER_ANALYST, 
			USER_MINGREN
		);
		
		$output = "";
		
		$link = urls::absolute('/service/76/');
		
		foreach ($goal_roles as $goal_role) {
		    
			if($goal_role == USER_ACE && in_array($goal_role ,$roles)) {
				$output = "<a href=\"{$link}\" target=\"_blank\"><span title=\"认证炒股高手\" class=\"icon-user-v1\"></span></a>";
			}
			if($goal_role == USER_ADVISER && in_array($goal_role ,$roles)) {
				$output = "<a href=\"{$link}\" target=\"_blank\"><span title=\"认证投资顾问\" class=\"icon-user-v2\"></span></a>";
			}
			if($goal_role == USER_ANALYST && in_array($goal_role ,$roles)) {
				$output = "<a href=\"{$link}\" target=\"_blank\"><span title=\"认证分析师\" class=\"icon-user-v3\"></span></a>";
			}
			if($goal_role == USER_MINGREN && in_array($goal_role ,$roles)) {
				$output = "<a href=\"{$link}\" target=\"_blank\"><span title=\"名人堂高手\" class=\"icon-user-v4\"></span></a>";
			}
		    
		}
		return $output;
	}
	
	public static function span_vip_mini($role) {
		
	    $userroles = UserRolesUtils::get_user_roles_arrays($role);
	    
		$roles = array(
			USER_ACE, 
			USER_ADVISER, 
			USER_ANALYST, 
			USER_MINGREN
		);
		
		$output = "";
		
		foreach ($roles as $value) {
		    if($value == USER_ACE && in_array($value ,$userroles)) {
				$output = "<span title=\"认证炒股高手\" class=\"icon\">&nbsp;</span>";
			}
			if($value == USER_ADVISER && in_array($value ,$userroles)){
				$output = "<span title=\"认证投资顾问\" class=\"icon1\">&nbsp;</span>";
			}
			if($value == USER_ANALYST && in_array($value ,$userroles)){
				$output = "<span title=\"认证分析师\" class=\"icon2\">&nbsp;</span>";
			}
			if($value == USER_MINGREN && in_array($value ,$userroles)){
				$output = "<span title=\"名人堂高手\" class=\"icon3\">&nbsp;</span>";
			}
		}
		return $output;
	}
	
	public static function buddy_vip($role) {
		$output = "";
		
		$roles = is_array($role) ? $role : explode(',', $role);
		
		if(UserRolesUtils::is_vip_user($role)) {
			if(in_array(USER_ACE, $roles)) {
//				$output = "<span title=\"认证炒股高手\" class=\"logo_v1_$size\">&nbsp;</span>";
				$output = "<span title=\"认证炒股高手\" class=\"" . USER_ACE . "\">&nbsp;</span>";
			}
			if(in_array(USER_ADVISER, $roles)){
//				$output = "<span title=\"认证投资顾问\" class=\"logo_v2_$size\">&nbsp;</span>";
				$output = '<span title="认证投资顾问" class="'.USER_ADVISER.'">&nbsp;</span>';
			}
			if(in_array(USER_ANALYST, $roles)){
//				$output = "<span title=\"认证分析师\" class=\"logo_v3_$size\">&nbsp;</span>";
				$output = "<span title=\"认证分析师\" class=\"" . USER_ANALYST . "\">&nbsp;</span>";
			}
			if(in_array(USER_MINGREN, $roles)){
//				$output = "<span title=\"名人堂高手\" class=\"logo_v3_$size\">&nbsp;</span>";
				$output = "<span title=\"名人堂高手\" class=\"" . USER_MINGREN . "\">&nbsp;</span>";
			}
		}
		return $output;
	}
	public static function buddy_vip_card($role, $class = '') {
		$output = "";
		
		$roles = is_array($role) ? $role : explode(',', $role);
		
		if(UserRolesUtils::is_vip_card($roles)) {
			if(in_array(USER_VIP, $roles)){
//				$output = "<span title=\"名人堂高手\" class=\"logo_v3_$size\">&nbsp;</span>";
				$output .= "<b title=\"VIP会员\" class=\"" . $class . "\">&nbsp;</b>";
			}
		}
		
		return $output;
	}
	
	public static function buddy($user, $options = false) {
		if($user == false) return ;
		if($options == false) $options = array();
		
		$size = 'medium';
		if(array_key_exists('size', $options)) {
			$size = $options['size'];
		}
	
		$style = '';
		if(array_key_exists('style', $options)) {
			$style = 'style="'.$options['style'].'"';
		}
		if (isset($options['url'])) {
			$user_link = $options['url'];
		} else{
			$user_link = urls::user($user);
		}
		
		$target = '';
		if (isset($options['target'])) {
            $target = $options['target'];
        }
        
        $id = '';
		if (isset($options['id'])) {
            $id = $options['id'];
        }
        
        $card = " usercard";
		if(array_key_exists('card', $options) && !$options['card']) {
			$card = "";
		}
		
		$user_image = urls::buddyicon($user);
		
		//用户角色显示
        $icon_role = 'common';
        if(array_key_exists('icon_role', $options)) {
           $icon_role = $options['icon_role'];
        }
        $icon_roles = array('system', 'manager');
        
        if(in_array($icon_role, $icon_roles)) {
            $user_link = Urls::absolute();
            $user->nickname = '资本魔方';
            $user_image = '/img/admin.gif';
        }
        
        $alt = $user->nickname . '的头像';
        if (isset($options['alt'])) {
        	$alt = $options['alt'];
        }

        $title_role = UserRolesUtils::is_vip_user($user->roles) ? '炒股高手 ' . $user->nickname: $user->nickname;
        if (UserRolesUtils::is_vip_card($user->roles)){
            $title_role =  $title_role. '（会员）';
        }
        
        
        $vip_card = UserRolesUtils::is_vip_card($user->roles)  ? 'vip_avatar' : '';
        $vip_class = 'vip';
        if ( ( $size == 'big' || $size == 'large' ) && $vip_card != '') $vip_class = $vip_class . '_' . $size;
        if ( ( $size == 'small' ) && $vip_card != '') $vip_card = $vip_card . '_' . $size;
        
		$output  = "<div class=\"avatar_$size\" $style>";
		$output .=     "<a class=\"avatar$card {$vip_card}\" href=\"$user_link\" title=\"$title_role\" rel=\"$user->user_id\" $target>";
		$output .=         "<img src=\"$user_image\" alt=\"$alt\" $id/>";
		if((!array_key_exists('vip', $options) || $options['vip'] == true) && !array_key_exists('icon_role', $options)) {
		$output .= 	           html::buddy_vip($user->roles);
		}
		//vip
		if($vip_card == 'vip_avatar' && $size != 'small') {
		$output .= 	           html::buddy_vip_card($user->roles, $vip_class);
		}
		$output .=     "</a>";
		if(!array_key_exists('name', $options) || $options['name'] == true) {
	    $output .=     "<a href=\"$user_link\" title=\"$user->nickname\" rel=\"$user->user_id\" class=\"nickname\" $target>$user->nickname</a>";
		}
		$output .= '</div>';
        return $output;
	}
	
	public static function label_gender($gender) {
	    foreach(BaseUtils::$PROFILE_GENDER as $key => $value) {
            if($key == $gender) {
            	return $value;
            }
        }
        return BaseUtils::$PROFILE_GENDER[0];
	}

	public static function label_people_gender($profile)
    {
       if($profile === false) {
       	    return '他';
       }
       foreach(BaseUtils::$PEOPLE_GENDER as $key => $value) {
            if($key == $profile->gender) {
                return $value;
            }
        }
        return BaseUtils::$PEOPLE_GENDER[0];
    }
    
    public static function label_group_privacy_view($group) {
       if($group === false) {
            return '未知';
       }
       foreach(GroupUtils::$PRIVACY_VIEW as $key => $value) {
            if($key == $group->privacy_view) {
                return $value;
            }
        }
        return '未知';
    }
    
    public static function label_group_privacy_view_color($group) {
       if($group === false) {
            return '未知';
       }
       if($group->privacy_view == GROUP_VIEW_YES){
       	    return '<label>公开</label>';
       }
       if($group->privacy_view == GROUP_VIEW_HALF){
            return '<label>半公开</label>';
       }
       if($group->privacy_view == GROUP_VIEW_NO){
            return '<label class="bg-Cred">私密</label>';
       }
       return '未知';
    }
    
    public static function label_stock_deal_action($action) {
        $STOCK_DEAL_ACTION = array(
            STOCK_DEAL_ACTION_CONSIGN_BUY   => '委托买入',
            STOCK_DEAL_ACTION_CONSIGN_SELL  => '委托卖出',
            STOCK_DEAL_ACTION_BUY_IN        => '买入',
            STOCK_DEAL_ACTION_SELL_OUT      => '卖出',
            STOCK_DEAL_ACTION_WITHDRAW_BUY  => '买入撤单',
            STOCK_DEAL_ACTION_WITHDRAW_SELL => '卖出撤单',
        );
        
        foreach($STOCK_DEAL_ACTION as $key => $value) {
            if($key == $action) {
                return $value;
            }
        }
        
        return "未知";
    }
    public static function label_stock_deal_action_common($action) {
        $STOCK_DEAL_ACTION = array(
            STOCK_DEAL_ACTION_CONSIGN_BUY   => '<span class="f-Cred">委托买入</span>',
            STOCK_DEAL_ACTION_CONSIGN_SELL  => '<span class="f-Cgreen">委托卖出</span>',
            STOCK_DEAL_ACTION_BUY_IN        => '<span class="f-Cred">买入</span>',
            STOCK_DEAL_ACTION_SELL_OUT      => '<span class="f-Cgreen">卖出</span>',
            STOCK_DEAL_ACTION_WITHDRAW_BUY  => '<span class="f-Cred">买入撤单</span>',
            STOCK_DEAL_ACTION_WITHDRAW_SELL => '<span class="f-Cgreen">卖出撤单</span>',
        );
        
        foreach($STOCK_DEAL_ACTION as $key => $value) {
            if($key == $action) {
                return $value;
            }
        }
        
        return "未知";
    }
    
    public static function label_percent($number, $color = false, $attach_class = '', $precision = 2) {
         
    	 $output = '<span class="f-Cred ' . $attach_class . '">0.00%</span>';
	     $number = round_pad_zero($number*100, $precision);
	     if($number != 0) {
	        $output = "<span>$output</span>";
	        if($color) {
	           if($number > 0) {
	               $output = '<span class="f-Cred ' . $attach_class . '">+'.$number.'%</span>';
	           } else {
                   $output = '<span class="f-Cgreen ' . $attach_class . '">'.$number.'%</span>';
	           }
	        } else {
	           $output = $number.'%';
	        }
	     }else{
	     	 $output = '<span class="f-C333 ' . $attach_class . '">'.$number.'%</span>';
	     }
	     return $output;
    }
    
   public static function label_round_pad_zero($num, $precision = 2, $color = false) {
        
        $output = '0.00';
        $num = round($num, $precision);
        $num = number_format($num, $precision, ".", ",");
        
        if($num != 0) {
            $output = "<span>$output</span>";
            if($color) {
               if($num > 0) {
                   $output = '<span class="f-Cred">+'.$num.'</span>';
               } else {
                   $output = '<span class="f-Cgreen">'.$num.'</span>';
               }
            } else {
               $output = $num;
            }
         }
         
         return $output;
    }
    
    public static function label_gain($price1, $price2, $volumn = false, $color = false){
         $output = "<span>0</span>";
         $number = $price1 - $price2;
         if($volumn != false)
            $number = $number*$volumn;
         $number = round_pad_zero($number);
         if($color) {
               if($number > 0) {
                   $output = '<span class="f-Cred">+'.$number.'</span>';
               } else {
                   $output = '<span class="f-Cgreen">'.$number.'</span>';
               }
         } else {
            $output = $number;
         }
         return $output;
    }
    
    public static function label_gain_percent($price1, $price2, $color = false){
    	 if($price2 == 0) return '<span class="f-Cgreen">+100%</span>';
         $number = ($price1 - $price2)/$price2;
         return html::label_percent($number, $color);
    }
    
    public static function label_zhangfu_percent($price1, $price2, $color = false){
    	 if($price2 == 0) return '<span>0.00%</span>';
         $number = ($price1 - $price2)/$price2;
         return html::label_percent($number, $color);
    }
    
    public static function label_profile_invest_type($profile) {
        $INVEST_STYLE = array(
            INVEST_STYLE_SPECULATE   => '投机型',
            INVEST_STYLE_INVEST      => '投资型', 
            INVEST_STYLE_STOCKPILE   => '储蓄型', 
        );
        if($profile == false)
            return "未知";
            
        foreach($INVEST_STYLE as $key => $value) {
            if($key == $profile->invest_type) {
                return $value;
            }
        }
        
        return "未知";
    }
    
    public static function label_blog_verify($blog){
    	$BLOG_VERIFY = array(
            BLOG_VERIFY_NOTSET   => '未审核',
            BLOG_VERIFY_NOAUDIT   => '未通过', 
            BLOG_VERIFY_AUDIT   => '已通过', 
        );
        foreach($BLOG_VERIFY as $key => $value) {
            if($key == $blog->blog_verify) {
                return $value;
            }
        }
        return '未审核';
    }
    
    public static function label_match_player_verify($player){
    	$MATCH_PLAYER_VERIFY = array(
            MATCH_PLAYER_VERIFY_NOTSET   => '未审核',
            MATCH_PLAYER_VERIFY_NOAUDIT   => '未通过', 
            MATCH_PLAYER_VERIFY_AUDIT   => '已通过', 
        );
        foreach($MATCH_PLAYER_VERIFY as $key => $value) {
            if($key == $player->verify) {
                return $value;
            }
        }
        return '未审核';
    }
    
    public static function label_match_award_status($record){
    	
    	if(!$record) return '未颁奖';
    	
        $MATCH_AWARD_STATUS = array(
            MATCH_AWARD_STATUS_NOTSET  	=> '未发送', 
            MATCH_AWARD_STATUS_APPLY  	=> '已申请',
            MATCH_AWARD_STATUS_OVER  	=> '已领奖',
            MATCH_AWARD_STATUS_BACK  	=> '已拒绝',
        );
        
        foreach($MATCH_AWARD_STATUS as $key => $value) {
            if($key == $record->status) {
                return $value;
            }
        }
        return '未发送';
    }
    
    public static function label_blog_status($blog){
        $BLOG_STATUS = array(
            BLOG_STATUS_DRAFT   => '草稿',
            BLOG_STATUS_RELEASE  => '发布'
        );
        foreach($BLOG_STATUS as $key => $value) {
            if($key == $blog->blog_status) {
                return $value;
            }
        }
        return '草稿';
    }
    
    public static function label_group_category($group) {
       if($group === false) {
            return '未知';
       }
       foreach(GroupUtils::$CATEGORY_TYPE as $key => $value) {
            if($key == $group->category) {
                return $value;
            }
        }
        return '未知';
    }
    
    public static function label_topic_category($topic) {
       if($topic === false) {
            return '其他';
       }
       foreach(GroupUtils::$TOPIC_CATEGORY as $key => $value) {
            if($key == $topic->category) {
                return $value;
            }
        }
        return '其他';
    }
    
    public static function label_blog_categories($categories, $category_id) {
    	
    	$output = '未分类';
    	foreach ($categories as $category) {
    		if($category->category_id == $category_id) {
    			$output = $category->category_name;
    		}
    	}
    	
    	return $output;
    }
    
    public static function label_suggest_type($suggest_type) {
    	$SUGGEST_TYPE = array(
            SUGGEST_TYPE_BUG   => 'bug反馈、错误报告',
            SUGGEST_TYPE_SUGGEST   => '网站改进建议', 
            SUGGEST_TYPE_FEEDBACK  => '问题反馈', 
            SUGGEST_TYPE_OTHERS  => '其他', 
        );
        
        foreach($SUGGEST_TYPE as $key => $value) {
            if($key == $suggest_type) {
                return $value;
            }
        }
        return '未知';
    }
    
    public static function label_group_roles($role) {
    	$roles = array(
            GROUP_ROLE_CREATOR   => '圈主', 
            GROUP_ROLE_ADMIN   => '管理员', 
            GROUP_ROLE_MEMBER   => '普通用户', 
            GROUP_ROLE_BLACK   => '屏蔽用户', 
        );
        
        foreach($roles as $key => $value) {
            if($key == $role) {
                return $value;
            }
        }
        return $roles[GROUP_ROLE_MEMBER];
    }
    
    public static function label_group_level($commend) {
       if($commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$GROUP_COMMEND_LEVEL as $key => $value) {
            if($key == $commend->group_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_user_commend_level($commend) {
       if($commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$USER_MINGREN_COMMEND_LEVEL as $key => $value) {
            if($key == $commend->user_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_user_commend_type($type) {
        $str = '';
        switch ($type) {
              case 0:
                 $str = '千万实盘首页';
              break;
              case 1:
                 $str = '牛人堂-大赛之星';
              break;
              case 2:
                 $str = '牛人堂-涨停王';
              break;
              case 3:
                 $str = '牛人堂-稳赚王';
              break;
        }
        return $str;
    }
    public static function label_common_level($level) {
       foreach(GroupUtils::$COMMEND_LEVEL as $key => $value) {
            if($key == $level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function lable_group_commends_level ($commend) { //圈子推荐列表<td>推荐类型and等级</td>
       $backstring = '未推荐' ;
       if($commend === false) {
            return $backstring;
       }      
       foreach(GroupUtils::$GROUP_COMMEND_LEVEL as $key => $value) {
            if($key == $commend->group_level) {
                $backstring = $value;
            }
       }
       switch ($commend->block) {
       		case GROUP_COMMEND_BLOCK_INDEX:
       			return  '旧版首页 | ' . $backstring ;
       			break;
	       	case GROUP_COMMEND_BLOCK_RECOMMEND:
	       		return  '推荐圈子 | ' . $backstring ;
	       		break;
			case GROUP_COMMEND_BLOCK_MASTER:
	      		return  '高手圈子 | ' . $backstring ;
	       		break;
	       	case GROUP_COMMEND_BLOCK_HOT:
	       		return  '热门圈子 | ' . $backstring ;
	       		break;
	       	case GROUP_COMMEND_BLOCK_NEW:
	       		return  '最近圈子 | ' . $backstring ;
	       		break;
	       	case GROUP_COMMEND_BLOCK_LIVE_HOT:
	       		return  '直播推荐 | ' . $backstring ;
	       		break;
       }
        return $backstring;
    } 
    
    public static function lable_blog_commends_level ($blog_commend) { //博客推荐列表<td>推荐类型</td>
    	if($blog_commend === false){
    		return  '博文不存在';
    	}
    	
    	switch ($blog_commend->block) {
                		case BLOG_COMMEND_BLOCK_INDEX:
                			return  '网站首页';
                			break;
			            case BLOG_COMMEND_BLOCK_NEW_INDEX_1:
							return '博文最新更新';
							break;
						case BLOG_COMMEND_BLOCK_NEW_INDEX_2:
							return '热门博主文章'; 
							break;
						case BLOG_COMMEND_BLOCK_NEW_INDEX_3:
							return '最新博客文章'; 
							break;
						case BLOG_COMMEND_BLOCK_NEW_INDEX_4:
							return '博文点击榜'; 
							break;	
                		case BLOG_COMMEND_BLOCK_SINGLE:
                			return '圈子首页-个股圈';
                			break;
                		case BLOG_COMMEND_BLOCK_STOCK:
                			return '圈子首页-股票主题圈';
                			break;
                		case BLOG_COMMEND_BLOCK_FUND:
                			return '圈子首页-基金主题圈';
                			break;
                		case BLOG_COMMEND_BLOCK_FUTURES:
                			return '圈子首页-期货主题圈';
                			break;
                	}
    }
    
    public static function lable_mingren_commends_level ($mingren) { //名人推荐等级
	     if($mingren === false){
	    		return  '名人推荐';
	    	}
    	
    	 switch ($mingren->level) {
                		case 0:
                			return  '名人推荐';
                			break;
			            case 1:
							return '一级推荐';
							break;
						case 2:
							return '二级推荐'; 
							break;
						case 3:
							return '三级推荐'; 
							break;
						case 4:
							return '四级推荐'; 
							break;	
                		case 5:
                			return '五级推荐';
                			break;
                		case 6:
                			return '六级推荐';
                			break;
                		case 7:
                			return '七级推荐';
                			break;
                		case 8:
                			return '八级推荐';
                			break;
                 		case 9:
                			return '九级推荐';
                			break;
                		case 10:
                			return '十级推荐';
                			break;
                		case 11:
                			return 'TOP推荐';
                	}
     
     }
   
    
    public static function label_match_topic_level($topic) {
       if($topic === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$GROUP_TOPIC_MATCH_LEVEL as $key => $value) {
            if($key == $topic->topic_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_legend_level($commend) {
       if($commend === false) {
            return '未推荐';
       }
       foreach(LegendUtils::$LEGEND_COMMEND_LEVEL as $key => $value) {
            if($key == $commend->legend_level) {
                return $value;
            }
        }
        return '新推荐';
    }
    
    public static function label_group_user_level($user_commend) {
       if($user_commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$GROUP_USER_COMMEND_LEVEL as $key => $value) {
            if($key == $user_commend->group_user_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_user_level($user_commend) {
       if($user_commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$USER_COMMEND_LEVEL as $key => $value) {
            if($key == $user_commend->user_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_group_chat_level($chat_commend) {
       if($chat_commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$GROUP_CHAT_COMMEND_LEVEL as $key => $value) {
            if($key == $chat_commend->chat_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_blog_level($blog_commend) { //博客等级推荐
       if($blog_commend === false) {
            return '未推荐';
       }
       foreach(GroupUtils::$USER_BLOG_COMMEND_LEVEL as $key => $value) {
            if($key == $blog_commend->blog_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    /*
     * 博客等级推荐 by blog_level
     */
    public static  function lable_blog_level2($blog_level) {
     if($blog_level == 0) {
            return '--';
       }
        foreach(GroupUtils::$USER_BLOG_COMMEND_LEVEL as $key => $value) {
            if($key == $blog_level) {
                return $value;
            }
        }
        return '--';
    }
    
    
    public static function lable_legend_status($legend, $noClass = false, $noTip = false, $attach_class = '') {
        if($legend == false) return;
        if($legend->error == USER_STOCK_LEGEND_ERROR) {
        	return '';
            return '<span class="f-Cred">无效</span>';
        }
        
        if($noClass) {
            $LEGEND_STATUS = array(
                USER_STOCK_LEGEND_NORMAL   => "未开始",
    			USER_STOCK_LEGEND_START    => "进行中",
                USER_STOCK_LEGEND_SUCCESS  => "止盈结束",
    			USER_STOCK_LEGEND_FAIL     => "亏损结束",
    			USER_STOCK_LEGEND_PROFIT   => "盈利结束",
    			USER_STOCK_LEGEND_STOPLOSS => "止损结束",
            );
            
        } else {
            if($noTip) {
                $LEGEND_STATUS = array(
                        USER_STOCK_LEGEND_NORMAL   => "<span class=\"gs-notstart\" title=\"未开始\">&nbsp;</span>",
            			USER_STOCK_LEGEND_START    => "<span class=\"gs-start\"  title=\"进行中\">&nbsp;</span>",
                        USER_STOCK_LEGEND_SUCCESS  => "<span class=\"gs-succeed\"  title=\"止盈结束\">&nbsp;</span>",
            			USER_STOCK_LEGEND_FAIL     => "<span class=\"gs-fail\"  title=\"亏损结束\">&nbsp;</span>",
            			USER_STOCK_LEGEND_PROFIT     => "<span class=\"gs-succeed\"  title=\"盈利结束\">&nbsp;</span>",
            			USER_STOCK_LEGEND_STOPLOSS     => "<span class=\"gs-fail\"  title=\"止损结束\">&nbsp;</span>",
                );
            } else {
                $LEGEND_STATUS = array(
                    USER_STOCK_LEGEND_NORMAL   => "<span class=\"gs-notstart {$attach_class}\">未开始</span>",
        			USER_STOCK_LEGEND_START    => "<span class=\"gs-start {$attach_class}\">进行中</span>",
                    USER_STOCK_LEGEND_SUCCESS  => "<span class=\"gs-succeed {$attach_class}\">止盈结束</span>",
        			USER_STOCK_LEGEND_FAIL     => "<span class=\"gs-fail {$attach_class}\">亏损结束</span>",
        			USER_STOCK_LEGEND_PROFIT     => "<span class=\"gs-succeed {$attach_class}\">盈利结束</span>",
        			USER_STOCK_LEGEND_STOPLOSS     => "<span class=\"gs-fail {$attach_class}\">止损结束</span>",
                );
            }
            
        }
        
        foreach($LEGEND_STATUS as $key => $value) {
            if($key == $legend->status) {
                return $value;
            }
        }
    }
    
    public static function radio_topic_category($name, $checked = null) {
    	$output = '';
        foreach(GroupUtils::$TOPIC_CATEGORY as $key => $value) {
            $output .= '<input id="' . $name . '_' . $key . '" name="' . $name . '" type="radio" value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' checked="checked"';
            }
            $output .= '/><label class="follow" for="' . $name . '_' . $key . '">';
            $output .= $value;
            $output .= '</label>';
            $output .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        return $output;
    }
    
    public static function select_topic_category($id,$is_admin,$checked = null) {
        $output = '<select id="' . $id .'" name="' . $id . '">';
        $output .= '<option value="0">类别</option>';  
        foreach(GroupUtils::$TOPIC_CATEGORY_TYPE_OLD as $key => $value) {
            if($key == 1 && $is_admin == false || ($key < 70 && $key >1) && $key != 40) {
                continue;
            }  
            $output .= '<option value="' . $key . '"';          
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
    }
    
    public static function select_topic_category2($id,$is_admin,$checked = null, $group_id = false) {
        //default
        _require (DOC_ROOT . '/lib/services/group_topic.php');
        $groupmap = array(
            TOPIC_CATEGORY_GROUP_101 => 101,
            TOPIC_CATEGORY_GROUP_102 => 102 
        );
        $nowbreak = false;
        
        $output = '<select id="' . $id .'" name="' . $id . '">';
        
        if (!isset($groupmap[$group_id]) || $is_admin != false ){
            //$output .= '<option value="0">类别</option>';
        }  
        
        foreach(GroupUtils::$TOPIC_CATEGORY_TYPE_2 as $key => $value) {
            
            //特定圈子
            if (isset($groupmap[$group_id])){
                if ($groupmap[$group_id] == $key){
                    $nowbreak = true;
                } else if ($key != 1) {
                    continue;
                }
            }
            //else if ($key != 1 && in_array($key, $groupmap)) {//
            //    continue;
            //}
            
            //公告
            if($key == 1 && $is_admin == false || ($key < 70 && $key >1) && $key != 40) {
                continue;
            }  
            
            $output .= '<option value="' . $key . '"';          
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
            
            if ($nowbreak){ break; };
        }
            
        $output .= '</select>';
        
        return $output;
    }
    
    public static function select_system_topic_category( $name, $category = null)
    {
        $output	= '<select name="' . $name . '">';
        $output.= '		<option value="0">类别</option>';
        $output.= $category == SYSTEM_TOPIC_CATEGORY_NOTICE
        		? '		<option value="' . SYSTEM_TOPIC_CATEGORY_NOTICE . '" selected>公告</option>'
        		: '		<option value="' . SYSTEM_TOPIC_CATEGORY_NOTICE . '">公告</option>'; 
        $output.= $category == SYSTEM_TOPIC_CATEGORY_OTHER
        		? '		<option value="' . SYSTEM_TOPIC_CATEGORY_OTHER . '" selected>其他</option>'
        		: '		<option value="' . SYSTEM_TOPIC_CATEGORY_OTHER . '">其他</option>';    
        $output.= '</select>';
        return $output;
    }
    
    public static function get_system_topic_category( $topic )
    {
    	$category = '其他';
    	switch ($topic->category)
    	{
    		case SYSTEM_TOPIC_CATEGORY_NOTICE:
    			$category = '公告';
    			break;
    		case SYSTEM_TOPIC_CATEGORY_OTHER:
    			$category = '其他';
    			break;
    	}
    	return $category;
    }
    
      public static function get_topic_category( $topic )
    {
    	foreach (GroupUtils::$TOPIC_CATEGORY_TYPE as $key=>$value)
    	{
    		if( $topic->category == $key )
    		{
    			return $value;
    		}
    	}
    	return '';
    }
    
    public static function radio_service_category($name, $checked = null) {
    	$output = '';
        foreach(ServiceUtils::$SERVICE_CATEGORY as $key => $value) {
            $output .= '<input id="' . $name . '_' . $key . '" name="' . $name . '" type="radio" value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' checked="checked"';
            }
            $output .= '/><label class="follow" for="' . $name . '_' . $key . '">';
            $output .= $value;
            $output .= '</label>';
            $output .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        return $output;
    }
    
    public static function label_service_category($service) {
        $output = '其它';
        $categories = ServiceUtils::$SERVICE_LABEL_CATEGORY;
        if($service !== false) {
            $output = $categories[$service->category];
        }
        return $output;
    }
    
    public static function label_service_status($service) {
        $output = '未解决';
        $status = ServiceUtils::$SERVICE_STATUS;
        if($service !== false) {
            $output = $status[$service->status];
        }
        return $output;
    }
    
    public static function label_analytic_app_level($app_commend) {
       if($app_commend === false) {
            return '未推荐';
       }
       
       foreach(AnalyticAppUtils::$USER_ANALYTIC_APP_COMMEND_LEVEL as $key => $value) {
            if($key == $app_commend->app_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_stock_new_level($stock_news_commend) {
       if($stock_news_commend === false) {
            return '未推荐';
       }
       
       foreach(StockNewsUtils::$STOCK_NEWS_COMMEND_LEVEL as $key => $value) {
            if($key == $stock_news_commend->news_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    public static function label_stock_commend_level($stock_commend) {
       if($stock_commend === false) {
            return '未推荐';
       }
       
       foreach(StockUtils::$STOCK_COMMEND_LEVEL as $key => $value) {
            if($key == $stock_commend->symbol_level) {
                return $value;
            }
        }
        return '未推荐';
    }
    
    public static function label_recycle_bin_type($type) {
    	$types = RecycleBinUtils::$RECYCLE_BIN_TYPES;
    	return $types[$type];
    }
    
    public static function label_stock_flow_sub($num1, $num2, $round = false) {
    	$output = 0;
        $number = $num1 - $num2;
        if($number == 0)
        	return "--";
    
        if($round) {
        	$number = round_pad_zero($number);
        }
        if($number > 0) {
        	$output = '<label class="f-Cred">+'.$number.'</label>';
        } else {
        	$output = '<label class="f-Cgreen">'.$number.'</label>';
        }
        return $output;
    }

    public static function label_stock_flow_compare($num1, $num2) {
    	$output = round_pad_zero($num1);
        $number = $num1 - $num2;
        
        if($number == 0)
        	return $output;
        if($number > 0) {
        	$output = '<label class="f-Cred">'.$output.'</label>';
        } else {
        	$output = '<label class="f-Cgreen">'.$output.'</label>';
        }
        return $output;
    }
    public static function label_stock_flow_group_hot($num1, $num2) {
    	$output = '';
        $number = $num1 - $num2;
        
        if($number == 0)
        	return $output;
        if($number > 0) {
        	$output = '<span class="f-Cred">↑</span>';
        } else {
        	$output = '<span class="f-Cgreen">↓</span>';
        }
        return $output;
    }
    
    public static function label_stock_flow_percent($num1, $num2, $color = true) {
    	if($num2 == 0) return "-";
    	$number = $num1/$num2;
    	return html::label_percent($number, $color);
    }
    
    public static function label_stock_flow_div($num1, $num2, $num3) {
    	if($num2 == 0) return;
    	$number = $num1/$num2;
    	if($number == 0)
    		return;
    	return html::label_stock_flow_compare($number, $num3);
    }
    
    public static function label_match_award_category($service) {
        _require(DOC_ROOT . '/lib/services/match_award.php');
        $output = '总榜';
        $categories = MatchUtils::$MATCH_AWARD_CATEGORY;
        if(is_object($service) && array_key_exists($service->category, $categories)) {
            $output = $categories[$service->category];
        }
        return $output;
    }
    
    public static function label_match_award_rank($service, $history) {
        $rank = 0;
        
        if(!is_object($history) || !is_object($history)) {
        	return '';
        }
        
        _require(DOC_ROOT . '/lib/services/match_award.php');
        
    	switch ($service->category) {
    		case MATCH_AWARD_CATEGORY_TOTAL_STUDENT:
    			$rank = $history->total_rank;
    			break;
    		case MATCH_AWARD_CATEGORY_TOTAL:
    			$rank = $history->total_rank;
    			break;
    		case MATCH_AWARD_CATEGORY_DAY:
    			$rank = $history->day_rank;
    			break;
    		case MATCH_AWARD_CATEGORY_WEEK:
    			$rank = $history->week_rank;
    			break;
    		case MATCH_AWARD_CATEGORY_MONTH:
    			$rank = $history->month_rank;
    			break;
    	}
    	
        return $rank;
    }
    
    public static function checkbox_legend_tag($class, $checked = false, $name = 'tag', $go_line = 6) {
        $checkeds = array();
        if($checked != false) $checkeds = explode(',', $checked);
        $output = '';
        foreach(LegendUtils::$LEGEND_TAG as $key => $value) {
            $output .= '<input type="checkbox" name="' . $name . '" class="' . $class . '" value="' . $key . '" id="' . $key . '"';
            if(in_array($key, $checkeds)) {
                $output .=  ' checked="checked"';
            }
            $output .= '/>';
            $output .= '<label for="'. $key .'">';
            $output .= $value;
            $output .= '</label>';
            
            if($key % $go_line == 0) {
                $output .= '<br/>';
            }
        }
        return $output;
    }
    
    public static function a_legend_tag($class, $checked = false, $name = 'tag', $go_line = 6) {
        $checkeds = array();
        if($checked != false) $checkeds = explode(',', $checked);
        $output = '';
        foreach(LegendUtils::$LEGEND_TAG as $key => $value) {
            $output .= '<a href="javascript:void(0);"  name="' . $name . '"' . ' rel="nofollow" rev="' . $key . '" id="tag_' . $key . '" class="' . $class;
            if(in_array($key, $checkeds)) {
                $output .=  ' l-checked';
            }
            $output .= '">';
            $output .= $value;
            $output .= '</a>';
            
            if($key % $go_line == 0) {
                $output .= '<br/>';
            }
        }
        return $output;
    }
    
    public static function li_legend_tag() {
        $checkeds = array();
        $base_url = urls::absolute('/legend/list/?tag=');
        $output = '';
        foreach(LegendUtils::$LEGEND_TAG as $key => $value) {
            $output .= '<a href="' . $base_url . $key . '" target="_blank" title="' . $value . '">';
            $output .= $value;
            $output .= '</a>';
        }
        return $output;
    }
    
    public static function li_legend_commend_condition($type) {
        return isset(LegendUtils::$LEGEND_COMMEND_CONDITIONS[$type]) ? LegendUtils::$LEGEND_COMMEND_CONDITIONS[$type] : '';
    }
    
    public static function select_legend_tag($id, $checked = null, $className = null) {
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        $output .= '<option value="">全部</option>';    
        foreach(LegendUtils::$LEGEND_TAG as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
    }
    
    public static function select_market_trends($id, $checked = null, $className = null) {
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        foreach(MarkettrendUtils::$MATCH_MARKET_TRENDS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
    }

	public static function label_newsfeed_client($client) {
		$NEWSFEED_CLIENTS = array(
            NEWSFEED_CLIENT_BROWSER   		=> '资本魔方',
            NEWSFEED_CLIENT_IPHONE   		=> 'iphone', 
            NEWSFEED_CLIENT_ANDROID   		=> 'Android', 
            NEWSFEED_CLIENT_WINDOWSMOBILE   => 'WindowsMobile', 
            NEWSFEED_CLIENT_SYMBIAN   		=> 'Symbian', 
        );
        foreach($NEWSFEED_CLIENTS as $key => $value) {
            if($key == $client) {
                return $value;
            }
        }
        
        return $NEWSFEED_CLIENTS[NEWSFEED_CLIENT_BROWSER];
	}

	public static function label_market_trends($type) {
	    foreach(LEAGUEUTILS::$MATCH_LEAGUE_COMMEND as $key => $value) {
            if($key == $type) {
                return $value;
            }
        }
        
        return '';
	}
	
	public static function select_website_promotion_types($id, $checked = null, $className = null) {
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        $output .= '<option value="">--选择分类--</option>';    
        foreach(WebPromotionUtils::$WEBSITE_PROMOTION_TYPES as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function openapi_share_extend($openapi_type, $param)
	{
	    $default_txweibo_class = isset($param['default_txweibo_class']) ? $param['default_txweibo_class'] : 'bgtenxun2';
	    $select_txweibo_class = isset($param['select_txweibo_class']) ? $param['select_txweibo_class'] : 'bgtenxun';
	    
	    $default_sinaweibo_class = isset($param['default_sinaweibo_class']) ? $param['default_sinaweibo_class'] : 'bgsinan2';
	    $select_sinaweibo_class = isset($param['select_sinaweibo_class']) ? $param['select_sinaweibo_class'] : 'bgsinan';
	    
		$txweibo_class = !empty($openapi_type) && in_array('txweibo', $openapi_type) ? $select_txweibo_class : $default_txweibo_class;
		$sinaweibo_class = !empty($openapi_type) && in_array('sina', $openapi_type) ? $select_sinaweibo_class : $default_sinaweibo_class;
		
		$scores = isset($param['scores']) ? $param['scores'] : 100;
		
		$output = '<span class="openapi_share">';
	    if(empty($openapi_type) || !in_array('txweibo', $openapi_type)) {
    		$output.= '		<span class="' . $txweibo_class . '" title="一键绑定腾讯微博" openapi_type="txweibo" type="' . $param['type'] . '" ids="' . $param['ids'] . '"><a href="javascript:void(0);">一键绑定(<b>+' . $scores . '积分</b>)</a></span>';
        } else {
    		//$output.= '		<span class="' . $txweibo_class . '" title="一键转发到腾讯微博" openapi_type="txweibo" type="' . $param['type'] . '" ids="' . $param['ids'] . '">一键转发</span>';
        }
	    if(empty($openapi_type) || !in_array('sina', $openapi_type)) {
		    $output.= '		<span class="' . $sinaweibo_class . '" title="一键绑定新浪微博" openapi_type="sina" type="' . $param['type'] . '" ids="' . $param['ids'] . '"><a href="javascript:void(0);">一键绑定(<b>+' . $scores . '积分</b>)</a></span>';
        } else {
    		//$output.= '		<span class="' . $sinaweibo_class . '" title="一键转发到新浪微博" openapi_type="sina" type="' . $param['type'] . '" ids="' . $param['ids'] . '">一键转发</span>';
        }
		
		$output.= '</span>';
		return $output;		
	}
	
	public static function openapi_mix_share($openapi_type, $param)
	{
	    //绑定腾讯微博 按钮样式
	    $default_txweibo_class = isset($param['default_txweibo_class']) ? $param['default_txweibo_class'] : 'bgtenxun';
	    $select_txweibo_class = isset($param['select_txweibo_class']) ? $param['select_txweibo_class'] : 'bgtenxun';
	    
	    //绑定新浪微博 按钮样式
	    $default_sinaweibo_class = isset($param['default_sinaweibo_class']) ? $param['default_sinaweibo_class'] : 'bgsinan';
	    $select_sinaweibo_class = isset($param['select_sinaweibo_class']) ? $param['select_sinaweibo_class'] : 'bgsinan';
	    
		$txweibo_class = !empty($openapi_type) && in_array('txweibo', $openapi_type) ? $select_txweibo_class : $default_txweibo_class;
		$sinaweibo_class = !empty($openapi_type) && in_array('sina', $openapi_type) ? $select_sinaweibo_class : $default_sinaweibo_class;
		
		$is_loggin = isset($param['loggin']) ? $param['loggin'] : true;
		$target = $is_loggin ? '' : 'target="_blank"';//是否弹出新窗口
		
		$scores = isset($param['scores']) ? $param['scores'] : 2;//添加的积分数
    	$share_title = isset($param['title']) ? urlencode($param['title']) : '';//分享的内容
    	$share_url = isset($param['url']) ? $param['url'] : ''; //分享的url
    	$share_pic = isset($param['pic']) ? $param['pic'] : ''; //分享的图片
    	
    	$query_string = "title={$share_title}&url={$share_url}";
    	if(trim($share_pic) != '') {
        	$query_string = "title={$share_title}&url={$share_url}&pic={$share_pic}";
    	}
    	
		$output = '<span class="openapi_share">';
		
        if(!empty($openapi_type) && in_array('txweibo', $openapi_type)) {
    		$output.= '		<span class="' . $txweibo_class . '" title="一键转发到腾讯微博" openapi_type="txweibo" type="' . $param['type'] . '" ids="' . $param['ids'] . '"><a href="javascript:void(0);">分享给好友(<b>+' . $scores . '积分</b>)</a></span>';
        } else {
            //用户未绑定，直接用自行绑定的形式来分享
        	$tqq_url = "http://v.t.qq.com/share/share.php?{$query_string}";
        	
        	$output.= '		<span class="' . $txweibo_class . ' t-share" title="一键转发到腾讯微博" openapi_type="txweibo" type="' . $param['type'] . '" ids="' . $param['ids'] . '">';
        	$output.= "			<a style=\"color:#000;\" href=\"{$tqq_url}\" {$target} id=\"openapi-a-txweibo\">分享给好友(<b>+" . $scores . "积分</b>)</a>";
        	$output.= "		</span>";
        }
        
        if(!empty($openapi_type) && in_array('sina', $openapi_type)) {
    		$output.= '		<span class="' . $sinaweibo_class . '" title="一键转发到新浪微博" openapi_type="sina" type="' . $param['type'] . '" ids="' . $param['ids'] . '"><a href="javascript:void(0);">分享给好友(<b>+' . $scores . '积分</b>)</a></span>';
        } else {
            //用户未绑定，直接用自行绑定的形式来分享
        	$sina_url = "http://v.t.sina.com.cn/share/share.php?{$query_string}";
        	
        	$output.= '		<span class="' . $sinaweibo_class . ' t-share" title="一键转发到新浪微博" openapi_type="sina" type="' . $param['type'] . '" ids="' . $param['ids'] . '">';
        	$output.= "			<a style=\"color:#000;\" href=\"{$sina_url}\" {$target} id=\"openapi-a-sina\">分享给好友(<b>+" . $scores . "积分</b>)</a>";
        	$output.= "		</span>";
        }
        
		$output.= '</span>';
		return $output;		
	}
	
	public static function openapi_share($openapi_type, $param)
	{
	    $sina_bind     = (!empty($openapi_type) && in_array('sina', $openapi_type))    ==  true ? 1 : 0;
	    $txweibo_bind  = (!empty($openapi_type) && in_array('txweibo', $openapi_type)) ==  true ? 1 : 0;
		//$txweibo_class = !empty($openapi_type) && in_array('txweibo', $openapi_type) ? 'txweibo_sel' : 'txweibo';
		//$sinaweibo_class = !empty($openapi_type) && in_array('sina', $openapi_type) ? 'sinaweibo_sel' : 'sinaweibo';
		$txweibo_class = 'txweibo_sel';
		$sinaweibo_class = isset( $param['class']) ? $param['class'] : 'sinaweibo_sel';
		$output = '<span class="openapi_share">';
		//$output.= '		<span class="word">转发到：</span>';
		$output.= '		<span class="' . $txweibo_class . '" title="转发到腾讯微博" openapi_type="txweibo" account_bind=' . $txweibo_bind . '  type="' . $param['type'] . '" ids="' . $param['ids'] . '"></span>';
		if (isset($param['word'])){
		    $output.= '分享到腾讯微博';
		}
		$output.= '		<span class="' . $sinaweibo_class . '" title="转发到新浪微博" openapi_type="sina" account_bind=' . $sina_bind . '  type="' . $param['type'] . '" ids="' . $param['ids'] . '"></span>';
		if (isset($param['word'])){
		    $output.= '分享到新浪微博';
		}
		$output.= '</span>';
		return $output;		
	}
	
	//--- cyw ---
	
	public static function buddy_no_href($user, $options = false) {
		if($user == false) return ;
		if($options == false) $options = array();
		
		$size = 'medium';
		if(array_key_exists('size', $options)) {
			$size = $options['size'];
		}
	
		$style = '';
		if(array_key_exists('style', $options)) {
			$style = 'style="'.$options['style'].'"';
		}
		if (isset($options['url'])) {
			$user_link = $options['url'];
		} else{
			$user_link = urls::user($user);
		}
		
		$target = '';
		if (isset($options['target'])) {
            $target = $options['target'];
        }
        
        $id = '';
		if (isset($options['id'])) {
            $id = $options['id'];
        }
        
        $card = " usercard";
		if(array_key_exists('card', $options) && !$options['card']) {
			$card = "";
		}
		
		$user_image = urls::buddyicon($user);
		
		//用户角色显示
        $icon_role = 'common';
        if(array_key_exists('icon_role', $options)) {
           $icon_role = $options['icon_role'];
        }
        $icon_roles = array('system', 'manager');
        
        if(in_array($icon_role, $icon_roles)) {
            $user_link = Urls::absolute();
            $user->nickname = '资本魔方';
            $user_image = '/img/admin.gif';
        }
        
        $alt = $user->nickname . '的头像';
        if (isset($options['alt'])) {
        	$alt = $options['alt'];
        }

        $title_role = UserRolesUtils::is_vip_user($user->roles) ? '炒股高手 ' . $user->nickname: $user->nickname;
        if (UserRolesUtils::is_vip_card($user->roles)){
            $title_role =  $title_role. '（会员）';
        }
        
        
        $vip_card = UserRolesUtils::is_vip_card($user->roles)  ? 'vip_avatar' : '';
        $vip_class = 'vip';
        if ( ( $size == 'big' || $size == 'large' ) && $vip_card != '') $vip_class = $vip_class . '_' . $size;
        if ( ( $size == 'small' ) && $vip_card != '') $vip_card = $vip_card . '_' . $size;
        
		$output  = "<div class=\"avatar_$size\" $style>";
		$output .=         "<img src=\"$user_image\" alt=\"$alt\" $id/>";
		if(!array_key_exists('name', $options) || $options['name'] == true) {
	    $output .=    $user->nickname;
		}
		$output .= '</div>';
        return $output;
	}
	
	
	public static function nickname_vip_tip($roles, $class = false, $style = false) { //
	    if (UserRolesUtils::is_vip_card($roles)){
	        return '<a ' . $class . ' ' . $style . ' href="http://www.7878.com/zt/vip/" target="_blank"><img style="height: 14px; width: 17px;" src="/img/VIP/V.gif" /></a>';
	    }
	    return ;
	}    
	public static function openapi_share_account($openapi_type, $param) { //new 我的魔方分享

	    $sina_bind     = (!empty($openapi_type) && in_array('sina', $openapi_type))    ==  true ? 1 : 0;
	    $txweibo_bind  = (!empty($openapi_type) && in_array('txweibo', $openapi_type)) ==  true ? 1 : 0;
	    $txweibo_class = 'txweibo_sel';
		$sinaweibo_class = isset( $param['class']) ? $param['class'] : 'sinaweibo_sel';
		
		$output = ' | <a href="javascript:void(0);" class="addweibo">分享';
		$output.= '</a>';
		$output.= '<div class="account_share" style="display:none;">';
		$output.= '<ul>';
		$output.= 	'<li>';
		$output.= 	'<a class="a-sinaweibo" href="javascript:void(0);" openapi_type="sina" account_bind="'. $sina_bind . '"  type="' . $param['type'] . '" ids="' . $param['ids'] .'" class="sinaweibo"><b></b>新浪微博</a>';
		$output.= 	'</li>';
		$output.= 	'<li>';
		$output.= 	'<a class="a-txweibo" href="javascript:void(0);" openapi_type="txweibo" account_bind="'. $txweibo_bind . '"  type="' . $param['type'] . '" ids="' . $param['ids'] .'" class="txweibo"><b></b>腾讯微博</a>';
		$output.= 	'</li>';
		$output.= '</ul>';
		$output.= '</div>';
	
		
		/*
		$output = '<span class="openapi_share">';
		$output.= '		<span class="' . $txweibo_class . '" title="转发到腾讯微博" openapi_type="txweibo" account_bind=' . $txweibo_bind . '  type="' . $param['type'] . '" ids="' . $param['ids'] . '"></span>';
		if (isset($param['word'])){
		    $output.= '腾讯微博';
		}
		$output.= '		<span class="' . $sinaweibo_class . '" title="转发到新浪微博" openapi_type="sina" account_bind=' . $sina_bind . '  type="' . $param['type'] . '" ids="' . $param['ids'] . '"></span>';
		if (isset($param['word'])){
		    $output.= '新浪微博';
		}
		$output.= '</span>';
		*/
		return $output;		
	}
	
	public static function match_all_get_domain($url) {//频道 - 文章url
    	$pattern = '/[\w-]+\.(com|net|org|gov|cc|biz|info|cn|ru|me|info)(\.(cn|hk))*/';
    	preg_match ( $pattern, $url, $matches );
    	if (count ( $matches ) > 0) {
    		return $matches [0];
    	} else {
    		$rs = parse_url ( $url );
    		$main_url = $rs ["host"];
    		if (! strcmp ( long2ip ( sprintf ( "%u", ip2long ( $main_url ) ) ), $main_url )) {
    			return $main_url;
    		} else {
    			$arr = explode ( ".", $main_url );
    			$count = count ( $arr );
    			$endArr = array ("com", "net", "org", "3322" ); //com.cn  net.cn 等情况
    			if (in_array ( $arr [$count - 2], $endArr )) {
    				$domain = $arr [$count - 3] . "." . $arr [$count - 2] . "." . $arr [$count - 1];
    			} else {
    				$domain = $arr [$count - 2] . "." . $arr [$count - 1];
    			}
    			return $domain;
    		}
    	}
    }
    
    public static function match_canuse_card ($value = 1){//比赛 - 参赛用户使用复位卡
        $str = '允许参赛用户使用复位卡';
        if ($value == 0) {
            $str = '不允许参赛用户使用复位卡';
        }     
        return $str;
    }
    
    public static function str2span_red ($str){//str to span red
        $span = '<span style="color:red;">';
        $span .= $str;
        $span .= '</span>';
        
        return $span;
    }
	
	public static function string_active_t ($user, $desc, $url = false, $content) {//我的魔方 - 魔方动态
	    $log = '<a target="_blank" class="active_user" href="' . Urls::user($user) . '" >'.$user->nickname.'</a>'
	    	   .
               $desc 
               .
               '[<a target="_blank" class="active_log"  style="color:#f63;" href="' . $url . '" >' . $content . '</a>]';
               
	    return $log;
	}
	
	public static function match_create_category ($match_award){//比赛 - (award->category)总榜奖|月榜奖|周榜奖|日榜奖
	    $backstr = false;
	    if (is_object($match_award)) {
    	    switch ($match_award->category)
    		{
    			case MATCH_AWARD_CATEGORY_TOTAL:
    				$backstr = '总榜奖';
    				break;
    			case MATCH_AWARD_CATEGORY_MONTH:
    				$backstr = '月榜奖';
    				break;
    			case MATCH_AWARD_CATEGORY_WEEK:
    				$backstr = '周榜奖';
    				break;
    			case MATCH_AWARD_CATEGORY_DAY:
    				$backstr = '日榜奖';
    				break;
    		}
	    }
	    return $backstr;
	}
	
	public static function select_article( $name, $select_value = '' )//频道 - article
	{
		$field = array(
					'type_id' 		=> '类别',
					'category'		=> '外部分类',
					'title' 		=> '标题',
					'source' 		=> '来源',
					'author' 		=> '作者',
					'summary' 		=> '摘要',
					'content' 		=> '内容',
					'tags' 			=> '标签',
					'symbols' 		=> '股票代码',
					'stock_names' 	=> '股票名称',
					'text1'			=> '备用字段1',
					'text2'			=> '备用字段2',
					'created_at'	=> '发布时间',
					'change_at'		=> '编辑时间'
				);
		$output = '<select name="' . $name . '">';
		$output.= '		<option value="text" selected>任意字段</option>';
		foreach ($field as $key=>$value)
		{
			$selected = $select_value == $key ? ' selected ' : ' ';
			$output.= '	<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
		}
		$output.= '</select>';
		return $output;
	}
	
	public static function query_machines( $query_machine, $type = false ) {
	    $output = '';
	    $select_values = explode( ',', $query_machine->select_value );
	    if( $type == false ) {
	        $type = $query_machine->type ;
	    } else {
	        switch ( $type ) {
	            case 'text' :
            	    $output .= '<input type="text" class="placeholder" title="' . $select_values[0] .'" name="' . $query_machine->field . '" />';
            	    return $output;
            	    break;
            	case 'hidden' :
            	    $output .= '<input type="hidden" name="' . $query_machine->field . '" value="' . $query_machine->select_value . '" />';
            	    return $output;
            	    break;
	            case 'select' :
	                $output = '<select name="' . $query_machine->field . '">';
	                $output.= '		<option value="" selected>请选择</option>';
	                
	                if (isset($query_machine->article_name)){
    	                foreach ( $select_values as $key => $select_value ) {
        	                $output.= '		<option value="' . $select_value . '" >' . $query_machine->article_name[$key] . '</option>';
    	                }
	                } else  {
	                    foreach ( $select_values as $key => $select_value ) {
        	                $output.= '		<option value="' . $select_value . '" >' . $select_value . '</option>';
    	                }
	                }
	                
	                $output.= '</select>';
            	    return $output;
            	    break;
	            case 'checkbox':
	                foreach ( $select_values as $select_value ) {
        	            $output .= '<input type="checkbox" name="' . $query_machine->field . '[]" id="' . $query_machine->field . '" value="' . $select_value . '" />' . $select_value;
	                }
            	    return $output;
            	    break;
	            case 'radio':
	                foreach ( $select_values as $select_value ) {
	                    $output .= '<input type="radio" name="' . $query_machine->field . '" id="' . $query_machine->field . '" value="' . $select_value . '" />' . $select_value;
	                }
            	    return $output;
            	    break;
	        }
	    }
	}
	
	public static function select_ask_quicktemplate($id, $ask_templates, $checked = null,$className = null) {

	    $output ='';
	    
	    if (count($ask_templates) > 0) {
	        $output = '<select id="' . $id .'" name="' . $id . '"';
    		if(!is_null($className)) {
    			$output .= ' class="' . $className . '"';
    		}
    		$output .= '>';
	        $output .= '<option value="0">请选择问题进行快速回答</option>';
	        
	        foreach ($ask_templates as $key => $ask_template) {
	            $count = intval($key) + 1 ;
	            $output .= '<option value="' . $count . '"';
    			if(!is_null($checked) && $checked == $key) {
    				$output .=  ' selected="selected"';
    			}
    			$output .= '>';
    			$output .= $ask_template->content;
    			$output .= '</option>';
	        }
	        $output .= '</select>';
	        
	    } else {
	        $output = '
            	        <select id="fastask" class="select_w260" >
							<option value="0">请选择问题进行快速回答</option>
							<option value="1">现在能否介入，适宜做短线还是中长线？</option>
							<option value="2">短期走势，后市如何操作为宜？</option>
							<option value="3">中线走势，后市如何操作为宜？</option>
							<option value="4">能否继续持有？</option>
							<option value="5">能否有望解套？</option>
							<option value="6">现价能否补仓？</option>
            		    </select>
	        		 ';
	    }
		return $output;
	}
	
	public static function select_software_levels($id, $checked = null, $className = null) {
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';   
        foreach(SoftWareUtils::$LEVELS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_site_commend_types($id, $checked = null, $className = null ) {
		
	    $disabled = '';
        if(!is_null($className) && $className == 'disabled') {
            $disabled = ' disabled="disabled" ';
        }
		$output = '<select ' . $disabled . ' id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        _require( DOC_ROOT . '/lib/services/site_commend.php' ); 
        foreach(SiteCommendUtils::$SITECOMMENDNAME as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_common_array($array, $id, $checked = null, $className = null ) {
		
	    $disabled = '';
        if(!is_null($className) && $className == 'disabled') {
            $disabled = ' disabled="disabled" ';
        }
		$output = '<select ' . $disabled . ' id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        foreach($array as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function select_site_commend_types_weibohots($id, $checked = null, $undo = null, $className = null) {
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        _require( DOC_ROOT . '/lib/services/site_commend.php' ); 
        foreach(SiteCommendUtils::$WEIBOCOMMENDNAME as $key => $value) {
            if(!is_null($undo) && $undo == $key) {
                continue;
            }
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
	
	public static function label_jiabin_commend ($commends) {
	    $output='';
	    
	    if ($commends != 0) {
	        $jiabincommends = JiabinCommendUtils::$Commends;
    	    foreach ($commends as $commend) {
    	       $output .= $jiabincommends[$commend->comment_type] . ' ';
    	    }
	    }
	    return $output;
	}
	
	public static function phone_number_shield ($val) {//屏蔽手机号码：158****7803
	     if (is_phone_number($val)){
	         $val=substr($val, 0,3) . '****' . substr($val, -4, 4);
	     }         
	     return $val;
	}
	
    public static function stock_shield($symbol, $options = false) {
         $str  = '';
         if ( $options === false ) {
             $str = utf8_substr($symbol, 0, 3) . '***';
         }      
         return $str;
    }
	
	public static function email_shield ($email) {//屏蔽邮箱：a30805****@163.com
	    
	    $deal_email = explode ( "@", $email );
	    
		$email_len = strlen ( $deal_email [0] );
		if ($email_len > 4) {
			$star = '';
			for($i = 0; $i < $email_len - 4; $i ++) {
				$star .= '*';
			
			}
			$email = substr ( $deal_email [0], 0, 4 ) . $star . '@' . $deal_email [1];
		}
		if ($email_len <= 4 && $email_len != 1) {
			$star = '';
			for($i = $email_len; $i > $email_len - 1; $i --) {
				$star .= '*';
			}
			$email = substr ( $deal_email [0], 0, $email_len - 1 ) . $star . '@' . $deal_email [1];
		}
		
		return $email;
	}
	
	public static function nickname_shield ($nickname) {
	    
	    $callback = '';

		$this_len  = strlen ( $nickname );

        $star = utf8_cutstr($nickname, 1, '');
        $end  = substr ( $nickname, $this_len - 3, $this_len);

        $end = ord($end);
        if ($end >= 224) {  //如果ASCII位高与224，
            $end  = substr ( $nickname, $this_len - 3, $this_len);
        } elseif ($end >= 192) { //如果ASCII位高与192，
            $end  = substr ( $nickname, $this_len - 2, $this_len);
        } else {
            $end  = substr ( $nickname, $this_len - 1, $this_len);
        }
        $callback =  $star . '***' . $end ;
		
		return $callback;
	}
	
	public static function email_addr ($email) {//email_addr
	    
	    $str = '#';
	    
	    $deal_email = explode ( "@", $email );
	    
	    if(isset($deal_email[1])){
	        
	        switch ($deal_email[1]) {
	            case 'gmail':
	                $str = 'http://mail.' . 'google.com';
	            break;
	            
	            default:
        	        $str = 'http://mail.' . $deal_email[1];
	            break;
	        }
	        
	    }
		
		return $str;
	}
	
	public static function get_match_status_show($match){//普通合作赛状态
    	switch ($match->status)
    	{
    		case MATCH_STATUS_WAIT:
    			return '等待审核';
    			break;
    		case MATCH_STATUS_CREATED:
    			if( strtotime( '+1 day', $match->end_at) > time() )
    			{
	    			if( $match->is_audited == MATCH_IS_AUDITED_TRUE )
	    			{
	    				$result = '<span class="f-Cred">进行中</span>';
	    				return $result;
	    			}
    			}
    			else 
    			{
    				return '<span class="f-Cred">已结束</span>';
    			}
    			break;
    		case MATCH_STATUS_STOP:
    			return '<span class="f-Cred">已暂停</span>';
    			break;
    	}
    	return '--';
	}
	
	public static function get_match_review($type){
	    _require (DOC_ROOT . '/lib/services/match_review.php');
    	switch ($type)
    	{
    		case MATCH_REVIEW_TYPE_DAY:
    			return '日榜获奖名单';
    			break;
    		case MATCH_REVIEW_TYPE_WEEK:
    			return '周榜获奖名单';
    			break;
    		case MATCH_REVIEW_TYPE_ALL:
    			return '总榜获奖名单';
    			break;
    		case MATCH_REVIEW_TYPE_DAY2:
    			return '每日赛况分析';
    			break;
    	}
    	return '--';
	}
	
	public static function get_group_join($group, $info = false){//申请加入圈子
	    global $auth;
	    
	    $url = false;
	    
	    _require (DOC_ROOT . '/lib/services/group.php');
        _require (DOC_ROOT . '/lib/services/group_apply.php');
        $group_user = mcc_get_group_user($group->group_id, $auth->id);
        $has_apply = mcc_has_group_apply($group->group_id, $auth->id);
	    
        if (! $group_user) {
		    if ($group->privacy_join == GROUP_JOIN_NOAPPLY || !$auth->is_logged_in()) {
        	    $url = '<a rel="nofollow" class="groupjoin" href="' . urls::group ( $group, '/join/' ) . '" title="申请加入">加入</a>';
			} else {
			     if (!$has_apply) {
			         $url = '<a class="groupjoin" href="' . urls::invite($auth->user, true, '/?type=group&id=' . $group->group_id) . '" title="申请加入">加入</a>';
				 } else {
				     $url = '<a href="javascript:void(0);" title="已申请，待审核">待审核</a>';
				 }
			}
        } else{
            $url = '<a target="_blank" href="'.urls::group ( $group).'" title="已加入">进入</a>';
        }
        
        return $url;
						
	}
	
    public static function select_adplayer_level($id, $commend = false, $className = null) {//广告位

        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
            
        foreach(GroupUtils::$USER_BLOG_COMMEND_LEVEL as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($commend !== false && $commend->blog_level == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
	
    public static function get_adplayer_type ($type){
        $str = '' ;
        switch ($type) {
            case ADPLAYER_GROUP:
                $str = '圈子频道页';
                break;
            case ADPLAYER_INDEX:
                $str =  '网站首页';
                break;
            case ADPLAYER_LEGEND:
                $str =  '牛股频道页';
                break;
            }
        return $str;
    }
	
    public static function get_group_roles ($role){
        $str = '' ;
        switch ($role) {
            case GROUP_ROLE_CREATOR:
                $str = '<strong class="f-12px f-Cred">(圈主)</strong>';
                break;
            case GROUP_ROLE_ADMIN:
                $str =  '<strong class="f-12px f-Cblue ">(管理员)</strong>';
                break;
            }
        return $str;
    }
    
    public static function label_percent2($number, $color = false, $attach_class = '', $format = '') {
         
    	 $output = '<span class="f-Cred ' . $attach_class . '">'.$format.'</span>';
	     $number = round_pad_zero($number*100);
	     if($number != 0) {
	        $output = "<span>$output</span>";
	        if($color) {
	           if($number > 0) {
	               $output = '<span class="f-Cred ' . $attach_class . '">+'.$number.'%</span>';
	           } else {
                   $output = '<span class="f-Cgreen ' . $attach_class . '">'.$number.'%</span>';
	           }
	        } else {
	           $output = $number.'%';
	        }
	     }else{
	     	 $output = '<span class="f-C333 ' . $attach_class . '">'.$format.'</span>';
	     }
	     return $output;
    }

    public static function rank_chance($thisrank, $lastrank, $options = false) {
        
        $str = '';
        $rise = '<span class="Rise">';        
        $down = '<span class="Down">';        
        
        if ($thisrank < $lastrank) {
            return $rise;
        } else  if ($thisrank > $lastrank) {
            return $down;
        }
        
        return $str;
    }
    
    public static function get_legend_status($status){
        $success = '<span class="f-Cred">止盈，成功结束</span>';
        $profit  = '<span class="f-Cred">盈利，成功结束</span>';
        $fileld  = '<span class="f-Cgreen">亏损，失败结束</span>';
        $stoploss  = '<span class="f-Cgreen">止损，失败结束</span>';
        $normal  = '<span>未开始</span>';
        $start   = '<span>进行中</span>';
        
        switch ($status) {
            case 10:
                return $normal;    
            break;
            case 20:
                return $start;
            break;
            case 30:
                return $success;
            break;
            case 40:
                return $fileld;
            break;
            case 50:
                return $profit;
            break;
            case 60:
                return $stoploss;
            break;
        }
        
    }
    
    public static function get_legend_yield_total($legend){
        
        if(!is_object($legend)){return ;}
        
        $s = 0;
        switch ($legend->status) {
            
            case 10:
                return $s;    
            break;
            case 20:
                return $s;
            break;
            case 30:
                $s = $legend->success_price/$legend->price - 1;
                return $s;
            break;
            case 40:
                $s = $legend->close_price/$legend->price -1 ;
                return $s;
            break;
            case 50:
                $s = $legend->close_price/$legend->price -1 ;
                return $s;
            break;
            case 60:
                $s = $legend->stop_position/100;
                return $s;
            break;
        }
    }
    
    public static function label_ad_palyert_time($ad){
        
        if(!is_object($ad)){return ;}
        
        $str = '';
        
        if ($ad->start_time <= time() && $ad->end_time >= time()) {
            $str = '显示时间：' . date('Y-m-d H:i:s', $ad->start_time) . '至' . date('Y-m-d H:i:s', $ad->end_time);
        } else if ( $ad->start_time <= time() && $ad->end_time <= 0 ) {
            $str = '一直显示';
        } else if ( $ad->start_time >= time()){
            $str = '未开始，开始时间：'. date('Y-m-d H:i:s', $ad->start_time);
        } else if ($ad->start_time <= time() && $ad->end_time <= time()){
            $str = '已过期';
        }
        return $str;
    }
    
	public static function select_adplayer_types($id, $checked = null, $className = null) {
		
		$output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        $output .= '<option value="">--选择分类--</option>';    
        foreach(AdplayUtils::$ADPLAY_TYPE_POSITION as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if(!is_null($checked) && $checked == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';
        
        return $output;
	}
    
	public static function label_adplater_type ($ad_type) {
	    $output='';
	    
	    if ($ad_type != '' && $ad_type != 0) {
	        $ads = AdplayUtils::$ADPLAY_TYPE_POSITION;
	        $output = $ads[$ad_type];
	    }
	    return $output;
	}
	
    public static function label_vip_price ($id, $value = false, $type = '魔方宝') {
        $output='';
        
        if ($value == false || $value == 0.00) {
            $value = 0;
        }
        
        $output .= '<a href="' . urls::absolute('/zt/vip/') . '" target="_blank" style="color:red;cursor:pointer;">';
        $output .= '<label style="color:red;cursor:pointer;">';
        $output .= '（会员价：';
        $output .= '<label style="cursor:pointer;" id="'.$id.'" name="'.$id.'">';
        $output .= $value;
        $output .= '</label>';
        $output .= $type;
        $output .= '）';
        $output .= '</label>';
        $output .= '</a>';
        return $output;
    }

    /**
     * [group_topic_get_footer description]
     * @param  [type] $topic [description]
     * @return [type]        [description]
     */
	public static function group_topic_get_footer ($topic, $type = 'topic', $post = false, $build = 0) {
	    $output='';
    
        if ($type == 'topic'){

            if (is_object($topic)){

                $output .= '<a href="javascript:void(0);" rev="top_post_' . $topic->topic_id .'" rel="楼主-' . $topic->user->nickname . '"  title="支持" class="gosupport">支持</a>';
                $output .= ' │ ';
                $output .= '<a href="javascript:void(0);" rev="top_post_' . $topic->topic_id . '" rel="楼主-' . $topic->user->nickname . '" title="反对"  class="gosupport">反对</a>';
                $output .= ' │ ';
                $output .= '<a href="#myrel" rel="' . urls::user($topic->user) . '|' . $topic->user->nickname . '|' . format_date($topic->posted_at, "Y-m-d H:i") . '|' . utf8_cutstr($topic->content, 50) . '" class="goblockquote">引用</a>';
                $output .= ' | ';
                $output .= '<a href="#myrel" class="goreply">回复</a>';
                $jbao = Html::complaint("topic", $topic->group_id . '-' . $topic->topic_id, $topic->author_id);
                if(!empty($jbao)) $output .=  ' │ ' . $jbao;
            }
            
        }

        if ($type == 'post' && $post){

              $output .='<a href="javascript:void(0);"  title="支持" class="gosupport">支持</a>';
              $output .=' │ ';
              $output .='<a href="javascript:void(0);"  title="反对"  class="gosupport">反对</a>';
              $output .=' | ';  
              $output .='<a href="#myrel" rel="' . urls::user($post->user) . '|' . $post->user->nickname . '|' . format_date($post->posted_at, "Y-m-d H:i") . '|' . '' . '" class="goblockquote">引用</a>';
              $output .=' │ ';
              $output .='<a href="#myrel" class="goreply" rev="top_post_' . $post->post_id . '" rel="' .  $build . '楼-' . $post->user->nickname . '">回复</a>';
              if(count($post->replys) > 0) { 
                $output .=' | <a href="javascript:void(0);" class="post_expand">闭合</a>';
              }
              $jbao = Html::complaint("topic_post", $topic->group_id . '-' . $topic->topic_id . '-' . $post->post_id, $post->author_id);
              if (!empty($jbao)) $output .= ' │ ' . $jbao;
        }
        
	    return $output;
	}
	
	//宝盒价格
	public static function get_box_price_exchange ($treasure_box) {
	    global $auth;
    	$showprice = '';

    	_require(DOC_ROOT . '/lib/services/treasure_box.php');
    	
    	if  (is_object($treasure_box)){
        	
            if ( ($treasure_box->auto_public != 0 && $treasure_box->public_at != 0 && $treasure_box->public_at <= time()) ) {
                 $showprice = '公开免费';
            } else  if ($treasure_box->vip_free == TREASURE_BOX_VIP_FREE_TRUE ){
                 $showprice = 'VIP免费';
            } else {
                if ($auth->is_logged_in() &&  $auth->id  == $treasure_box->user_id){
                    $showprice = number_format($treasure_box->mpay_out/100, 2, '.', '');
                }else if ( ($auth->is_logged_in() && UserRolesUtils::is_vip_card($auth->user->roles)) || ($auth->is_logged_in() && substr($auth->user->nickname, 0,3) == "MEM") ){
                    $getprice = mcc_get_user_buy_treasure_box_needmpay($auth->user,$treasure_box);
                    if ($getprice == 0) {
                        $showprice = '免费';
                    } else {
                       if ( ($auth->is_logged_in() && UserRolesUtils::is_vip_card($auth->user->roles)) || ($iseptime > 0) ){
                           $showprice = number_format($getprice/100, 2, '.', '');
                       } else {
                           $showprice = number_format($getprice/100, 2, '.', '');
                       }
                    }
                } else {
                    $showprice = number_format($treasure_box->mpay_out/100, 2, '.', '');
                }
            }
    	}
        
	    return $showprice;
	}

    public static function url_for_seo_prefix ($url, $prefix = ''){
        $link_len = strlen($url);
        $endstr1 = substr($url, $link_len -1 , $link_len);
        $url = $endstr1 == '/' ? $url . $prefix : $url . '/' . $prefix;
        return $url;
    }
	
    
	//cyw end
	
	public static function buddy_small($user, $options = false) {
		if($user == false) return ;
		if($options == false) $options = array();
		
		$size = 'medium';
		if(array_key_exists('size', $options)) {
			$size = $options['size'];
		}
	
		$style = '';
		if(array_key_exists('style', $options)) {
			$style = 'style="'.$options['style'].'"';
		}
		if (isset($options['url'])) {
			$user_link = $options['url'];
		} else{
			$user_link = urls::user($user);
		}
		
		$target = '';
		if (isset($options['target'])) {
            $target = $options['target'];
        }
        
        $id = '';
		if (isset($options['id'])) {
            $id = $options['id'];
        }
        
        $card = " usercard";
		if(array_key_exists('card', $options) && !$options['card']) {
			$card = "";
		}
		
		$user_image = urls::buddyicon($user);
		
		//用户角色显示
        $icon_role = 'common';
        if(array_key_exists('icon_role', $options)) {
           $icon_role = $options['icon_role'];
        }
        $icon_roles = array('system', 'manager');
        
        if(in_array($icon_role, $icon_roles)) {
            $user_link = Urls::absolute();
            $user->nickname = '资本魔方';
            $user_image = '/img/admin.gif';
        }
        
        $alt = $user->nickname . '的头像';
        if (isset($options['alt'])) {
        	$alt = $options['alt'];
        }

        $title_role = UserRolesUtils::is_vip_user($user->roles) ? '炒股高手 ' . $user->nickname: $user->nickname;
        
		$output  = "<div class=\"avatar_$size\" $style>";
		$output .=     "<a class=\"avatar$card\" href=\"$user_link\" title=\"$title_role\" rel=\"$user->user_id\" $target>";
		$output .=         "<img src=\"$user_image\" alt=\"$alt\" $id/>";
		$output .=     "</a>";
		$output .= '</div>';
        return $output;
	}
	
	public static function check_new_group_admins ($user_id, $value, $authority) {
        $output = '';
        $checked = '';
        
        $authority = explode(',', $authority);
        switch ($value) {
            case 3:
                if (is_array($authority)){ 
                    if (in_array(3, $authority)){
                        $checked =  ' checked="checked" ';
                    }
                }
                $output = '<input id="match_' . $user_id . '" name="' . $user_id. '[]" ' . $checked . ' type="checkbox" value="3"> &nbsp;&nbsp;<label for="match_' . $user_id . '">操作模拟账户</label>';
            break;
            case 2:
                if (is_array($authority)){
                    if (in_array(2, $authority)){
                        $checked =  ' checked="checked" ';
                    }
                }
                $output = '<input id="legend_' . $user_id . '" name="' . $user_id. '[]" ' . $checked . ' type="checkbox" value="2"> &nbsp;&nbsp;<label for="legend_' . $user_id . '">管理圈内牛股传说</label>';
            break;
            case 1:
            if (is_array($authority)){
                    if (in_array(1, $authority)){
                        $checked =  ' checked="checked" ';
                    }
                }
                $output = '<input id="live_' . $user_id . '" name="' . $user_id. '[]" ' . $checked . ' type="checkbox" value="1"> &nbsp;&nbsp;<label for="live_' . $user_id . '">管理直播</label>';
            break;
            
        }
        return $output;
    }
	
	public static function label_legend_stat_status($normal_count = 0, $start_count = 0, $success_count = 0, $object = false, $type = 'people') {
        $output = '';
        $number = 0;
        if(!is_object($object)) {
            if($normal_count > 0) {
                $output .= "{$normal_count} 个未开始";
                $number++;
            }
            if($start_count > 0) {
                $output .= " {$start_count} 个进行中";
                $number++;
            }
            if($success_count > 0 && $number < 2) {
                $output .= " {$success_count} 个新验证成功";
            }
        } else {
            $url = '#';
            if($type == 'people') {
                $user = $object;
                $url = urls::user($user, "/legends/");
            } else if($type == 'group'){
                $group = $object;
                $url = urls::group($group, "/legends/");
            }
            $tmp_url = $url;
            if($normal_count > 0) {
                $url = $type == 'people' ? "{$tmp_url}?t=10" : $tmp_url;
                $output .= "<a href=\"{$url}\" target=\"_blank\" style=\"color:#669999;text-decoration:underline;float:none;\" title=\"{$normal_count} 个未开始\">{$normal_count} 个未开始</a>";
                $number++;
            }
            if($start_count > 0) {
                $url = $type == 'people' ? "{$tmp_url}?t=20" : $tmp_url;
                $output .= " &nbsp;<a href=\"{$url}\" target=\"_blank\" style=\"color:#669999;text-decoration:underline;float:none;\" title=\"{$start_count} 个进行中\">{$start_count} 个进行中</a>";
                $number++;
            }
            if($success_count > 0 && $number < 2) {
                $url = $type == 'people' ? "{$tmp_url}?t=30" : $tmp_url;
                $output .= " &nbsp;<a href=\"{$url}\" target=\"_blank\" style=\"color:#669999;text-decoration:underline;float:none;\" title=\"{$success_count} 个新验证成功\">{$success_count} 个新验证成功</a>";
            }
        }
        //$output = utf8_substr($output, 1, strlength($output));
        
        return $output;
    }
    
    public static function lable_user_legend_visitors_log_types($type) {
        
        $type_outputs = array(
                    USER_LEGEND_VISITORS_LOG_TYPE_VIEW       => '浏览',
                    USER_LEGEND_VISITORS_LOG_TYPE_COLLECT    => '收藏',
                    USER_LEGEND_VISITORS_LOG_TYPE_COMMENT    => '评论',
                    USER_LEGEND_VISITORS_LOG_TYPE_SHARE      => '分享',
        
        );
        
        if(array_key_exists($type, $type_outputs)) {
            return $type_outputs[$type];
        }
        
        return '';
    }
    
    public static function label_ask_status_type($ask) {
        $status = is_object($ask) ? $ask->ask_status : $ask;
        
        $array_status = AskStatusUtils::$ASK_STATUS;
        
        if(!is_null($status) && $status >= 0) {
            if(array_key_exists("${status}", $array_status)) {
               $output = '' . $array_status[$status] . '';
            }
        }
        
        return $output;
        
    }
    
    public static function select_one_day_hours($id = '', $current_hour = false) {
        $output = '';
        $output .= '<select name="' . $id . '" id="' . $id . '">';
        for($i = 0; $i <= 23; $i++) {
            $output .= '<option value="' . $i . '"';
            if($current_hour == $i) {
                $output .= 'selected="selected"';
            }
            $output .= '>' . $i . '</option>';
        }
        $output .= '</select>';
        
        return $output;
    }
    
    public static function select_one_minute_seconds($id = '', $current_minute = false) {
        $output = '';
        $output .= '<select name="' . $id . '" id="' . $id . '">';
        for($i = 0; $i <= 59; $i++) {
            $i = $i < 10 ? "0{$i}" : $i;
            $output .= '<option value="' . $i . '"';
            if($current_minute == $i) {
                $output .= 'selected="selected"';
            }
            $output .= '>' . $i . '</option>';
        }
        $output .= '</select>';
        
        return $output;
    }
    
    public static function label_forecast_open_or_close($val) {
        
        $array = ForecastUtils::$FORECAST_OPEN_OR_CLOSE;
        
        return isset($array[$val]) ? $array[$val] : '';
    }
    
    public static function label_forecast_exec_period($val) {
        
        $array = ForecastUtils::$FORECAST_EXEC_PERIODS;
        
        return isset($array[$val]) ? $array[$val] : '';
    }
    
    public static function label_forecast_fees($open_or_close, $fee, $timespan = false) {
        $output = array();
        $times = array(
                    MARKET_FORECAST_IS_OPEN  => array('15:00-20:00-0', '20:01-08:00-0', '08:01-09:15-0'),//次日开盘
                    MARKET_FORECAST_IS_CLOSE => array('09:30-11:30-0', '13:00-14:00-10', '14:01-14:30-20')//当日收盘
        );
        //从默认中匹配
        if(stripos($fee, ';') == false) {
            if(array_key_exists($open_or_close, $times)) {
                foreach ($times[$open_or_close] as $time) {
                    @list($start, $end, $fee) = @explode('-', $time);
                    if($timespan) {
                        if($timespan == "{$start}-{$end}") {
                            $output = $fee;
                            break;
                        }
                        $output = '';//获取默认的时间段的手续费
                    } else {
                        $output[] = array('start' => $start, 'end' => $end, 'fee' => $fee);
                    }
                }
            }
        } else {
            $is_true = false;
            $fees = @explode(';', $fee);
            foreach ($fees as $key=>$tmp_fee) {
                if(stripos($tmp_fee, '-') != false && substr_count($tmp_fee, '-') == 2) {
                    @list($start, $end, $fee) = @explode('-', $tmp_fee);
                    if($timespan) {
                        //如果匹配到了，则直接跳出
                        if($timespan == "{$start}-{$end}") {
                            $output = $fee;
                            break;
                        } else {
                            //匹配不到再匹配默认时间段
                            if(array_key_exists($open_or_close, $times)) {
                                foreach ($times[$open_or_close] as $time) {
                                    @list($start, $end, $fee) = @explode('-', $time);
                                    if($timespan == "{$start}-{$end}") {
                                        $output = $fee;
                                        break;
                                    }
                                }
                            } else {
                                $output = '';//获取给定的时间段的手续费
                            }
                        }
                    } else {
                        $output[] = array('start' => $start, 'end' => $end, 'fee' => $fee);
                    }
                }
            }
        }
        return $output;
    }
    
    //专题
    public static function label_zt_topten_type($type) {
        $type_outputs = array(
                    TOPTEN_TYPE_BLOG       => '十佳博主',
                    TOPTEN_TYPE_ACE        => '十佳高手'
        );
        
         foreach($type_outputs as $key => $value) {
            if($key == $type) {
                return $value;
            }
        }
  
        return '';
    }
    public static function label_zt_topten_status($topten, $flag = false) {
        $output = '' ;
        if ($topten->status == TOPTEN_STATUS_NO && !in_array($topten->user_id, $flag)) {
            $output = '<a style="cursor:pointer" rel="' . $topten->topten_id . '" class="button-y do_apply" />批准</a>';
        } else {
            $output = '已通过';
        }
  
        return $output;
    }
    
    public static function  select_interview_status($id, $apply = false, $className = null) {
        $output = '<select id="' . $id .'" name="' . $id . '"';
        if(!is_null($className)) {
            $output .= ' class="' . $className . '"';
        }
        $output .= '>';
        
        foreach(InterviewUtils::$INTERVIEW_STATUS as $key => $value) {
            $output .= '<option value="' . $key . '"';
            if($apply !== false && $apply->status == $key) {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $value;
            $output .= '</option>';
        }
            
        $output .= '</select>';

        return $output;
    }
    
    public static function label_interview_type($apply) {
        $output = '' ;
        
        if (is_object($apply) ) {
            
            $output = InterviewUtils::$INTERVIEW_TYPE[$apply->type];
        }
  
        return $output;
    }
    
    public static function label_interview_status($apply) {
        $output = '' ;
        
        if (is_object($apply) ) {
            
            $output = InterviewUtils::$INTERVIEW_STATUS[$apply->status];
        }
  
        return $output;
    }
    
    
    
    public static function label_forecast_category_status($status) {
        $output = '' ;
        if ($status == MARKET_FORECAST_IS_STOPED) {
            $output = '<span style="color:red;">已结束</span>';
        } else {
            $output = '<span style="color:green;">进行中</span>';
        }
  
        return $output;
    }
    public static function label_formate_forecast_number($forecast_number, $pad_length = 5) {
        $forecast_number = intval($forecast_number);
        $len = strlength($forecast_number);
        $sub_len = $pad_length - $len;
        $sub_len = $sub_len < 0 ? 0 : $sub_len;
        
        return 'NO.' . str_repeat("0", $sub_len) . $forecast_number;
    }
    public static function label_count_per_scores($scores1, $scores2){
    	 if($scores2 == 0) return 0;
         $number = $scores1/$scores2;
         return ceil($number);
    }
    public static function label_forecast_award_status($status){
         $output = '' ;
        if ($status == MARKET_FORECAST_IS_STOPED) {
            $output = '<span style="color:red;">已发奖</span>';
        } else {
            $output = '<span style="color:green;">未发奖</span>';
        }
        return $output;
    }
    public static function label_forecast_symbols($symbol, $is_manage = false){
        $output = '' ;
        $symbol = strtoupper($symbol);
        $symbols = ForecastUtils::$FORECAST_SYMBOLS;
        
        return array_key_exists($symbol, $symbols) ? ($is_manage ? "{$symbols[$symbol]}({$symbol})" : $symbols[$symbol]) : ($is_manage ? false : '上证');
    }
    public static function label_forecast_award_recycled($is_recycled){
        $output = '' ;
        if ($is_recycled == MARKET_FORECAST_AWARD_RECYCLED_NO) {
            $output = '<span style="color:green;">未收回</span>';
        } else if($is_recycled == MARKET_FORECAST_AWARD_RECYCLED_YES) {
            $output = '<span style="color:red;">已收回</span>';
        }
        return $output;
    }
    public static function label_forecast_send_award_words($category, $type){
        $output = array (
        	            'msg_title'         => '', 
        	            'msg_content'       => '', 
        	            'admin_msg_title'	=> '', 
        	            'admin_msg_content' => '', 
	    );
        
        $send_words = ForecastUtils::$FORECAST_SEND_AWARD_WORDS;
        $recycle_words = ForecastUtils::$FORECAST_RECYCLE_AWARD_WORDS;
        
        if($type == '10') {
            //发奖
            switch ($category) {
                case 'forecast':
                $output = $send_words;
                break;
            }
        } else if($type == '20') {
           //回收
           switch ($category) {
                case 'forecast':
                $output = $recycle_words;
                break;
            }
        }
        return $output;
    }
    
    public static function time2longstr($ts1, $ts2, $prefix = '', $show_year = true, $show_month = true, $show_day = true, $show_hour = true, $show_min = true, $show_second = true) {/*{{{*/
        if (!ctype_digit($ts1))
            $ts1 = strtotime($ts1);
            
        if (!ctype_digit($ts2))
            $ts2 = strtotime($ts2);

        $output = '';
        $diff = $ts1 - $ts2;
        if ($diff <= 0) {
            return '已截止';
        } else if ($diff > 0) {
            $start = 0;
            if($show_year) {
                $y = floor($diff/(3600*24*360));
                if($start || $y ) {
                    $start = 1;
                    $diff -= $y*3600*24*360;
                    $output .= $y."年";
                }
            }
            if($show_month) {
                $m = floor($diff/(3600*24*31));
                if($start || $m) {
                    $start = 1;
                    $diff -= $m*3600*24*31;
                    $output .= $m."月";
                }
            }
            if($show_day) {
                $d = floor($diff/(3600*24));
                if($start || $d) {
                    $start = 1;
                    $diff -= $d*3600*24;
                    $output .= $d."天";
                }
            }
            if($show_hour) {
                $h = floor($diff/(3600));
                if($start || $h) {
                    $start = 1;
                    $diff -= $h*3600;
                    $output .= $h."小时";
                }
            }
            if($show_min ) {
                $s = floor($diff/(60));
                if($start || $s) {
                    $start = 1;
                    $diff -= $s*60;
                    if( $s > 0 )
                    {
                    	$output .= $s."分钟";
                    }
                }
            }
            if($show_second && $diff > 0) {
                $output .= "{$diff}秒";
            }
        }
        return $prefix . $output;
    }/*}}}*/

    
    public static function label_legend_gain_scores( $gain_scores, $gain_mpays ) {
    	$output = '';
    	if($gain_mpays > 0) {
        	$output .= $gain_mpays . '魔方宝';
    	}
    	if($gain_scores > 0) {
    	    if($gain_mpays > 0) {
            	$output .= '+' . $gain_scores . '积分';
    	    } else {
            	$output .= $gain_scores . '积分';
    	    }
    	}
    	return $output;
    }
    
    public static function label_legend_paid_scores( $fee_type, $scores ) {
        _require(DOC_ROOT . '/lib/services/user_stock_legend.php');
    	$output = '';
    	if($fee_type == USER_STOCK_LEGEND_FEE_TYPE_SCORE) {
        	$output .= $scores . '积分';
    	} else if($fee_type == USER_STOCK_LEGEND_FEE_TYPE_MPAY) {
        	$output .= $scores . '魔方宝';
    	}
    	return $output;
    }
    
    public static function get_match_type( $match )
    {
    	if( !is_object($match) ) return false;
    	switch ($match->match_type)
    	{
    		case MATCH_TYPE_PUBLIC:
    			return '公开赛';
    			break;
    		case MATCH_TYPE_INVITE:
    			return '邀请赛';	
    			break;
    	}
    	return '未知';
    }
    
    public static function get_match_init_account_type( $match )
    {
    	if( !is_object($match) ) return false;
    	switch ($match->init_account_type)
    	{
    		case INIT_ACCOUNT_TYPE_QUARTER:
    			return '按季初始化';
    			break;
    	}
    	return '未知';
    }
    
    public static function get_match_apply_field( $apply_require_field )
    {
    	if( empty($apply_require_field) ) return false;
    	$default_field = array(
    				'username'	=> '姓名',
    				'mobile'	=> '手机号码',
    				'email'		=> 'EMAIL'
    			);
    	$result = '';
    	if( !empty($apply_require_field) )
    	{
    		$apply_require_field = explode(",", $apply_require_field);
    		foreach ($apply_require_field as $field)
    		{
    			if( isset($default_field[$field]) )
    			{
    				$result.= $default_field[$field] . '&nbsp;';
    			}
    		}
    	}
    	return $result;
    }
    
    public static function get_match_status( $match )
    {
    	switch ($match->status)
    	{
    		case MATCH_STATUS_WAIT:
    			return '等待审核';
    			break;
    		case MATCH_STATUS_CREATED:
    			if( strtotime( '+1 day', $match->end_at) > time() )
    			{
	    			if( ($match->audit_status == MATCH_AUDIT_STATUS_INIT || $match->audit_status == MATCH_AUDIT_STATUS_REFUSE) && $match->is_audited == MATCH_IS_AUDITED_DEFAULT )
	    			{
	    				$result = '完善比赛主页信息';
	    			}elseif( $match->audit_status == MATCH_AUDIT_STATUS_WAIT && $match->is_audited == MATCH_IS_AUDITED_DEFAULT )
	    			{
	    				$result = '等待比赛主页信息审核';
	    			}elseif( $match->is_audited == MATCH_IS_AUDITED_TRUE )
	    			{
	    				$result = '比赛进行中';
	    				if( $match->audit_status == MATCH_AUDIT_STATUS_INIT || $match->audit_status == MATCH_AUDIT_STATUS_REFUSE )
	    				{
	    					$result.= '(完善比赛主页信息)';
	    				}
	    				elseif( $match->audit_status == MATCH_AUDIT_STATUS_WAIT )
	    				{
	    					$result.= '(等待比赛主页信息审核)';
	    				}
	    				elseif( $match->audit_status == MATCH_AUDIT_STATUS_COMPLETE )
	    				{
	    					$result.= '(审核完成)';
	    				}
	    				return $result;
	    			}
    			}
    			else 
    			{
    				return '比赛已结束';
    			}
    			break;
    		case MATCH_STATUS_STOP:
    			return '比赛已暂停';
    			break;
    		case MATCH_STATUS_REFUSE_CREATE:
    			return '创建比赛申请被拒绝';
    			break;
    	}
    	return '--';
    }
    
    public static function floor_pad_zero($num, $precision = 0) {
		$num = floor($num);
		return number_format($num, $precision, ".", ",");
	}	
	
	public static function t_0pk_win_value( $game, $desc = true )
	{
		if( $game->score )
		{
			$value = $game->score * 1.9;
			return $desc ? $value . '积分' : $value;
		}
		$value = Html::format_exchange($game->mpay) * 1.9;
		return $desc ? $value . '魔方宝' : $value;
	}
	
	public static function t_0pk_time_diff( $time1, $time2 )
	{
		return self::time2longstr($time1, $time2, '', false, false, false, true, true, true);
	}
	
	public static function t_0pk_apply_fee( $game )
	{
		if( !is_object($game) ) return '';
		if( $game->score )
		{
			return $game->score . '积分';
		}
		if( $game->mpay )
		{
			return self::format_exchange($game->mpay) . '魔方宝';
		}
	}
	
	/*************************************** group3 ********************/
	public static function group_ask_level($level)
	{
		$result = '';
		for ($i = 0; $i < $level; $i++)
		{
			$result.= '<li></li>';
		}
		for ($i = 0; $i < 5 - $level; $i++)
		{
			$result.= '<li class="all"></li>';
		}
		return $result;
	}
	
	public static function select_stock_department( $id, $name, $checked = null, $default_value = false ,$className = null, $style = null )
	{
		$categories = array(
						'国信证券股份有限公司深圳泰然九路证券营业部',
						'方正证券股份有限公司杭州延安路证券营业部',
						'中国中投证券有限责任公司无锡清扬路证券营业部',
						'中信证券（浙江）有限责任公司杭州延安路证券营业部',
						'财通证券有限责任公司杭州解放路证券营业部',
						'国信证券股份有限公司深圳红岭中路证券营业部', 
						'五矿证券有限公司深圳金田路证券营业部',
						'华泰证券股份有限公司深圳益田路荣超商务中心证券营业',
						'财通证券有限责任公司绍兴人民中路证券营业部',
						'光大证券股份有限公司宁波解放南路证券营业部',
						'方正证券股份有限公司温州小南路证券营业部',
						'华鑫证券有限责任公司上海茅台路证券营业部',
						'中国国际金融有限公司上海淮海中路证券营业部',
						'西藏同信证券有限责任公司上海东方路证券营业部',
						'财通证券有限责任公司温岭东辉北路证券营业部',
						'财通证券有限责任公司上海漕溪路证券营业部',
						'浙商证券有限责任公司杭州萧山恒隆广场证券营业部',
						'国泰君安证券股份有限公司深圳益田路证券营业部',
						'中信金通证券有限责任公司嵊州时代商务广场营业部',
						'华泰证券股份有限公司深圳深南大道证券营业部'
					);
		$output = '<select id="' . $id .'" name="' . $name . '"';
        if(!is_null($className)) 
        {
            $output .= ' class="' . $className . '"';
        }
        if(!is_null($style)) 
        {
            $output .= ' style="' . $style . '"';
        }
        $output .= '>';
        if($default_value != false) 
        {
            $output .= '<option value="0">' . $default_value . '</option>';
        }
        foreach($categories as $key=>$category) 
        {
            $output .= '<option value="' . $category . '"';
            if(!is_null($checked) && $key) 
            {
                $output .=  ' selected="selected"';
            }
            $output .= '>';
            $output .= $category;
            $output .= '</option>';
        }
        $output .= '</select>';
        return $output;
	}
	
	public static function complaint($type, $target_id, $author_id, $class_name = false, $style = false)
	{
		global $auth;
		if( $auth->id == $author_id ) return '';
		$output = '<span' . ($class_name ? ' class="' . $class_name . '"' : '') . ($style ? ' style="' . $style . '"' : '') . '>';
		$output.= '<a href="javascript:void(0)" type="' . $type . '" rev="' . $target_id . '" rel="' . $author_id . '" class="complaint">举报</a>';
		$output.= '</span>';
		return $output;
	}
	
	public static function complaint_type_name($complaint)
	{
		$positions = array(
					'blog'				=>	'博文',
					'blog_post'			=>	'博文评论',
					'blog_post_reply'	=>	'博文评论的评论',
					'legend'			=>	'牛股传说',
					'legend_post'		=>	'牛股传说评论',
					'legend_post_reply'	=>	'牛股传说评论的评论',
					'question'			=>	'股票问答',
					'question_post'		=>	'股票问答回复',
					'topic'				=>	'圈子话题',
					'topic_post'		=>	'圈子话题回复',
					'topic_post_reply'	=>	'圈子话题回复的回复',
					'chat'				=>	'圈子直播室',
					'group_chat'		=>	'圈子直播室群聊',
					'webcast'			=>	'视频直播室'
				); 
		return $positions[$complaint->type];
	}
	
	public static function game_name($game, $user)
	{
		if( strlen($game->name) )
		{
			return $game->name;
		}
		return $user->nickname . '创建的比赛';
	}
	
	public static function format_star($len){
	    $output = '';
	    if($len > 0){
	        for($i = 0; $i< $len; $i++){
	            $output .= '*';
	        }    
	    }
	    return $output;	
	}
	
	public static function treasure_box_surplus_sms($treasure_box)
	{
		_require(DOC_ROOT . '/lib/services/user_pay.php');
		return ceil($treasure_box->mpay / (PAY_EXCHANGE * 2)) - $treasure_box->send_sms;
	}
	
	public static function treasure_box_icon_upgrade($treasure_box)
	{
		$html = '';
		if( $treasure_box->vip_free == TREASURE_BOX_VIP_FREE_TRUE )
		{
			$html.= '<span class="vip-free"></span>';
		}
		if( $treasure_box->auto_public != TREASURE_BOX_AUTO_PUBLIC_NO && $treasure_box->public_at < time() )
		{
			$html.= '<span class="ygk"></span>';
		}
		if( time() - $treasure_box->created_at < 3 * 3600 * 24 )
		{
			$html.= '<span class="icon-new"></span>';
		}
		if( date("Y-m-d", $treasure_box->last_updated_at) == date("Y-m-d", time()) )
		{
			$html.= '<span class="icon-upgrade"></span>';
		}
		return $html;
	}
	
	public static function get_treasure_box_class_name( $treasure_box ){
		if( $treasure_box->class == TREASURE_BOX_CLASS_COURSE ){
			return '技术教程';
		}
		if( $treasure_box->class == TREASURE_BOX_CLASS_LOG ){
			return '操盘日志';
		}
		return '未知';
	}
	
	public static function webcast_icon_upgrade($webcast)
	{
		$html = '';
		if( time() - $webcast->created_at < 3 * 3600 * 24 )
		{
			$html.= '<span class="icon-new"></span>';
		}
		if( date("Y-m-d", $webcast->updated_at) == date("Y-m-d", time()) )
		{
			$html.= '<span class="icon-upgrade"></span>';
		}
		return $html;
	}
	
	public static function webcast_user_role_name( $webcast_user ){
		$array = array(
					WEBCAST_USER_ROLE_ORGANIZER => '组织者',
					WEBCAST_USER_ROLE_PANELIST => '嘉宾',
					WEBCAST_USER_ROLE_ATTENDEE => '普通用户',
				);
		return $array[$webcast_user->roles];
	}
	
	public static function select_webcast_long_time($select_id, $select_name, $selected = FALSE, $class_name = ''){
		$long_times = array(
						'1800'	=>	'30分钟',
						'3600'	=>	'1小时',
						'7200'	=>	'2小时',
						'10800'	=>	'3小时',
						'14400'	=>	'4小时',
						'43200'	=>	'12小时'
					);
		$html = '<select id="' . $select_id . '" name="' . $select_name . '" class="' . $class_name . '">';
		foreach ($long_times as $key=>$value){
			$html.= '<option value="' . $key . '"' . ($selected == $key ? ' selected="selected"' : '') . '>' . $value . '</option>';
		}
    	$html.= '</select>';
    	return $html;
	}
	
	public static function get_webcast_user_commend_type_name( $webcast_user_commend ){
		$commend_types = array(
							WEBCAST_USER_COMMEND_TYPE_INDEX	=>	'频道首页',
							WEBCAST_USER_COMMEND_TYPE_SEARCH=>	'频道搜索'
						);
		return $commend_types[$webcast_user_commend->commend_type];
	}
	
	public static function show_webcast_stat($webcast, $show_style = false){
		$class_name = $webcast->status == WEBCAST_STATUS_RUNNING ? 'f-Cf63' : '';
		$result = array(
					WEBCAST_STATUS_NOT_START	=>	'未开始',
					WEBCAST_STATUS_RUNNING	=>	'进行中',
					WEBCAST_STATUS_END	=>	'已结束'					
				);
		if( $webcast->is_stop == WEBCAST_IS_STOP_YES ){
			$stat_name = '已终止';
		}
		else{			
			$stat_name = $result[$webcast->status];
		}
		if( $show_style ){
			return '<span class="' . $class_name . '">(' . $stat_name . ')</span>';
		}
		return $stat_name;
	}
	
	public static function get_vod_level_name( $vod ){
		$level_names = array(
							VOD_LEVEL_ONE	=>	'级别一',
							VOD_LEVEL_TWO	=>	'级别二',
							VOD_LEVEL_THREE	=>	'级别三'
						);
		return isset($level_names[$vod->level]) ? $level_names[$vod->level] : '--';
	}
	
	public static function select_vod_category($select_id, $select_name, $selected = FALSE, $class_name = ''){
		require_once (DOC_ROOT . '/lib/services/vod_category.php');
		$vod_categories = mcc_get_vod_categories();
		$html = '<select id="' . $select_id . '" name="' . $select_name . '" class="' . $class_name . '">';
		foreach ($vod_categories as $vod_category){
			$html.= '<option value="' . $vod_category->category_id . '"' . ($selected == $vod_category->category_id ? ' selected="selected"' : '') . '>' . $vod_category->name . '</option>';
		}
    	$html.= '</select>';
    	return $html;
	}
	public static function select_vod_level($select_id, $select_name, $selected = FALSE, $class_name = ''){
		$level_names = array(
							VOD_LEVEL_ONE	=>	'级别一',
							VOD_LEVEL_TWO	=>	'级别二',
							VOD_LEVEL_THREE	=>	'级别三'
						);
		$html = '<select id="' . $select_id . '" name="' . $select_name . '" class="' . $class_name . '">';
		foreach ($level_names as $key=>$name){
			$html.= '<option value="' . $key . '"' . ($selected == $key ? ' selected="selected"' : '') . '>' . $name . '</option>';
		}
    	$html.= '</select>';
    	return $html;
	}
	public static function vod_user_role_name( $vod_user ){
		$array = array(
					VOD_USER_ROLE_ORGANIZER => '组织者',
					VOD_USER_ROLE_PANELIST => '嘉宾',
					VOD_USER_ROLE_ATTENDEE => '普通用户',
				);
		return $array[$vod_user->roles];
	}
	public static function vod_record_subject( $vod_record ){
		if( !empty($vod_record->description) ){
			return $vod_record->description;
		}
		return $vod_record->subject;
	}
}

?>