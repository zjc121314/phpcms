<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

    <form name="myform" id="myform" action="?m=liuyan&c=liuyank&a=listorder" method="post">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('linkid[]');"></th>
                    <th width="38" align="center">字段名</th>
                    <th>留言链接名</th>
                    <th width="12%" align="center">标题</th>
                    <th width="12%" align="center">作者</th>
                    <th width="10%" align="center">内容</th>
                    <th width="8%" align="center">是否审核</th>
                    <th width="12%" align="center">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($infos)) {
                    foreach ($infos as $info) {
                        ?>
                        <tr>
                            <td align="center" width="35">
                                <input type="checkbox" name="linkid[]" value="<?php echo $info['id'] ?>">
                            </td>
                            <td align="center" width="35">
                                <input name='listorders[<?php echo $info['linkid'] ?>]' type='text' size='3' value='<?php echo $info['listorder'] ?>' class="input-text-c">
                            </td>
                            <td><a href="<?php echo $info['url']; ?>" title="<?php echo L('go_website') ?>" target="_blank"><?php echo new_html_special_chars($info['name']) ?></a></td>
                            <td align="center"
                                width="12%"><?php if ($info['linktype'] == 1) { ?><?php if ($info['passed'] == '1') { ?>
                                    <img src="<?php echo $info['logo']; ?>" width=83
                                         height=31><?php } else echo $info['logo'];
                                } ?></td>
                            <td align="center" width="10%"><?php echo $type_arr[$info['typeid']]; ?></td>
                            <td align="center" width="10%"><?php if ($info['linktype'] == 0) {
                                    echo L('word_link');
                                } else {
                                    echo L('logo_link');
                                } ?></td>
                            <td width="8%" align="center"><?php if ($info['passed'] == '0') { ?><a
                                    href='?m=link&c=link&a=check&linkid=<?php echo $info['linkid'] ?>'
                                    onClick="return confirm('<?php echo L('pass_or_not') ?>')"><font
                                        color=red><?php echo L('audit') ?></font></a><?php } else {
                                    echo L('passed');
                                } ?></td>
                            <td align="center" width="12%"><a href="###"
                                                              onclick="edit(<?php echo $info['linkid'] ?>, '<?php echo new_addslashes(new_html_special_chars($info['name'])) ?>')"
                                                              title="<?php echo L('edit') ?>"><?php echo L('edit') ?></a>
                                | <a
                                    href='?m=link&c=link&a=delete&linkid=<?php echo $info['linkid'] ?>'
                                    onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['name'])))) ?>')"><?php echo L('delete') ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="btn">
            <input name="dosubmit" type="submit" class="button"
                   value="<?php echo L('listorder') ?>">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit"
                                                                           onClick="document.myform.action='?m=link&c=link&a=delete'"
                                                                           value="<?php echo L('delete') ?>"/></div>
        <div id="pages"><?php echo $pages ?></div>
    </form>
</div>
<script type="text/javascript">

    function edit(id, name) {
        window.top.art.dialog({id: 'edit'}).close();
        window.top.art.dialog({
            title: '<?php echo L('edit')?> ' + name + ' ',
            id: 'edit',
            iframe: '?m=link&c=link&a=edit&linkid=' + id,
            width: '700',
            height: '450'
        }, function () {
            var d = window.top.art.dialog({id: 'edit'}).data.iframe;
            var form = d.document.getElementById('dosubmit');
            form.click();
            return false;
        }, function () {
            window.top.art.dialog({id: 'edit'}).close()
        });
    }
    function checkuid() {
        var ids = '';
        $("input[name='linkid[]']:checked").each(function (i, n) {
            ids += $(n).val() + ',';
        });
        if (ids == '') {
            window.top.art.dialog({
                content: "<?php echo L('before_select_operations')?>",
                lock: true,
                width: '200',
                height: '50',
                time: 1.5
            }, function () {
            });
            return false;
        } else {
            myform.submit();
        }
    }
    //向下移动
    function listorder_up(id) {
        $.get('?m=link&c=link&a=listorder_up&linkid=' + id, null, function (msg) {
            if (msg == 1) {
                //$("div [id=\'option"+id+"\']").remove();
                alert('<?php echo L('move_success')?>');
            } else {
                alert(msg);
            }
        });
    }
</script>
</body>
</html>
