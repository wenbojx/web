<?php $this->pageTitle=$datas['page']['title'].'---足不出户，畅游中国';?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <h2>轻轻松松，全景无忧</h2>
    </div>
    <div class="mini-layout">
        <div class="row-fluid show-grid">
        <div class="span12">
                <div class="span7 offset1">
                <br>
                <form method="post" class="form-horizontal" id="member_reg" action="<?=$this->createUrl('/member/register/reg');?>">
                    <fieldset>
                        <legend>免费注册，轻松制作全景项目</legend>
                        <div class="control-group">
                            <label class="control-label" for="reg_email">邮箱</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="reg_email" name="reg[email]" maxlength="20">
                                <p class="help-block">请输入有效的邮箱 <span id="reg_tip_email" class="color_red"></span></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="reg_passwd">密码</label>
                            <div class="controls">
                                <input type="password" class="input-xlarge" value="" id="reg_passwd" name="reg[passwd]">
                                <p class="help-block">字母，数字皆可 <span id="reg_tip_passwd" class="color_red"></span></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="reg_repasswd">重复密码</label>
                            <div class="controls">
                                <input type="password" class="input-xlarge" value="" id="reg_repasswd" name="reg[repasswd]">
                                <p class="help-block">字母，数字皆可 <span id="reg_tip_repasswd" class="color_red"></span></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="reg_nickname">昵称</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" value="" id="reg_nickname" name="reg[nickname]">
                                <p class="help-block">字母，数字，汉字皆可 <span id="reg_tip_nickname" class="color_red"></span></p>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button class="btn btn-primary" type="button" onclick="member.check_reg()">免费注册</button>
                            <p class="help-block color_red" id="reg_tip_flag"></p>
                        </div>
                    </fieldset>
                    </form>

                <br>
                </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=Yii::app()->baseUrl.'/style/js/member.js'?>"></script>

