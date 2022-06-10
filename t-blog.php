<?php

session_start();

//Initial settings
$prevPostPointer = 0;
$nextPostPointer = 0;
$currentPage = 1;
$prevPage = 0;
$nextPage = 2;
$postsPerPage = 2;
$postPointer = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if(isset($_POST['nextPage']) && !empty($_POST['nextPage'])){
        $GLOBALS['currentPage'] = htmlspecialchars($_POST['nextPage']);
        $GLOBALS['nextPage'] = $GLOBALS['currentPage'] + 1;
        $GLOBALS['postPointer'] = htmlspecialchars($_POST['nextPostPointer']);
        $GLOBALS['prevPage'] = $GLOBALS['currentPage'] - 1;
        $GLOBALS['prevPostPointer'] = $GLOBALS['postPointer'] - $postsPerPage;
    }
    else{
        if(isset($_POST['prevPage']) && !empty($_POST['prevPage'])){
            $GLOBALS['currentPage'] = htmlspecialchars($_POST['prevPage']);
            $GLOBALS['nextPage'] = $GLOBALS['currentPage'] + 1;
            $GLOBALS['prevPage'] = $GLOBALS['currentPage'] -1; 
            $GLOBALS['postPointer'] = htmlspecialchars($_POST['prevPostPointer']);
        }
    }   
}



/* 
================================
@Author: Craig Adams
@Title: t-blog.php
@Date: 31/05/2022
@function: 
   Template for content page. 
   Shows listing of child pages on right 
   Set at max four items listed.
================================
*/

?>
<div class='start container' id="t-blog">

    <div id="bck_03" class="bck">
        <div id="block_03" class="row rowNo03">
            <div id="bluditContent">
                <h1><?php echo $page->title(); ?></h1>
                <?php echo $page->content(); ?>
       
            <section>
            <?php
                //limit the number of posts on the page
                
                if ($page->hasChildren()) {
           
                    //get array
                    $children = $page->children();

                        //list each post
                        for($postCount = 0; $postCount < $GLOBALS['postsPerPage']; $postCount++){
                           
                            echo "
                            <div class='row text-left rowNo02'>
                            ".$GLOBALS['postPointer']."
                                <img src='".$children[$GLOBALS['postPointer']]->coverImage()."' alt='".$children[$GLOBALS['postPointer']]->title()."'>
                                <div>
                                    <h2>".$children[$GLOBALS['postPointer']]->title()."</h2>
                                    <p>".$children[$GLOBALS['postPointer']]->description()."</p>
                                    <a href='".$children[$GLOBALS['postPointer']]->permalink()."' class='btn'>Learn More</a>
                                </div>
                            </div>";  
                         
                            $GLOBALS['postPointer']++;

                        }

                       
                        //add the previous button
                        if($GLOBALS['currentPage'] > 1){
                           
                            echo "<form method='POST' action='".htmlspecialchars($site->url())."blog'>
                            <input type='hidden' name='prevPage' value='".$GLOBALS['prevPage']."'>
                            <input type='hidden' name='prevPostPointer' value='".$GLOBALS['prevPostPointer']."'>
                            <input type='submit' value='&laquo; Previous'></form>";
                        }
                        
                        echo "<span id='currentBlogPage'>Current page: ". $GLOBALS['currentPage']."</span>";

                        //add the next button
                       if(($GLOBALS['currentPage'] * 2) < (count($children))){
                            echo "<form method='POST' action='".htmlspecialchars($site->url())."blog'>
                            <input type='hidden' name='nextPage' value='".$GLOBALS['nextPage']."'>
                            <input type='hidden' name='nextPostPointer' value='".$GLOBALS['postPointer']."'>
                            <input type='submit' value='Next page &raquo;'></form>";
                       }
                        
                    
                }
                 
            ?>
            </section>
           
            </div>
        </div>
    </div>

</div><!-- close start -->

