<?php   if($this->USER->SHOW_TO_ALL()){    ?>
<div class="row"><div class="col">
	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>
</div></div>    
<?php   }


$xs_tile_no=$ContentData['customselect'][5];
$xs_row_no=$ContentData['custominput'][6];
$xs_tiles=$xs_tile_no*$xs_row_no;
    
$sm_tile_no=$ContentData['customselect'][4];
$sm_row_no=$ContentData['custominput'][5];
$sm_tiles=$sm_tile_no*$sm_row_no;
    
$md_tile_no=$ContentData['customselect'][3];
$md_row_no=$ContentData['custominput'][4];
$md_tiles=$md_tile_no*$md_row_no;
    
$lg_tile_no=$ContentData['customselect'][2];
$lg_row_no=$ContentData['custominput'][3];
$lg_tiles=$lg_tile_no*$lg_row_no;
    
$xl_tile_no=$ContentData['customselect'][1];
$xl_row_no=$ContentData['custominput'][2];
$xl_tiles=$xl_tile_no*$xl_row_no;
        
$max_tiles = array($xs_tiles,$sm_tiles,$md_tiles,$lg_tiles,$xl_tiles);
$max_posts = max($max_tiles);

    $fb_page_id = $ContentData['custominput'][0];	//"995173410545536"; 
    $profile_photo_src = "https://graph.facebook.com/{$fb_page_id}/picture?type=square";

    $access_token = $ContentData['custominput'][1];   //"145407202550348|O4fcoxAX7hT9baoas-_49OFXGlk";

    $fields = "id,message,caption,picture,link,name,description,type,icon,created_time,from,object_id";
    $limit = 100; //$contentrowsfetched[$contentrowscounter]['cContent'];
	
    $json_link = "https://graph.facebook.com/{$fb_page_id}/feed?access_token={$access_token}&fields={$fields}&limit={$limit}"; // 
    $json = file_get_contents($json_link);

    $obj = json_decode($json, true);
    $feed_item_count = count($obj['data']);

    $final_item_count=0;
    $feed_items = array();
    

    for($x=0; $x<$feed_item_count; $x++){
                    
                   /* if(@$obj['data'][$x]['type']!="status" or (@$obj['data'][$x]['type']=="status" and strpos(@$obj['data'][$x]['message'], 'https://instagram.com/')!==false)) {*/
        
                    if(!(@$obj['data'][$x]['type']=="status" and @$obj['data'][$x]['message']=="")){
                        
                        $feed_items[$final_item_count]['type'] = @$obj['data'][$x]['type'];
                        // to get the post id
                        $feed_items[$final_item_count]['id'] = $obj['data'][$x]['id'];
                        $post_id_arr = explode('_', $feed_items[$final_item_count]['id']);
                        $feed_items[$final_item_count]['post_id'] = $post_id_arr[1];

                        // user's custom message
                        $feed_items[$final_item_count]['message'] = @$obj['data'][$x]['message'];
                        $feed_items[$final_item_count]['caption'] = @$obj['data'][$x]['caption'];

                        // picture from the link
                        $feed_items[$final_item_count]['picture'] = @$obj['data'][$x]['picture'];
                        $picture_url_arr = explode('&url=', $feed_items[$final_item_count]['picture']);
                        $feed_items[$final_item_count]['picture_url'] = urldecode(@$picture_url_arr[1]);

                        // link posted
                        $feed_items[$final_item_count]['link'] = @$obj['data'][$x]['link'];

                        // name or title of the link posted
                        $feed_items[$final_item_count]['name'] = @$obj['data'][$x]['name'];

                        $feed_items[$final_item_count]['description'] = @$obj['data'][$x]['description'];

                        // when it was posted
                        $feed_items[$final_item_count]['created_time'] = @$obj['data'][$x]['created_time'];
                        $feed_items[$final_item_count]['converted_date_time'] = date( 'Y-m-d H:i:s', strtotime($feed_items[$final_item_count]['created_time']));
                        $feed_items[$final_item_count]['ago_value'] = time_elapsed_string($feed_items[$final_item_count]['converted_date_time']);

                        // from
                        $feed_items[$final_item_count]['page_name'] = @$obj['data'][$x]['from']['name'];

                        // useful for photo
                        $feed_items[$final_item_count]['object_id'] = @$obj['data'][$x]['object_id'];                    
        
                    $final_item_count++;
                    }
        
    }




