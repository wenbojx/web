<div>
    <div class="input-box">
        <li><span>项目名称：</span></li>
        <li>
            <input type="text" tabindex="1" id="project_name">
        </li>
        <li><span>项目简介：</span></li>
        <li>
            <textarea tabindex="2" id="project_desc" style="height:80px;"></textarea>
        </li>
        <li>
            <a style="" class="button" href="javascript:;" onclick="save_project('<?=$this->createUrl('/project/ProjectEdit/DoAdd')?>')">保  存</a>
        </li>
        <li><span id="save_project_msg"></span></li>
    </div>
</div>