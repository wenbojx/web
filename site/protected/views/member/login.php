<?php $this->pageTitle=$datas['page']['title'].'---足不出户，畅游中国';?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <h2>足不出户 畅游中国</h2>
    </div>
    <div class="mini-layout">
        <div class="row">
        <div class="span12">
                <div class="span7 offset2">
                <br>
                <form method="post" class="form-horizontal" id="member_login" action="<?=$this->createUrl('/member/login/checkLogin');?>">
                    <fieldset>
                        <legend>用户登陆</legend>
                        <div class="control-group">
                            <label class="control-label" for="login_email">邮箱</label>
                            <div class="controls">
                                <input type="text"  tabindex="1" value="" class="input-xlarge" id="login_email" name="login[email]">
                                <p class="help-block">请输入有效的邮箱 <span id="login_tip_email" style="color_red"></span></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="login_passwd">密码</label>
                            <div class="controls">
                                <input type="password"  tabindex="2" class="input-xlarge"  id="login_passwd" name="login[passwd]">
                                <p class="help-block"><span id="login_tip_passwd" style="color_red"></span></p>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="button" onclick="member.login()">登陆</button>
                            <p class="help-block color_red" id="login_tip_flag"></p>
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
<script>
var login_jump_url = '<?=$this->createUrl('/pano/project');?>';
</script>
