<?php /* Smarty version 2.6.26, created on 2017-05-29 14:45:39
         compiled from member/history.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'member/history.tpl', 32, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='reserve';
//$_SESSION['tab']='weekly';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '


'; ?>

</script>
<body>
<div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="main_content">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "member/menu_member.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<!-- <h3>顧客一覧</h3> -->
<h4>個人情報の&nbsp;&nbsp;<a href="/member/edit/?member_id=<?php echo $this->_tpl_vars['memArr']['member_id']; ?>
" class="btn"><i class="fa fa-lg fa-pencil"> </i>&nbsp;編集</a>&nbsp;<a href="/member/history/?member_id=<?php echo $this->_tpl_vars['memArr']['member_id']; ?>
" class="btn"><i class="fa fa-lg fa-history"> </i>&nbsp;履歴</a></h4>

<h4><?php echo $this->_tpl_vars['memArr']['name']; ?>
さんの購入/来店履歴</h4>

		<a href="/member/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;顧客一覧へ戻る</a><br /><br />
		<a href="/reserve/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約一覧へ戻る</a><br />

				<?php $_from = $this->_tpl_vars['buyCourseArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<p class="mt10">
			<form action="" method="post">
			<?php echo $this->_tpl_vars['item']['name']; ?>
購入日：<strong><?php if ($this->_tpl_vars['item']['fee_flg'] == 1): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['buy_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%G/%m/%d") : smarty_modifier_date_format($_tmp, "%G/%m/%d")); ?>
<?php else: ?>未払い<?php endif; ?></strong>&nbsp;&nbsp;&nbsp;
			期限：<strong><?php if ($this->_tpl_vars['item']['fee_flg'] == 1): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['limit_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%G/%m/%d") : smarty_modifier_date_format($_tmp, "%G/%m/%d")); ?>
<?php else: ?>-<?php endif; ?></strong>&nbsp;&nbsp;&nbsp;
			店舗：<strong><?php echo $this->_tpl_vars['item']['shop_name']; ?>
</strong>&nbsp;&nbsp;&nbsp;
			クーポン：<strong><?php echo $this->_tpl_vars['item']['coupon_name']; ?>
</strong>
			<?php if ($this->_tpl_vars['item']['fee_flg'] == 0): ?><input type="submit" name="un_submit" value="未払い削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" /><?php endif; ?>
			<?php if ($this->_tpl_vars['item']['fee_flg'] == 1 && $this->_tpl_vars['item']['rcnt'] == 0): ?><input type="submit" name="submit" value="購入コースの取り消し" onClick="return confirm('コース購入を取り消します。良いでしょうか？');" /><?php endif; ?>
			<input type="hidden" name="buy_no" value="<?php echo $this->_tpl_vars['item']['buy_no']; ?>
" />
			</form>
			</p>

			<table class="admins mt10">
			<tr>
				<th width="80">予約番号</th>
				<!-- <th width="80">detail</th> -->
				<th width="50">予約日</th>
				<th width="80">メニュー名</th>
				<th width="80">use count</th>
				<th width="80">Pre State</th>
				<th width="80">Now State</th>
				<th width="80">時間</th>
<!--  				<th width="80">店舗</th>-->
				<th width="20">来店状況</th>
				<th width="20">担当者</th>
				<th width="20">削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['item']['reserve']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['res']['reserve_no']; ?>
</td>
					<!-- <td><?php echo $this->_tpl_vars['res']['no']; ?>
</td> -->
					<td><?php echo $this->_tpl_vars['res']['insert_date']; ?>
</td>
					<td><?php echo $this->_tpl_vars['res']['menu_name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['res']['use_count']; ?>
</td>
					<td><?php echo $this->_tpl_vars['res']['pre_state']; ?>
</td>
					<td><?php echo $this->_tpl_vars['res']['now_state']; ?>
</td>
					<td>
						<?php echo $this->_tpl_vars['res']['reserve_date']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['res']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

					</td>
					<!-- <td><?php echo $this->_tpl_vars['res']['shop_name']; ?>
</td>-->
					<td>
						<?php if ($this->_tpl_vars['res']['visit_flg'] == 1): ?>
							ご来店
						<?php elseif ($this->_tpl_vars['res']['visit_flg'] == 99): ?>
							キャンセル
						<?php else: ?>
							ご予約中
						<?php endif; ?>
					</td>
					<td><?php echo $this->_tpl_vars['res']['staff_name']; ?>
</td>
					<td>
						<?php if ($this->_tpl_vars['res']['visit_flg'] == 99): ?>
						<form action="" method="post">
							<input type="submit"  name="del" value="削除する" onclick="return confirm('履歴から削除しますが良いですか？');" />
							<input type="hidden" name="detail_no" value="<?php echo $this->_tpl_vars['res']['no']; ?>
">
							<input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['res']['reserve_no']; ?>
">
						</form>
						<?php endif; ?>
					</td>

				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="7">来店履歴はまだありません。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>

			<hr class="mb20">

		<?php endforeach; else: ?>
			ご購入履歴はまだありません
		<?php endif; unset($_from); ?>



	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
