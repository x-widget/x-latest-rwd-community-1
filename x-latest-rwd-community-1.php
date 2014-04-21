<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

widget_css();


$icon_url = widget_data_url( $widget_config['code'], 'icon' );

$file_headers = @get_headers($icon_url);

if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $icon_url = null;
}

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = bo_table(1);

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 10;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);
$title_query = "SELECT bo_subject FROM ".$g5['board_table']." WHERE bo_table = '".$_bo_table."'";
$title = cut_str(db::result( $title_query ),10,"...");
?>


<div class="latest-rwd-community-1">
	<div class='title'>
		<span class='board_subject'>
		<?if( $icon_url ) {?>
			<img src='<?=$icon_url?>'/>
		<?}?>
			<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $_bo_table ?>" class="lt_title"><?=$title?></a>
		</span>
		<span class='latest-more'>
			<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $_bo_table ?>">+ 더보기</a>
		</span>
	</div>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) { ?>
        <li>
            <?php
			echo "<img src='".x::url()."/widget/".$widget_config['name']."/img/square-icon.png'>";
            echo "<a href=\"".$list[$i]['url']."\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];

            echo "</a>";

            ?>
        </li>
    <?php } ?>
    <?php if (count($list) == 0) { //게시물이 없을 때 ?>
		 <li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="javascript:void(0)">현재 회원님께서는</a>
        </li>
		 <li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="javascript:void(0)">필고 모바일테마를</a>
        </li>
		 <li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="javascript:void(0)">사용하고 있습니다.</a>
        </li> 
		<li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="javascript:void(0)">현재 게시판에 등록된</a>
        </li>
		<li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="javascript:void(0)">글은 없습니다.</a>
        </li>
		<li>
			<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
            <a href="<?=url_site_config()?>">게시판 설정바로가기</a>
        </li>		
	<?php } ?>
    </ul>
</div>