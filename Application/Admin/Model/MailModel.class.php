<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 https://wx.zjliving.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ijry <skipperprivater@gmail.com> <https://wx.zjliving.com>
// +----------------------------------------------------------------------
namespace Admin\Model;
use Think\Model;
/**
 * 邮件管理模型
 * @author ijry <skipperprivater@gmail.com>
 */
class MailModel extends Model {
    /* 自动验证规则 */
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,80', '标题长度不能超过80个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
        array('body', 'require', '邮件内容不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', 'time', self::MODEL_BOTH, 'function'),
    );

    /**
     * 新增或更新一则邮件
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     * @author ijry <skipperprivater@gmail.com>
     */
    public function update(){
        /* 获取数据对象 */
        $data = $this->create($_POST);
        if(empty($data)){
            return false;
        }

        /* 添加或新增邮件 */
        if(empty($data['id'])){ //新增数据
            $id = $this->add(); //添加
            if(!$id){
                $this->error = '新增邮件出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if(false === $status){
                $this->error = '更新邮件出错！';
                return false;
            }
        }

        //内容添加或更新完成
        return $data;
    }
}
