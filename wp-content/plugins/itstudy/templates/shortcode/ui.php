<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$fonturl = 'http://fortawesome.github.io/Font-Awesome/icons/';
$icondir = ITSTUDY_URI.'templates/shortcode/images';
$hintimg = ITSTUDY_URI.'templates/shortcode/images/smicon.png';
?>
<!DOCTYPE html>
<head>
<?php
wp_print_scripts('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
do_action('admin_print_styles');
?>

    <script type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>


    <link rel='stylesheet' href='shortcode.css' type='text/css' media='all' />
<?php $page = isset($_GET['page']) ? htmlentities($_GET['page']) : 'itstudy';
if ($page == 'itstudy') {
    ?>
        <script type="text/javascript">
            var shortcode = {
                e: '',
                init: function (e) {
                    shortcode.e = e;

                },
                insert: function createItstudyShortcode(e, page, dialogwidth, dialogheight) {
                    e.windowManager.open({url: '<?php echo ITSTUDY_URI; ?>/templates/shortcode/ui.php?page=' + page, width: dialogwidth, height: dialogheight});
                    //tinyMCEPopup.execCommand('mceReplaceContent', false, output);
                    //tinyMCEPopup.close();
                },
                quickinsert: function createQuickShortcode(e, tag) {
                    var output = '[' + tag + ']' + '[/' + tag + ']';
                    e.execCommand('mceInsertContent', false, output);
                }
            }
            tinyMCEPopup.onInit.add(shortcode.init, shortcode);
        </script>
        <title>Itstudy shortcodes listing</title>
    </head>
    <body>
        <form id="ItstudyShortcode">
            <a href="javascript:shortcode.insert(shortcode.e, 'question', 600, 200)" class="mo-help tooltip">
                <figure>
                    <img src="<?php echo $icondir ?>/badge.png" alt="Insert a Question" /> 
                    <figcaption>Question</figcaption>
                </figure>
            </a>
        </form>
        <!--/*************************************/ -->
    <?php
} elseif ($page == 'question') {
    ?>
        <script type="text/javascript">
            var AddQuestion = {
                e: '',
                init: function (e) {
                    AddQuestion.e = e;
                    tinyMCEPopup.resizeToInnerSize();
                },
                insert: function createGalleryShortcode(e) {
                    var question = jQuery('#question').val();

                    var output = '[itstudy_question ';


                    if (question) {
                        output += 'question="' + question + '" ';
                    }
                    output += '/]';

                    tinyMCEPopup.execCommand('mceReplaceContent', false, output);
                    tinyMCEPopup.close();

                }
            }
            tinyMCEPopup.onInit.add(AddQuestion.init, AddQuestion);

        </script>
        <title>Add Question</title>

    </head>
    <body>
        <form id="GalleryShortcode">
            <p>
                <label for="question">Write Question</label>
                <input id="question" name="question" type="text" value="" />

            </p>

        </form>
        <div class="mce-foot"><a class="add" href="javascript:AddQuestion.insert(AddQuestion.e)">Insert</a></div>
        <!--/*************************************/ -->

<?php } ?>

</body>
</html>