?>   
<div class="row core-facebook-wall <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>">
<?php for($i=0;$i<$max_posts;$i++){   
    
    switch($feed_items[$i]['type'])
    {
        case "photo":
            $style="width:100%; height:0; background-image: url('https://graph.facebook.com/".$feed_items[$i]['object_id']."/picture'); background-size: cover; background-repeat: no-repeat; background-position:center; padding-bottom:".$ContentData['customselect'][0]."%;";
            $myicon="<i class='fab fa-facebook-square core-wall-icon-symbol'></i>";
        break;
        case "video":
            $style="background-color:".$ContentData['custominput'][7]."; padding-bottom:".$ContentData['customselect'][0]."%; height:0;"; $myicon="<i class='fab fa-facebook-square core-wall-icon-symbol'></i>";
            
            if (strpos($feed_items[$i]['link'], 'youtu') !== false) { //echo "test";
							$video_type[$feed_items[$i]['link']]="youtube";
							$feed_items[$i]['short_video_link']=substr($feed_items[$i]['link'], -11);
                            $myicon="<i class='fab fa-youtube-square core-wall-icon-symbol'></i>";
							
            } else if (strpos($feed_items[$i]['link'], 'facebook') !== false) { //echo "test";  https://www.facebook.com/paraglidingengadin/videos/1330756586987215/   
                $video_type[$feed_items[$i]['link']]="facebook";
                $feed_items[$i]['short_video_link']=$feed_items[$i]['link'];
                $myicon="<i class='fab fa-facebook-square core-wall-icon-symbol'></i>";

            } else if (strpos($feed_items[$i]['link'], 'instagram') !== false) { //echo "test";  https://www.facebook.com/paraglidingengadin/videos/1330756586987215/   
                $video_type[$feed_items[$i]['link']]="instagram";
                $feed_items[$i]['short_video_link']=$feed_items[$i]['link'];}
                $myicon="<i class='fab fa-instagram core-wall-icon-symbol'></i>";
            
            
        break;
        case "status":
            if(strpos($feed_items[$i]['message'], 'https://instagram.com/')!==false)
            {
            $style="width:100%; height:0; background-image: url('".$feed_items[$i]['message']."media/'); background-size: cover; background-repeat: no-repeat; background-position:center; padding-bottom:".$ContentData['customselect'][0]."%;"; $myicon="<i class='fab fa-instagram core-wall-icon-symbol'></i>";
            } 
            else 
            {
                $style="background-color:".$ContentData['custominput'][7]."; padding-bottom:".$ContentData['customselect'][0]."%; height:0;"; $myicon="<i class='fab fa-facebook-square core-wall-icon-symbol'></i>";
            }
        break;
        default:
            $style="";
            $myicon="<i class='fab fa-facebook-square core-wall-icon-symbol'></i>";
        break;    
    }

    
    ?>    
    <div class="<?php echo " col-".(12/$xs_tile_no)." col-sm-".(12/$sm_tile_no)." col-md-".(12/$md_tile_no)." col-lg-".(12/$lg_tile_no)." col-xl-".(12/$xl_tile_no); ?>
         <?php 
            if($i>$xs_tiles) echo " d-none"; else echo " d-block";
            if($i>$sm_tiles) echo " d-sm-none"; else echo " d-sm-block";   
            if($i>$md_tiles) echo " d-md-none"; else echo " d-md-block";
            if($i>$lg_tiles) echo " d-lg-none"; else echo " d-lg-block";
            if($i>$xl_tiles) echo " d-xl-none"; else echo " d-xl-block";
         ?>
         " >
        <div class="core-facebook-tile" style="<?php echo $style; ?>">
                                                                    
            <?php if($feed_items[$i]['type']!="status" or ($feed_items[$i]['type']=="status" and strpos($feed_items[$i]['message'], 'https://instagram.com/')!==false)){?>
                <div class="core-facebook-overlay" style="padding-bottom:<?php echo $ContentData['customselect'][0]."%;"; ?>" > 
            <?php } ?>
                    <div class="core-facebook-description text-right p-3">
                        <div class="core-facebook-profile-name">
                        <a href='https://fb.com/<?php echo $fb_page_id;?>' target='_blank'><?php echo $feed_items[$i]['page_name']; ?></a><br>shared a 
                        <?php if($feed_items[$i]['type']=="status"){
                                        $feed_items[$i]['link']="https://www.facebook.com/{$fb_page_id}/posts/{".$feed_items[$i]['post_id']."}";
                                    }?>
                        <a href='<?php echo $feed_items[$i]['link'];?>' target='_blank'><?php echo $feed_items[$i]['type']; ?></a>
                        </div>

                        <div class='time-ago'><b><?php echo $feed_items[$i]['ago_value']; ?></b></div><br>
                                                               
                        <?php 
                            
                            if($feed_items[$i]['type']!="photo" and $feed_items[$i]['type']!="video"){ 
                                if(strpos($feed_items[$i]['message'], 'https://instagram.com/')!==false){}else{  ?>                                     
                                   <div class='fb-profile-message'>
                                        <?php $shorter=strpos($feed_items[$i]['message'],"https"); 
                                        if($shorter!=FALSE) echo substr($feed_items[$i]['message'],0,$shorter); 
                                        else {if($feed_items[$i]['type']!="video") echo $feed_items[$i]['message'];} 
                                        if($feed_items[$i]['type']=="video") echo "<br>".$feed_items[$i]['description']." ";
                                        ?>
                                   </div>    
                        <?php } }
                            elseif($feed_items[$i]['type']=="video"){
                            
                                switch($video_type[$feed_items[$i]['link']])
                                {
                                    case "facebook":
                                        ?>
                                              <!-- Your embedded video player code -->
                                              <div class="fb-video" data-href="<?php echo $feed_items[$i]['short_video_link'];?>" data-width="auto" data-show-text="false" style="max-width:95%;">

                                              </div>                       
                                        <?php                       
                                    break;  
                                        
                                    case "instagram":
                                        ?>
                                        <iframe src="<?php echo $feed_items[$i]['short_video_link'];?>embed/" frameborder="0" scrolling="no" allowtransparency="true" style="max-width:95%;"></iframe>
                                        
                                        <?php
                                    break;
                                        
                                    default:
                                        
                                    break;    
                                }
                                
                            
                            }?>
                    </div>
                         
            <?php if($feed_items[$i]['type']!="status" or ($feed_items[$i]['type']=="status" and strpos($feed_items[$i]['message'], 'https://instagram.com/')!==false)){?>             
            </div>
            <?php } ?>                                                                                                                 
            <div class="core-wall-icon"><?php echo $myicon; ?></div> 
        </div>    
    <?php
      //print_r($feed_items);  
    ?>    
    </div>    
<?php } ?>    

</div>
<!-- Load Facebook SDK for JavaScript -->
						  <div id="fb-root"></div>
						  <script>(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
							fjs.parentNode.insertBefore(js, fjs);
						  }(document, 'script', 'facebook-jssdk'));</script>
<?php
	function time_elapsed_string($datetime, $full = false) {
	 
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
	 
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	 
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	 
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
?>
