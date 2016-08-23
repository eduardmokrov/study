<?php

add_action("admin_init", "posts_init");

function posts_init(){

	add_meta_box("course_options", "Course Options", "course_options", "course", "normal", "high");

	add_meta_box("lesson_options", " Lesson Options", "lesson_options", "lesson", "normal", "high");
	

}



function course_options(){

	global $post ;

	$get_meta = get_post_custom($post->ID);


	
?>	
        <div class="itstudy-option-item">
            <input type="hidden" name="itstudy_hidden_flag" value="true" />	
            <div class="itstudy-option-item">
                    <?php
                    itstudy_post_options(
                            array("name" => "Course type",
                                "id" => "course_type",
                                "type" => "select",
                                "options" => array(
                                    'full' => 'Full Access',
                                    'limited' => 'Limited',
                                )
                    ));
                    ?>
            </div>
            <div class="itstudy-option-item">
                <?php
                    itstudy_post_options(
                            array("name" => "Course Students",
                                "id" => "course_students",
                                "type" => "stud_list",
                    ));
                    ?>
            </div>	
        </div>

  <?php

}



function lesson_options(){

	global $post ;

	$get_meta = get_post_custom($post->ID);

	

?>	




    <div class="itstudy-option-item">

        <input type="hidden" name="itstudy_hidden_flag" value="true" />	

        <div class="itstudy-option-item">


            <?php
            global $post;

            $orig_post = $post;



            $courses = array();

            $custom_course = new WP_Query(array('post_type' => 'course', 'posts_per_page' => -1));

            while ($custom_course->have_posts()) {

                $custom_course->the_post();

                $courses[get_the_ID()] = get_the_title();
            }

            $post = $orig_post;

            wp_reset_postdata();


            itstudy_post_options(
                    array("name" => "Parent Course",
                        "id" => "lesson_parent_course",
                        "type" => "select",
                        "options" => $courses));
            ?>

        </div>	
    </div>

  <?php

}



/*********************************************************************************************/

add_action('save_post', 'save_postdata');

function save_postdata(){



	global $post;

	

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )

		return $post_id;

		

    if (isset($_POST['itstudy_hidden_flag'])) {
		$custom_meta_fields = array(

			'course_type',

			'course_students',

			'lesson_parent_course',

		);


		foreach( $custom_meta_fields as $custom_meta_field ){

			if(isset($_POST[$custom_meta_field]) )

			{

				if(is_array($_POST[$custom_meta_field]))

				{
                                    $s_args = array(
                                        'meta_query'=>array(
                                            'relation' => 'OR',
                                            array(
                                            'key'=>'st_assigned_course',
                                            'value'=>'0'
                                            ),
                                            array(
                                                'key'=>'st_assigned_course',
                                                'value'=>$post->ID,
                                            ),

                                        ));

                                    $s_users = get_users( $s_args ); 

					$ids = '';
                                        foreach($s_users as $s_user){
                                                if(!in_array($s_user->ID, $_POST[$custom_meta_field])){
                                                    update_user_meta($s_user->ID, 'st_assigned_course', '0');
                                                }
                                            }
					foreach($_POST[$custom_meta_field] as $uid){
                                            
                                                
						$ids .= $uid . ",";
                                                if(count($_POST[$custom_meta_field])!==0){
                                                    update_user_meta($uid, 'st_assigned_course', $post->ID);
                                                }
                                                

					}

					$data = substr($ids, 0, -1);
                                        update_post_meta($post->ID, $custom_meta_field, $data);
					

				}

				else

				{

					update_post_meta($post->ID, $custom_meta_field, htmlspecialchars(stripslashes($_POST[$custom_meta_field])) );

				}

			}

			else

			{

				delete_post_meta($post->ID, $custom_meta_field);
                              //  update_user_meta($uid, 'st_assigned_course', '0');

			}

		}

	

	}

}



/*********************************************************/



function itstudy_post_options($value){

	global $post;

?>



	<div class="option-item" id="<?php echo $value['id'] ?>-item">

		<span class="label"><?php  echo $value['name']; ?></span>

	<?php

		$id = isset($value['id']) ? $value['id'] : '';

		$get_meta = get_post_custom($post->ID);

		$meta_box_value = get_post_meta($post->ID, $id, true);

		if( isset( $get_meta[$id][0] ) )

			$current_value = $get_meta[$id][0];

			

	switch ( $value['type'] ) {



		case 'select':

		?>

			<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">

				<?php foreach ($value['options'] as $key => $option) { ?>

				<option value="<?php echo $key ?>" <?php if (isset($current_value) && !empty( $current_value ) && $current_value == $key) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>

				<?php } ?>

			</select>

			<?php if (isset($value ['hint'])):?><a href="#" class="mo-help tooltip" title="<?php echo $value ['hint']?>"></a><?php endif?>

		<?php

		break;

                case 'stud_list':

			// Get the categories first

			$args = array(
                            'role'=>'student',
                            'meta_query'=>array(
                                'relation' => 'OR',
                                array(
                                    'key'=>'st_assigned_course',
                                    'value'=>'0'
                                ),
                                array(
                                   'key'=>'st_assigned_course',
                                   'value'=>$post->ID,
                                ),
                            
                            ));

			$stud_users = get_users( $args ); 

			

			$selected_users = explode( ",", $meta_box_value );

			

			echo '<ul class="student-listing">';



			// Loop through each category
			if(isset($stud_users) && !empty($stud_users)){
				foreach ($stud_users as $stud_user) {
                                   // update_user_meta($stud_user->ID, 'st_assigned_course', '0');
                                   // if(get_user_meta($stud_user->ID, 'st_assigned_course')=='0' || get_user_meta($stud_user->ID, 'st_assigned_course')==$post->ID ){
					if(isset($selected_users) && !empty($selected_users) && isset($stud_user->ID)){
						foreach ($selected_users as $selected_user) {
							if(isset($stud_user->ID) && $selected_user == $stud_user->ID){ $checked = 'checked="checked"'; break; } else { $checked = ""; }
						}
					}
					if(isset($stud_user->ID)){
						echo '<li><input style="width: 14px;" type="checkbox" id="stc' . $stud_user->ID . '" name="' . $value[ 'id' ] . '[]" value="' . $stud_user->ID . '" ' . $checked . ' /><label for="stc'.$stud_user->ID.'" class="inline">' . $stud_user->display_name  . '</label></li>';
					}
                                  //  }
				}
			}
			else{
				echo '<li>No users exist.</li>';
			}

			echo '</ul>';

			if (isset($value ['hint'])):?><a href="#" class="mo-help tooltip" title="<?php echo $value ['hint']?>"></a><?php endif;

		break;
                
		
	} ?>

	</div>

<?php

}

?>