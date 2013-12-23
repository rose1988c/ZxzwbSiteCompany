<div class="bs-callout bs-callout-info">
      <h4>信息</h4>
</div>

<table class="table table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>昵称</th>
      </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    <?php foreach ((array)$groupMermber as $value) {?>
      <?php foreach ((array)$value as $user) { ?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $user['fakeId'];?></td>
        <td><?php echo $user['nickName'];?></td>
      </tr>
      <?php $i++;?>
    <?php }?>
    <?php $i++;?>
    <?php }?>
    </tbody>
</table>


<div class="bs-callout bs-callout-info">
      <h4>发送</h4>
</div>

<form role="form" action="/api/weixin/send/" method="get">
        <div class="form-group">
          <label for="fid">ID</label>
          <input type="text" class="form-control" id="fid" placeholder="id" name="id">
        </div>
        <div class="form-group">
          <label for="content">content</label>
          <input type="password" class="form-control" id="content" placeholder="content" name="content">
        </div>
        <button type="submit" class="btn btn-default">提交</button>
</form>